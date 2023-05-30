<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Funcionario;
use App\Models\manutencao_preventiva_cheklist;
use App\Models\manutencao_preventiva_imagens;
use App\Models\Manutencaopreventiva;
use App\Models\manutencaopreventivaservicos;
use Illuminate\Support\Facades\Validator;

class ManutencaoController extends Controller
{
    //
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

        return view('manutencao.cadastrar', $dados);
    }

    public function store(Request $receber)
    {
        $rules = [
            'descricao' => ['present'],
            'tipo_manutencao' => ['required'],
            //'situacao_os' => ['required'],
            'veiculo' => ['required', 'numeric'],
            'previsao_da_manutencao' => ['required'],
            'item_check' => ['required', "array"],
            'servicos' => ['required'],
            'imagens.*' => ['required', 'image', 'mimetypes:image/jpeg,image/png', 'max:10240'],
        ];

        $messages = [
            'item_check.required' => 'Selecione um item no checklist',
            'tipo_manutencao.required' => 'Selecione o tipo de manutenção',
            'previsao_da_manutencao.required' => 'Selecione a data da manutenção',
            'veiculo.required' => 'Selecione o veiculo',
            //'servicos.required' => 'Adicione os serviços a serem adicionados na manutenção'
        ];

        $validator = Validator::make($receber->all(), $rules, $messages);

        /// $arquivo = $_FILES['imagens'];

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        } else {

            $preventiva = new Manutencaopreventiva();

            $preventiva->tipo_manutencao =  $receber->tipo_manutencao;
            $preventiva->previsao_da_manutencao =  $receber->previsao_da_manutencao;
            $preventiva->descricao =  $receber->descricao ?? '';
            $preventiva->estado =  0;
            $preventiva->id_veiculo =  $receber->veiculo;
            $preventiva->id_funcionario    =  Auth::user()->id_funcionario;

            if ($preventiva->save()) {

                // salvando o utlimom id inserido da tabela Manutencao preventiva
                $ultimo_id_inserido_preventiva = DB::getPdo()->lastInsertId();

                $veiculo = DB::table('veiculos')->where('id_veiculo', '=', $receber->veiculo)->first();

                if ($receber->hasFile('imagens')) {
                    $imagens = $receber->file('imagens');
                    foreach ($imagens as $imagem) {
                        // Verificando se a imagem foi enviada com sucesso
                        if ($imagem->isValid()) {

                            //Armazenando a imagem no diretório "imagens/ordemServico/[prefixo do veículo]"
                            $caminho = $imagem->store('imagens/manutencao/preventiva' . $veiculo->prefixo);
                            // Salvando o caminho da imagem no banco de dados
                            $preventiva_imagens = new manutencao_preventiva_imagens();
                            $preventiva_imagens->caminho_imagem = $caminho;
                            $preventiva_imagens->id_preventiva = $ultimo_id_inserido_preventiva;
                            $preventiva_imagens->save();
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

                        $servico = new manutencaopreventivaservicos();

                        $servico->nome_servico =  $serv['nome'];
                        $servico->descricao =  $serv['descricao'] ?? '';
                        $servico->id_preventiva = $ultimo_id_inserido_preventiva;
                        $servico->save();
                    }
                }

                $tabela_checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();
                $anormalias_registradas = $receber->item_check;

                // precorrendo a tablea checklist para indeficar quias intens quias anormalias/problemas foram indetificadas
                foreach ($tabela_checklist as $ch) {

                    if (in_array($ch->id_checklist, $anormalias_registradas)) {
                        // salvadodo os dados
                        $preventiva_cheklist = new manutencao_preventiva_cheklist();
                        $preventiva_cheklist->fk_id_item_checklist = $ch->id_checklist;
                        $preventiva_cheklist->item_selecionado = 1; // 1 selecionado
                        $preventiva_cheklist->id_preventiva = $ultimo_id_inserido_preventiva;
                        $preventiva_cheklist->save();
                    } else {
                        $preventiva_cheklist = new manutencao_preventiva_cheklist();
                        $preventiva_cheklist->fk_id_item_checklist = $ch->id_checklist;
                        $preventiva_cheklist->item_selecionado = 0; // 1 selecionado
                        $preventiva_cheklist->id_preventiva = $ultimo_id_inserido_preventiva;
                        $preventiva_cheklist->save();
                    }
                }

                return response()->json([
                    'success' => true,
                    ///'servicos' => $servicos_sem_primeira_linha
                ], 200);
            }
        }
    }

    public function listar()
    {

        $bases = DB::table('bases')->get();

        $funcionarios = DB::table('funcionarios')->where('id_base', '=',  Auth::user()->funcionario->id_base)->get();
        $veiculos = DB::table('veiculos')->where('id_base', '=',  Auth::user()->funcionario->id_base)->get();
        $checklist = DB::table('checklists')->get();

        $manutencao_preventiva = DB::table('manutencao_preventiva as mp')
            ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'mp.id_funcionario')
            ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'mp.id_veiculo')
            ->join('bases as base', 'base.id_base', '=', 'supervisor.id_funcionario')
            ->select(
                'mp.*',
                'base.*',
                'veiculos.*',
                'supervisor.id_funcionario as id_supervisor',
                'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                'supervisor.nome as supervisor_nome',
                'supervisor.sobrenome as supervisor_sobrenome',
                'mp.created_at as dataHora',
            )->where('supervisor.id_base', '=',  Auth::user()->funcionario->id_base)
            ->orderBy('mp.id_preventiva', 'DESC')->paginate(10);

        $dados = [
            'bases' => $bases,
            'funcionarios' => $funcionarios,
            'veiculos' =>  $veiculos,
            'checklist' =>  $checklist,
            'ManutencaoPreventiva' =>  $manutencao_preventiva
        ];

        return view('manutencao.listar', $dados);
    }

    public function manutencaochecklist($id)
    {
        if (DB::table('manutencao_preventiva_cheklist')->where('id_checklist', '=', $id)->exists()) {

            $manutencao_preventiva = DB::table('manutencao_preventiva as mp')
                ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'mp.id_funcionario')
                ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'mp.id_veiculo')
                ->join('bases as base', 'base.id_base', '=', 'supervisor.id_funcionario')
                ->select(
                    'mp.*',
                    'base.*',
                    'veiculos.*',
                    'supervisor.id_funcionario as id_supervisor',
                    'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                    'supervisor.nome as supervisor_nome',
                    'supervisor.sobrenome as supervisor_sobrenome',
                    'mp.created_at as dataHora',
                )->where('mp.id_preventiva', '=', $id)->get();

            $manutencao_preventiva_cheklist = DB::table('manutencao_preventiva')
                ->join('manutencao_preventiva_cheklist', 'manutencao_preventiva_cheklist.id_preventiva', '=', 'manutencao_preventiva.id_preventiva')
                ->join('checklists', 'checklists.id_checklist', '=', 'manutencao_preventiva_cheklist.fk_id_item_checklist')
                ->select('manutencao_preventiva.*', 'manutencao_preventiva_cheklist.*', 'checklists.*')
                ->where('manutencao_preventiva.id_preventiva', '=', $id)->get();

            $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

            $dados = [
                'checklists' => $checklist,
                'manutencao_preventiva_cheklist' => $manutencao_preventiva_cheklist,
                'manutencao_preventiva' => $manutencao_preventiva,
                'portaria_descricao' => $manutencao_preventiva_cheklist[0]->descricao,
            ];
        } else {

            $dados = [
                'Ordemservico' => [],
            ];
        }

        return view('manutencao.checklist', $dados);
    }

    // metodo para gerar relatorio 

    public function relatorio($id)
    {
        if (DB::table('manutencao_preventiva_cheklist')->where('id_checklist', '=', $id)->exists()) {

            $manutencao_preventiva = DB::table('manutencao_preventiva as mp')
                ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'mp.id_funcionario')
                ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'mp.id_veiculo')
                ->join('bases as base', 'base.id_base', '=', 'supervisor.id_funcionario')
                ->select(
                    'mp.*',
                    'base.*',
                    'veiculos.*',
                    'supervisor.id_funcionario as id_supervisor',
                    'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                    'supervisor.nome as supervisor_nome',
                    'supervisor.sobrenome as supervisor_sobrenome',
                    'mp.created_at as dataHora',
                )->where('mp.id_preventiva', '=', $id)->get();

            if (count($manutencao_preventiva) > 0) {

                $manutencao_preventiva_cheklist = DB::table('manutencao_preventiva')
                    ->join('manutencao_preventiva_cheklist', 'manutencao_preventiva_cheklist.id_preventiva', '=', 'manutencao_preventiva.id_preventiva')
                    ->join('checklists', 'checklists.id_checklist', '=', 'manutencao_preventiva_cheklist.fk_id_item_checklist')
                    ->select('manutencao_preventiva.*', 'manutencao_preventiva_cheklist.*', 'checklists.*')
                    ->where('manutencao_preventiva.id_preventiva', '=', $id)->get();

                $servicos_requesitados = DB::table('manutencao_preventiva')
                    ->join('manutencaopreventivaservicos', 'manutencaopreventivaservicos.id_servico', '=', 'manutencao_preventiva.id_preventiva')
                    ->select('manutencao_preventiva.*', 'manutencaopreventivaservicos.*',)->where('manutencaopreventivaservicos.id_preventiva', '=', $id)->get();

                $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

                $dados = [
                    'checklists' => $checklist,
                    'portaria_checklist' => $manutencao_preventiva_cheklist,
                    'portaria' => $manutencao_preventiva,
                    'portaria_descricao' => $manutencao_preventiva_cheklist[0]->descricao,
                    'servicos_requesitados' => $servicos_requesitados
                ];

                PDF::setOptions(['isPhpEnabled' => true]);
                $pdf = PDF::loadView('manutencao.relatorio', $dados);
                $nome_do_arquivo = $manutencao_preventiva[0]->tipo_manutencao . "_" . $manutencao_preventiva[0]->prefixo . "_"
                    .date('d/m/Y', strtotime($manutencao_preventiva[0]->created_at)) . "_" . date("H:m:s", strtotime($manutencao_preventiva[0]->created_at));

                return $pdf->stream($nome_do_arquivo);
            }
            // return view('portaria.relatorio', $dados);
        } else {
            // erro de pagina nao encontrada
              abort('404');
        }
    }
}
