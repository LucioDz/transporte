<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicosRequisitadosRequest;
use App\Models\Funcionario;
use App\Models\ordem_servico_cheklist;
use App\Models\ordem_servico_imagens;
use App\Models\OrdemServico;
use App\Models\ServicosRequisitados;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdemServicoController extends Controller
{
    public function listar()
    {
        $bases = DB::table('bases')->get();

        $funcionarios = DB::table('funcionarios')->where('id_base', '=',  Auth::user()->funcionario->id_base)->get();
        $veiculos = DB::table('veiculos')->where('id_base', '=',  Auth::user()->funcionario->id_base)->get();
        $checklist = DB::table('checklists')->get();

        $Ordemservico = DB::table('ordem_servico as OS')
            ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'OS.id_funcionario')
            ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
            ->join('bases as base', 'base.id_base', '=', 'supervisor.id_funcionario')
            ->select(
                'OS.*',
                'base.*',
                'veiculos.*',
                'supervisor.id_funcionario as id_supervisor',
                'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                'supervisor.nome as supervisor_nome',
                'supervisor.sobrenome as supervisor_sobrenome',
                'OS.created_at as dataHora',
            )->where('supervisor.id_base', '=',  Auth::user()->funcionario->id_base)
            ->orderBy('OS.id_os', 'DESC')->paginate(10);

        $dados = [
            'bases' => $bases,
            'funcionarios' => $funcionarios,
            'veiculos' =>  $veiculos,
            'checklist' =>  $checklist,
            'Ordemservico' => $Ordemservico
        ];

        return view('OrdemServico.listar', $dados);
    }

    public function criar()
    {
        $base = Funcionario::findOrFail(Auth::user()->id_funcionario);

        $veiculos = DB::table('veiculos')
            ->where('id_base', '=', $base->id_base)
            ->orderBy('prefixo', 'ASC')->get();

        $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

        $dados = [
            'veiculos' => $veiculos,
            'checklists' => $checklist
        ];

        return view('OrdemServico.cadastrar', $dados);
    }

    public function store(Request $receber)
    {
        $rules = [
            'descricao' => ['present'],
            'tipo_os' => ['required'],
            'situacao_os' => ['required'],
            'veiculo' => ['required', 'numeric'],
            'item_check' => ['required', "array"],
            'imagens.*' => ['required', 'image', 'mimetypes:image/jpeg,image/png', 'max:10240'],
        ];

        $messages = [
            'item_check.required' => 'Selecione um item no checklist'
        ];

        $validator = Validator::make($receber->all(), $rules, $messages);

        /// $arquivo = $_FILES['imagens'];

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        } else {
            // se a validação passar, adicionar o serviço aqui
            // ...
            $retorna = [];

            $Ordemservico = new OrdemServico();

            $Ordemservico->tipo_os =  $receber->tipo_os;
            $Ordemservico->situacao_os =  $receber->situacao_os;
            $Ordemservico->id_veiculo =  $receber->veiculo;
            $Ordemservico->descricao_os =  $receber->descricao ?? '';
            $Ordemservico->id_funcionario =  Auth::user()->id_funcionario;

            if ($Ordemservico->save()) {

                $ultimo_id_inserido_os = DB::getPdo()->lastInsertId();

                $veiculo = DB::table('veiculos')->where('id_veiculo', '=', $receber->veiculo)->first();

                if ($receber->hasFile('imagens')) {
                    $imagens = $receber->file('imagens');
                    foreach ($imagens as $imagem) {
                        // Verificando se a imagem foi enviada com sucesso
                        if ($imagem->isValid()) {

                            // Armazenando a imagem no diretório "imagens/ordemServico/[prefixo do veículo]"
                            $caminho = $imagem->store('imagens/ordemServico/' . $veiculo->prefixo);
                            // Salvando o caminho da imagem no banco de dados
                            $OS_imagem = new ordem_servico_imagens();
                            $OS_imagem->caminho_imagem = $caminho;
                            $OS_imagem->id_os = $ultimo_id_inserido_os;
                            $OS_imagem->save();
                        }
                    }
                }

                // convertendo o $receber->servicos em um array
                $servicos_array = json_decode($receber->servicos, true);
                // array_slice ira eliminar a primeira linha
                // a primeira linha contem valores vazios que sao envidos pelo javascript
                // quando o array é criado
                $servicos_sem_primeira_linha = array_slice($servicos_array, 1);

                if (count($servicos_sem_primeira_linha) > 0) {

                    foreach ($servicos_sem_primeira_linha as $serv) {

                        $servico = new ServicosRequisitados();

                        $servico->nome_servico =  $serv['nome'];
                        $servico->descricao =  $serv['descricao'] ?? '';
                        $servico->id_os = $ultimo_id_inserido_os;
                        $servico->save();
                    }
                }

                $tabela_checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();
                $anormalias_registradas = $receber->item_check;

                // precorrendo a tablea checklist para indeficar quias intens quias anormalias/problemas foram indetificadas
                foreach ($tabela_checklist as $ch) {

                    if (in_array($ch->id_checklist,$anormalias_registradas)) {
                        // salvadodo os dados
                        $ordem_servico_cheklist = new ordem_servico_cheklist();
                        $ordem_servico_cheklist->fk_id_item_checklist = $ch->id_checklist;
                        $ordem_servico_cheklist->item_selecionado = 1; // 1 selecionado
                        $ordem_servico_cheklist->fk_id_os = $ultimo_id_inserido_os;
                        $ordem_servico_cheklist->save();
                    } else {
                        $ordem_servico_cheklist = new ordem_servico_cheklist();
                        $ordem_servico_cheklist->fk_id_item_checklist     = $ch->id_checklist;
                        $ordem_servico_cheklist->item_selecionado = 0; // 1 selecionado
                        $ordem_servico_cheklist->fk_id_os = $ultimo_id_inserido_os;
                        $ordem_servico_cheklist->save();
                    }
                }
                
                $retorna = [
                    //'tipo_os' => $receber->tipo_os,
                    //'situacao_os' => $receber->situacao_os,
                    //'veiculo' => $receber->veiculo,
                    //'descricao' => $receber->descricao,
                    'servicos' => $servicos_sem_primeira_linha
                ];

                return response()->json([
                    'success' => true,
                    'servicos' => $servicos_sem_primeira_linha
                ], 200);
            }
        }
    }

    /**    Editar */ ///////// 
    public function editarOS($id)
    {

        $veiculos = DB::table('veiculos')->where('id_base', '=',  Auth::user()->funcionario->id_base)
            ->orderBy('prefixo', 'ASC')->get();

        $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

        $servicos_requesitados = DB::table('servicos_requesitados')->where('id_os', '=', $id)->get();

        $Ordemservico = DB::table('ordem_servico as OS')
            ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'OS.id_funcionario')
            ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
            ->join('bases as base', 'base.id_base', '=', 'supervisor.id_funcionario')
            ->join('municipios', 'municipios.id_municipio', '=', 'base.id_municipio')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select(
                'OS.*',
                'base.*',
                'veiculos.*',
                'municipios.*',
                'provincias.*',
                'supervisor.id_funcionario as id_supervisor',
                'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                'supervisor.nome as supervisor_nome',
                'supervisor.sobrenome as supervisor_sobrenome',
                'OS.created_at as dataHora',
            )->where('OS.id_os', '=', $id)->get();

        $checklist_portaria = DB::table('ordem_servico')
            ->join('ordem_servico_cheklist', 'ordem_servico_cheklist.fk_id_os', '=', 'ordem_servico.id_os')
            ->join('checklists', 'checklists.id_checklist', '=', 'ordem_servico_cheklist.fk_id_item_checklist')
            ->select('ordem_servico.*', 'ordem_servico_cheklist.*', 'checklists.*')->where('ordem_servico.id_os', '=', $id)->get();

        $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

        $dados = [
            'veiculos' => $veiculos,
            'checklists' => $checklist,
            'Ordemservico' => $Ordemservico,
            'servicos_requesitados' => $servicos_requesitados,
            'checklists' => $checklist,
            'ordemservico_checklist' => $checklist_portaria,
            'descriao_checklist' => $checklist_portaria[0]->descricao_os,
            'success' => true,
        ];

        $dados['servicos'] = json_encode($servicos_requesitados);

        return view('OrdemServico.editar', $dados);
    }

    public function ActualizarOS(Request $receber)
    {
        $rules = [
            'descricao' => ['present'],
            'tipo_os' => ['required'],
            'situacao_os' => ['required'],
            'veiculo' => ['required', 'numeric'],
            'item_check' => ['required', "array"],
            'imagens.*' => ['required', 'image', 'mimetypes:image/jpeg,image/png', 'max:10240'],
        ];

        $messages = [
            'item_check.required' => 'Selecione um item no checklist'
        ];

        $validator = Validator::make($receber->all(), $rules, $messages);

        /// $arquivo = $_FILES['imagens'];

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        } else {

            $dados_actulizar = [
                'tipo_os' => $receber->tipo_os,
                'situacao_os' => $receber->situacao_os,
                'descricao_os' =>  $receber->descricao ?? '',
                'id_veiculo' => $receber->veiculo,
            ];

            $ordem_servico = DB::table('ordem_servico')->where('id_os', $receber->id)->update($dados_actulizar);

            //Actulizando servicos da os
            // convertendo o $receber->servicos em um array
            $servicos_array = json_decode($receber->servicos, true);
            // array_slice ira eliminar a primeira linha
            // a primeira linha contem valores vazios que sao envidos pelo javascript
            // quando o array é criado
            $servicos_sem_primeira_linha = array_slice($servicos_array, 1);

            if (count($servicos_sem_primeira_linha) > 0) {

                foreach ($servicos_sem_primeira_linha as $serv) {

                    $dados_servico = [
                        'nome_servico' =>  $serv['nome'],
                        'descricao' => $serv['descricao'] ?? ''
                    ];

                    // verificando se servico ja existe antes de aculizar
                    if (isset($serv['LinhaAdicionadaViaJavascript'])) {

                        $servico = new ServicosRequisitados();
                        $servico->nome_servico =  $serv['nome'];
                        $servico->descricao =  $serv['descricao'] ?? '';
                        $servico->id_os = $receber->id;
                        $servico->save();
                    } else {

                        $TabelaServico = DB::table('servicos_requesitados')
                            ->where('id_servico', $serv['id'])->update($dados_servico);
                    }
                }
            }

            // actulizando o checklist_portaria
            $tabela_checklist = DB::table('ordem_servico_cheklist')->where('fk_id_os', $receber->id)->get('id_os_checklist');
            $anormalias_registradas = $receber->item_check;
            foreach ($tabela_checklist as $ch) {

                if (in_array($ch->id_os_checklist, $anormalias_registradas)) {
                    $dados = [
                        'item_selecionado' => 1
                    ];
                } else {
                    $dados = [
                        'item_selecionado' => 0,
                    ];
                }
                $checklist = DB::table('ordem_servico_cheklist')->where('id_os_checklist', $ch->id_os_checklist)->update($dados);
            }

            return response()->json([
                'success' => true,
                'servicos' => $servicos_sem_primeira_linha
            ], 200);
        }
    }

    public function relatorioOS($id)
    {
        $Ordemservico = DB::table('ordem_servico as OS')
            ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'OS.id_funcionario')
            ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
            ->join('bases as base', 'base.id_base', '=', 'supervisor.id_funcionario')
            ->join('municipios', 'municipios.id_municipio', '=', 'base.id_municipio')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select(
                'OS.*',
                'base.*',
                'veiculos.*',
                'municipios.*',
                'provincias.*',
                'supervisor.id_funcionario as id_supervisor',
                'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                'supervisor.nome as supervisor_nome',
                'supervisor.sobrenome as supervisor_sobrenome',
                'OS.created_at as dataHora',
            )->where('OS.id_os', '=', $id)->get();

        if (count($Ordemservico) > 0) {

            $checklist_portaria = DB::table('ordem_servico')
                ->join('ordem_servico_cheklist', 'ordem_servico_cheklist.fk_id_os', '=', 'ordem_servico.id_os')
                ->join('checklists', 'checklists.id_checklist', '=', 'ordem_servico_cheklist.fk_id_item_checklist')
                ->select('ordem_servico.*', 'ordem_servico_cheklist.*', 'checklists.*')->where('ordem_servico.id_os', '=', $id)->get();

            $servicos_requesitados = DB::table('ordem_servico')
                ->join('servicos_requesitados', 'servicos_requesitados.id_os', '=', 'ordem_servico.id_os')
                ->select('ordem_servico.*', 'servicos_requesitados.*',)->where('servicos_requesitados.id_os', '=', $id)->get();

            $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

            $dados = [
                'checklists' => $checklist,
                'portaria_checklist' => $checklist_portaria,
                'portaria' => $Ordemservico,
                'portaria_descricao' => $checklist_portaria[0]->descricao_os,
                'servicos_requesitados' => $servicos_requesitados
            ];

            /*
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML('<h1>Test</h1>');
            return $pdf->stream();   
            */
            //return view('portaria.relatorio', $dados);
            //  $pdf = Pdf::loadView('portaria.relatorio',$dados);
            // return $pdf->download('invoice.pdf');
            // $pdf = PDF::loadView('portaria.relatorio',$dados)->setOptions(['dpi' => 90 , 'defaultFont' => 'sans-serif']);
            PDF::setOptions(['isPhpEnabled' => true]);
            $pdf = PDF::loadView('OrdemServico.relatorio', $dados);
            $nome_do_arquivo = $Ordemservico[0]->tipo_os . "_" . $Ordemservico[0]->prefixo . "_"
                . date('d/m/Y', strtotime($Ordemservico[0]->dataHora)) . "_" . date("H:m:s", strtotime($Ordemservico[0]->dataHora));
            return $pdf->stream($nome_do_arquivo);

            // return view('portaria.relatorio', $dados);
        } else {
            // erro de pagina nao encontrada
            abort('404');
        }
    }

    public function OrdemServicochecklist($id)
    {
        if (DB::table('ordem_servico_cheklist')->where('ordem_servico_cheklist.fk_id_os', '=', $id)->exists()) {

            $Ordemservico = DB::table('ordem_servico as OS')
                ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'OS.id_funcionario')
                ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
                ->join('bases as base', 'base.id_base', '=', 'supervisor.id_funcionario')
                ->join('municipios', 'municipios.id_municipio', '=', 'base.id_municipio')
                ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                ->select(
                    'OS.*',
                    'base.*',
                    'veiculos.*',
                    'municipios.*',
                    'provincias.*',
                    'supervisor.id_funcionario as id_supervisor',
                    'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                    'supervisor.nome as supervisor_nome',
                    'supervisor.sobrenome as supervisor_sobrenome',
                    'OS.created_at as dataHora',
                )->where('OS.id_os', '=', $id)->get();

            $checklist_portaria = DB::table('ordem_servico')
                ->join('ordem_servico_cheklist', 'ordem_servico_cheklist.fk_id_os', '=', 'ordem_servico.id_os')
                ->join('checklists', 'checklists.id_checklist', '=', 'ordem_servico_cheklist.fk_id_item_checklist')
                ->select('ordem_servico.*', 'ordem_servico_cheklist.*', 'checklists.*')->where('ordem_servico.id_os', '=', $id)->get();

            $servicos_requesitados = DB::table('ordem_servico')
                ->join('servicos_requesitados', 'servicos_requesitados.id_os', '=', 'ordem_servico.id_os')
                ->select('ordem_servico.*', 'servicos_requesitados.*',)->where('servicos_requesitados.id_os', '=', $id)->get();

            $veiculos = DB::table('veiculos')->orderBy('prefixo', 'ASC')->get();

            $motoristas = DB::table('funcionarios')->where('funcionario_tipo', '=', 'motorista')
                ->orderBy('numero_mecanografico', 'ASC')->get();

            $cobradores = DB::table('funcionarios')->where('funcionario_tipo', '=', 'cobrador')
                ->orderBy('numero_mecanografico', 'ASC')->get();

            $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

            $dados = [
                'checklists' => $checklist,
                'ordemservico_checklist' => $checklist_portaria,
                'Ordemservico' => $Ordemservico,
                'portaria_descricao' => $checklist_portaria[0]->descricao_os,
                'servicos_requesitados' => $servicos_requesitados
            ];
        } else {

            $dados = [
                'Ordemservico' => [],
            ];
        }

        return view('OrdemServico.checklist', $dados);
    }

    public function pesquisar(Request $receber)
    {

          $this->validate(
                $receber,
                [
                      'pesquisar' => 'required'
                ],
                [
                      'pesquisar.required' => 'Preecnha o campo pesquisar',
                ]
          );

          //$book = array('Nome', 'Sobrenome');

          $Ordemservico = DB::table('ordem_servico as OS')
                ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'OS.id_funcionario')
                ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
                ->join('bases as base', 'base.id_base', '=', 'supervisor.id_funcionario')
                ->join('municipios', 'municipios.id_municipio', '=', 'base.id_municipio')
                ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                ->select(
                    'OS.*',
                    'base.*',
                    'veiculos.*',
                    'municipios.*',
                    'provincias.*',
                    'supervisor.id_funcionario as id_supervisor',
                    'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                    'supervisor.nome as supervisor_nome',
                    'supervisor.sobrenome as supervisor_sobrenome',
                    'OS.created_at as dataHora',
                )->where('OS.tipo_os', 'like', '%' . $receber->pesquisar . '%')
                ->orWhere('OS.situacao_os', 'like', '%' . $receber->pesquisar . '%')
                ->orWhere('OS.created_at', 'like', '%' . $receber->pesquisar . '%')
                ->orWhere('veiculos.prefixo', 'like', '%' . $receber->pesquisar . '%')
                ->orWhere('veiculos.matricula', 'like', '%' . $receber->pesquisar . '%')
                ->orWhere('supervisor.nome', 'like', '%' . $receber->pesquisar . '%')
                ->orWhere('supervisor.sobrenome', 'like', '%' . $receber->pesquisar . '%')
                ->orWhere('base.nome_base', 'like', '%' . $receber->pesquisar . '%')
                ->paginate();

          $dados = [
                'Ordemservico' => $Ordemservico,
                 'pesquisar' => $Ordemservico
          ];

          return view('OrdemServico.listar', $dados);
    }
}

// 