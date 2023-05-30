<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortariaRequest;
use App\Http\Requests\PortariaImagensRequest;
use App\Models\Portaria;
use App\Models\veiculo;
use App\Models\Funcionario;
use App\Models\Checklist;
use App\Models\portaria_cheklist;
use App\Models\portaria_imagens;
use App\Models\portaria_veiculos_afectados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

//use PDF;

class portariaController extends Controller
{
      public function cadastrar()
      {
            $base = Funcionario::findOrFail(Auth::user()->id_funcionario);

            $veiculos = DB::table('veiculos')
                  ->where('id_base', '=', $base->id_base)
                  ->orderBy('prefixo', 'ASC')->get();

            $motoristas = DB::table('funcionarios')
                  ->where('funcionario_tipo', '=', 'motorista')
                  ->where('id_base', '=', $base->id_base)
                  ->orderBy('numero_mecanografico', 'ASC')->get();

            $cobradores = DB::table('funcionarios')
                  ->where('funcionario_tipo', '=', 'cobrador')
                  ->where('id_base', '=', $base->id_base)
                  ->orderBy('numero_mecanografico', 'ASC')->get();

            //dd($base->id_base);
            // dd($cobradores);

            $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

            $dados = [
                  'veiculos' => $veiculos,
                  'motoristas' => $motoristas,
                  'cobradores' => $cobradores,
                  'checklists' => $checklist
            ];

            return view('portaria.cadastrar', $dados);
      }

      public function store(PortariaRequest $receber)
      {
            $receber->validated();

            $portaria = new Portaria();
            $portaria->portaria_tipo = $receber->tipo;
            $portaria->descricao = $receber->descricao ?? '';
            $portaria->portaria_kilometragem = $receber->kilometragem;
            $portaria->situcao_veiculo = $receber->situacao;
            $portaria->fk_id_veiculo = $receber->veiculo;
            $portaria->fk_id_motorista = $receber->motorista;
            $portaria->fk_id_ajudante = $receber->cobrador;
            // supervisor sera o usuario que esta a realizar o registro na portaria
            $portaria->fk_id_supervisor = Auth::user()->funcionario->id_funcionario;

            if ($portaria->save()) {

                  $ultimo_id_inserido_portaria = DB::getPdo()->lastInsertId();

                  // dd($ultimo_id_inserido_portaria);

                  $veiculo = DB::table('veiculos')->where('id_veiculo', '=', $receber->veiculo)->first();

                  //Salvando o caminho das imagens
                  if (isset($receber->allFiles()['imagens']) && count($receber->allFiles()['imagens']) > 0) {

                        for ($i = 0; $i < count($receber->allFiles()['imagens']); $i++) {
                              $imagem = $receber->allFiles()['imagens'][$i];
                              $caimniho = $imagem->store('imagens/veiculos/' . $veiculo->prefixo);
                              $caimniho_do_arquivo = $caimniho;

                              $portaria_imagem =  new portaria_imagens();
                              $portaria_imagem->caminho_imagem = $caimniho_do_arquivo;
                              $portaria_imagem->fk_id_portaria = $ultimo_id_inserido_portaria;
                              $portaria_imagem->save();
                        }
                  }

                  $dados_actulizar = [
                        'situacao' => $receber->situacao,
                  ];
                  // actulizando a situcao e kilometragem do veiculo
                  $veiculo = DB::table('veiculos')->where('id_veiculo', $receber->veiculo)->update($dados_actulizar);
                  //inseirdo dados em outra tabela 

                  $tabela_checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();
                  $anormalias_registradas = $receber->item_check;

                  // precorrendo a tablea checklist para indeficar quias intens quias anormalias/problemas foram indetificadas
                  foreach ($tabela_checklist as $ch) {

                        if (in_array($ch->id_checklist, $anormalias_registradas)) {
                              // salvadodo os dados
                              $portaria_cheklist = new portaria_cheklist();
                              $portaria_cheklist->fk_id_item_checklist = $ch->id_checklist;
                              $portaria_cheklist->item_selecionado = 1; // 1 selecionado
                              $portaria_cheklist->fk_id_portaria = $ultimo_id_inserido_portaria;
                              $portaria_cheklist->save();
                        } else {
                              $portaria_cheklist = new portaria_cheklist();
                              $portaria_cheklist->fk_id_item_checklist       = $ch->id_checklist;
                              $portaria_cheklist->item_selecionado = 0; // 1 selecionado
                              $portaria_cheklist->fk_id_portaria = $ultimo_id_inserido_portaria;
                              $portaria_cheklist->save();
                        }
                  }
                  return redirect('portaria/listar')->with('msg', 'Cadastro relizado com sucesso');
            } else {
                  return redirect('portaria/listar')->with('ERRO', 'Erro ao salvar funcionario na Base de dados');
            }
      }

      public function listar_minha_base()
      {
            $portaria2 = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases as base', 'base.id_base', '=', 'veiculos.id_base')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'base.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.numero_mecanografico as cobrador_numero_mecanografico',
                        'motorista.id_funcionario as id_motorista',
                        'motorista.nome as motorista_nome',
                        'motorista.sobrenome as motorista_sobrenome',
                        'motorista.numero_mecanografico as motorista_numero_mecanografico',
                        'supervisor.id_funcionario as id_supervisor',
                        'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                        'supervisor.nome as supervisor_nome',
                        'supervisor.sobrenome as supervisor_sobrenome',
                        'base.nome_base as nome_base',
                  )->orderBy('P.id_portaria', 'DESC')->paginate(10);


            $dados = [
                  'portaria' => $portaria2,
                  'rota_de_pesquisar' => '/pesquisar/supervisor'
            ];

            return view('portaria.listar', $dados);
      }

      public function ListarRegistros_Do_Supervisor()
      {
            $portaria2 = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases as base', 'base.id_base', '=', 'veiculos.id_base')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'base.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.numero_mecanografico as cobrador_numero_mecanografico',
                        'motorista.id_funcionario as id_motorista',
                        'motorista.nome as motorista_nome',
                        'motorista.sobrenome as motorista_sobrenome',
                        'motorista.numero_mecanografico as motorista_numero_mecanografico',
                        'supervisor.id_funcionario as id_supervisor',
                        'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                        'supervisor.nome as supervisor_nome',
                        'supervisor.sobrenome as supervisor_sobrenome',
                        'base.nome_base as nome_base',
                  )->where('P.fk_id_supervisor', '=', Auth::user()->funcionario->id_funcionario)
                  ->orderBy('P.id_portaria', 'DESC')->paginate(10);


            $dados = [
                  'portaria' => $portaria2,
                  'rota_de_pesquisar' => 'pesquisar/supervisor'
            ];

            return view('portaria.listar', $dados);
      }

      public function  editarPortaria($id)
      {
            //filtrando dados da portaria
            $dados_portaria = portaria::findOrFail($id);

            // verificando se o usuario tem permissao para editar dados da portaria 
            if (!Gate::allows('update-portaria', $dados_portaria)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

                  $portaria = DB::table('portaria as P')
                        ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                        ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                        ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                        ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                        ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                        ->select(
                              'P.*',
                              'veiculos.*',
                              'cobrador.id_funcionario as id_cobrador',
                              'cobrador.nome as cobrador_nome',
                              'cobrador.sobrenome as cobrador_sobrenome',
                              'cobrador.sobrenome as cobrador_sobrenome',
                              'cobrador.numero_mecanografico as cobrador_numero_mecanografico',
                              'motorista.id_funcionario as id_motorista',
                              'motorista.nome as motorista_nome',
                              'motorista.sobrenome as motorista_sobrenome',
                              'motorista.numero_mecanografico as motorista_numero_mecanografico',
                              'supervisor.id_funcionario as id_supervisor',
                              'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                              'supervisor.nome as supervisor_nome',
                              'supervisor.sobrenome as supervisor_sobrenome',
                        )
                        ->where('P.id_portaria', '=', $id)->get();

                  if (count($portaria) > 0) {

                        $checklist_portaria = DB::table('portaria')
                              ->join('portaria_cheklist', 'portaria_cheklist.fk_id_portaria', '=', 'portaria.id_portaria')
                              ->join('checklists', 'checklists.id_checklist', '=', 'portaria_cheklist.fk_id_item_checklist')
                              ->select('portaria.*', 'portaria_cheklist.*', 'checklists.*')->where('portaria.id_portaria', '=', $id)->get();

                        $veiculos = DB::table('veiculos')->orderBy('prefixo', 'ASC')->get();

                        $motoristas = DB::table('funcionarios')->where('funcionario_tipo', '=', 'motorista')
                              ->orderBy('numero_mecanografico', 'ASC')->get();

                        $cobradores = DB::table('funcionarios')->where('funcionario_tipo', '=', 'cobrador')
                              ->orderBy('numero_mecanografico', 'ASC')->get();

                        $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

                        $dados = [
                              'portaria' => $portaria,
                              'veiculos' => $veiculos,
                              'motoristas' => $motoristas,
                              'cobradores' => $cobradores,
                              'checklists' => $checklist,
                              'portaria_checklist' => $checklist_portaria,
                              'portaria_descricao' => $checklist_portaria[0]->descricao
                          ];
                          
                        return view('portaria.editar', $dados);
                  } else {
                        return view('pagina_nao_econtrada');
                  }
            }
      }

      public function checklistPortaria($id)
      {

            if (DB::table('portaria_cheklist')->where('portaria_cheklist.fk_id_portaria', '=', $id)->exists()) {

                  //filtrando dados da portaria
                  $portaria = DB::table('portaria as P')
                        ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                        ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                        ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                        ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                        ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                        ->select(
                              'P.*',
                              'veiculos.*',
                              'cobrador.id_funcionario as id_cobrador',
                              'cobrador.nome as cobrador_nome',
                              'cobrador.sobrenome as cobrador_sobrenome',
                              'cobrador.sobrenome as cobrador_sobrenome',
                              'cobrador.numero_mecanografico as cobrador_numero_mecanografico',
                              'motorista.id_funcionario as id_motorista',
                              'motorista.nome as motorista_nome',
                              'motorista.sobrenome as motorista_sobrenome',
                              'motorista.numero_mecanografico as motorista_numero_mecanografico',
                              'supervisor.id_funcionario as id_supervisor',
                              'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                              'supervisor.nome as supervisor_nome',
                              'supervisor.sobrenome as supervisor_sobrenome',
                        )->where('P.id_portaria', '=', $id)->get();

                  $checklist_portaria = DB::table('portaria')
                        ->join('portaria_cheklist', 'portaria_cheklist.fk_id_portaria', '=', 'portaria.id_portaria')
                        ->join('checklists', 'checklists.id_checklist', '=', 'portaria_cheklist.fk_id_item_checklist')
                        ->select('portaria.*', 'portaria_cheklist.*', 'checklists.*')->where('portaria.id_portaria', '=', $id)->get();

                  $veiculos = DB::table('veiculos')->orderBy('prefixo', 'ASC')->get();

                  $motoristas = DB::table('funcionarios')->where('funcionario_tipo', '=', 'motorista')
                        ->orderBy('numero_mecanografico', 'ASC')->get();

                  $cobradores = DB::table('funcionarios')->where('funcionario_tipo', '=', 'cobrador')
                        ->orderBy('numero_mecanografico', 'ASC')->get();

                  $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

                  $dados = [
                        'portaria' => $portaria,
                        'veiculos' => $veiculos,
                        'motoristas' => $motoristas,
                        'cobradores' => $cobradores,
                        'checklists' => $checklist,
                        'portaria_checklist' => $checklist_portaria,
                        'portaria_descricao' => $checklist_portaria[0]->descricao
                  ];

            }else {

                  $dados = [
                        'portaria' => [],
                  ]; 
            }

            return view('portaria.checklist', $dados);
      }

      public function relatorioPortaria($id)
      {
            $portaria = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                  ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
                  ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'bases.*',
                        'provincias.*',
                        'municipios.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.numero_mecanografico as cobrador_numero_mecanografico',
                        'motorista.id_funcionario as id_motorista',
                        'motorista.nome as motorista_nome',
                        'motorista.sobrenome as motorista_sobrenome',
                        'motorista.numero_mecanografico as motorista_numero_mecanografico',
                        'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                        'supervisor.nome as supervisor_nome',
                        'supervisor.sobrenome as supervisor_sobrenome',
                  )
                  ->where('P.id_portaria', '=', $id)->get();


            if (count($portaria) > 0) {

                  $checklist_portaria = DB::table('portaria')
                        ->join('portaria_cheklist', 'portaria_cheklist.fk_id_portaria', '=', 'portaria.id_portaria')
                        ->join('checklists', 'checklists.id_checklist', '=', 'portaria_cheklist.fk_id_item_checklist')
                        ->select('portaria.*', 'portaria_cheklist.*', 'checklists.*')->where('portaria.id_portaria', '=', $id)->get();

                  $checklist = DB::table('checklists')->orderBy('nome_item', 'ASC')->get();

                  $dados = [
                        'checklists' => $checklist,
                        'portaria_checklist' => $checklist_portaria,
                        'portaria' => $portaria,
                        'portaria_descricao' => $checklist_portaria[0]->descricao
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
                  $pdf = PDF::loadView('portaria.relatorio', $dados);
                  $nome_do_arquivo = $portaria[0]->portaria_tipo . "_" . $portaria[0]->prefixo . "_"
                        . date('d/m/Y', strtotime($portaria[0]->dataHora)) . "_" . date("H:m:s", strtotime($portaria[0]->dataHora));
                  return $pdf->stream($nome_do_arquivo);

                  // return view('portaria.relatorio', $dados);
            } else {
                  // erro de pagina nao encontrada
                  abort('404');
            }
      }

      public function ActualizarPortaria(PortariaRequest $receber)
      {
            $receber->validated();

            $dados_actulizar = [
                  'id_portaria' => $receber->id,
                  'portaria_tipo' => $receber->tipo,
                  'descricao' =>  $receber->descricao ?? '',
                  'portaria_kilometragem' =>  $receber->kilometragem,
                  'situcao_veiculo' =>  $receber->situacao,
                  'fk_id_veiculo' =>  $receber->veiculo,
                  'fk_id_motorista' =>   $receber->motorista,
                  'fk_id_ajudante' =>  $receber->cobrador
            ];
            //$results = DB::select('select * from users where id = :id', ['id' => 1]);
            // Aculizando os dados de varias tabelas ao mesmo tempo   
            $portaria = DB::table('portaria')->where('id_portaria', $receber->id)->update($dados_actulizar);

            //recuperado os ID da tabela portaria checklit
            $tabela_checklist = DB::table('portaria_cheklist')->where('fk_id_portaria', $receber->id)->get('id_portaria_checklist');

            //dd($tabela_checklist);

            $anormalias_registradas = $receber->item_check;

            foreach ($tabela_checklist as $ch) {

                  if (in_array($ch->id_portaria_checklist, $anormalias_registradas)) {
                        $dados_actulizar = [
                              'item_selecionado' => 1
                        ];
                  } else {
                        $dados_actulizar = [
                              'item_selecionado' => 0,
                        ];
                  }
                  $checklist = DB::table('portaria_cheklist')->where('id_portaria_checklist', $ch->id_portaria_checklist)->update($dados_actulizar);
            }
            /*
            $d = ['id_portaria' => $receber->id];
            $results = DB::select('SELECT * from portaria as P
            inner join portaria_veiculos_afectados as PV on PV.id_portaria = P.id_portaria 
            join portaria_motoristas_afectados as PM on PM.fk_id_portaria = P.id_portaria
            join portaria_cobradores_afectados as PC on PC.fk_id_portaria = P.id_portaria
            join portaria_supervisores_afectados as PS on PS.fk_id_portaria = P.id_portaria
            join veiculos as V on V.id_veiculo = PV.fk_id_veiculo
            WHERE P.id_portaria = :id_portaria', $d);
           */
            if ($portaria or $checklist) {
                  return redirect('/portaria/listar')->with('msg', 'Dados actulizado com sucesso');
            } else {
                  return redirect('/portaria/listar')->with('ERRO', 'Erro ao actualizar dados tente novamente');
            }
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


            $portaria2 = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases as base', 'base.id_base', '=', 'veiculos.id_base')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'base.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.numero_mecanografico as cobrador_numero_mecanografico',
                        'motorista.id_funcionario as id_motorista',
                        'motorista.nome as motorista_nome',
                        'motorista.sobrenome as motorista_sobrenome',
                        'motorista.numero_mecanografico as motorista_numero_mecanografico',
                        'supervisor.id_funcionario as id_supervisor',
                        'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                        'supervisor.nome as supervisor_nome',
                        'supervisor.sobrenome as supervisor_sobrenome',
                        'base.nome_base as nome_base'
                  )->where('P.portaria_tipo', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('P.portaria_kilometragem', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('P.situcao_veiculo', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('P.dataHora', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('veiculos.prefixo', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('veiculos.matricula', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('motorista.nome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('motorista.sobrenome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('cobrador.nome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('cobrador.sobrenome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('supervisor.nome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('supervisor.sobrenome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('base.nome_base', 'like', '%' . $receber->pesquisar . '%')
                  ->paginate();

            $dados = [
                  'portaria' => $portaria2,
                  'pesquisar' => $portaria2
            ];

            return view('portaria.listar', $dados);
      }


      public function pesquisar_Registros_Do_Supervisor(Request $receber)
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

            $portaria2 = DB::table('portaria as P')
                  ->join('portaria_veiculos_afectados as PV', 'PV.id_portaria', '=', 'P.id_portaria')
                  ->join('veiculos', 'veiculos.id_veiculo', '=', 'PV.fk_id_veiculo')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'PV.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'PV.fk_id_cobrador')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.registrado_por')
                  ->select(
                        'P.*',
                        'PV.*',
                        'veiculos.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.sobrenome as cobrador_sobrenome',
                        'cobrador.numero_mecanografico as cobrador_numero_mecanografico',
                        'motorista.id_funcionario as id_motorista',
                        'motorista.nome as motorista_nome',
                        'motorista.sobrenome as motorista_sobrenome',
                        'motorista.numero_mecanografico as motorista_numero_mecanografico',
                        'supervisor.id_funcionario as id_supervisor',
                        'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
                        'supervisor.nome as supervisor_nome',
                        'supervisor.sobrenome as supervisor_sobrenome',
                  )->where('P.registrado_por', '=', Auth::user()->funcionario->id_funcionario)
                  ->where('P.portaria_tipo', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('P.portaria_kilometragem', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('P.situcao_veiculo', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('P.data', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('P.hora', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('veiculos.prefixo', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('veiculos.matricula', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('motorista.nome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('motorista.sobrenome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('cobrador.nome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('cobrador.sobrenome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('supervisor.nome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('supervisor.sobrenome', 'like', '%' . $receber->pesquisar . '%')
                  ->orWhere('Base.nome_base', 'like', '%' . $receber->pesquisar . '%')
                  ->paginate();

            $dados = [
                  'portaria' => $portaria2,
                  'rota_de_pesquisar' => 'portaria/listar/pesquisar/supervisor'
            ];

            return view('portaria.listar', $dados);
      }
}
