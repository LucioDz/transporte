<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VeiculoRequest;
use App\Models\veiculo;
use App\Models\User;
use App\Models\Base;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Funcionario;
use App\Exports\VeiculoExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;

use function PHPUnit\Framework\isNull;

class  VeiculoController extends Controller
{
    public function cadastrar()
    {
        $bases = DB::table('bases')
            ->orderBy('nome_base', 'DESC')->get();

        $dados = [
            'bases' => $bases
        ];

        return view('veiculos.cadastrar', $dados);
    }

    public function store(VeiculoRequest $receber)
    {
        // validando os dados do formulario
        $receber->validated();

        ///fazendo o uploaed de arquivos recuperando via storage
        $caimniho  = $receber->foto_de_perfil != null ? $receber->foto_de_perfil->store('imagens/veiculos') : '';
        $caimniho_do_arquivo = $caimniho;
        $veiculo = new veiculo();

        $veiculo->imagem = $caimniho_do_arquivo;
        $veiculo->id_base =   $receber->base;
        $veiculo->marca =  $receber->marca;
        $veiculo->prefixo =  $receber->prefixo;
        $veiculo->matricula =  $receber->matricula;
        $veiculo->modelo =  $receber->modelo;
        $veiculo->motor =  $receber->motor;
        $veiculo->chassis  = $receber->chassis;
        $veiculo->lugares_sentados =  $receber->lugares_sentados;
        $veiculo->lugares_em_pe =  $receber->em_pe;
        $veiculo->lotacao =  $receber->lotacao;
        $veiculo->ano =  $receber->ano_fabrico;
        $veiculo->pais =  $receber->pais;
        $veiculo->kilometragem =  $receber->kilometragem;
        $veiculo->situacao =  $receber->situacao[0];
        $veiculo->registrado_por = Auth::user()->funcionario->id_funcionario;

        if ($veiculo->save()) {
            return redirect('veiculos/listar')->with('msg', 'Cadastro relizado com sucesso');
        } else {
            return redirect('veiculos/listar')->with('ERRO', 'Erro ao salvar veiculo na Base de dados');
        }
    }

    public function listar()
    {
        $veiculos  = DB::table('veiculos')
            ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
            ->select('bases.*', 'veiculos.*')->orderBy('id_veiculo', 'DESC')
            ->orderBy('veiculos.prefixo', 'ASC')
            ->paginate(20);

        $dados = [
            'veiculos' =>  $veiculos,
        ];

        //dd(Funcionario::where(1));

        return view('veiculos.listar', $dados);
    }

    public function listar_base()
    {

        $veiculos  = DB::table('veiculos')
            ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
            ->select('bases.*', 'veiculos.*')->orderBy('id_veiculo', 'DESC')
            ->where('bases.id_base', '=', Auth::user()->funcionario->id_base)
            ->orderBy('veiculos.prefixo', 'ASC')
            ->paginate(10);


        $dados = [
            'veiculos' =>  $veiculos,
        ];


        return view('veiculos.listar', $dados);
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

        $base =  Funcionario::findOrFail(Auth::user()->id_funcionario);

        $veiculos = 
           DB::table('veiculos as v')
            ->join('bases as b', 'b.id_base', '=', 'v.id_base')
             ->where('v.marca', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('v.prefixo', 'LIKE', '%' .   $receber->pesquisar . '%')
            ->orWhere('v.matricula', 'LIKE', '%' .   $receber->pesquisar . '%')
            ->orWhere('v.modelo', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('v.chassis', 'LIKE', '%' .  $receber->pesquisar . '%')
            ->orWhere('v.lugares_sentados', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('v.lugares_em_pe', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('v.lotacao', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('v.ano', 'LIKE', '%' .  $receber->pesquisar . '%')
            ->orWhere('v.pais', 'LIKE', '%' .  $receber->pesquisar . '%')
            ->orWhere('v.kilometragem', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('v.situacao', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('b.nome_base', 'LIKE', '%' . $receber->pesquisar . '%')
            ->paginate();

        $dados = [
            'veiculos' =>   $veiculos,
            'pesquisar' => $veiculos
        ];

        return view('veiculos.listar', $dados);
    }

    public function deletar_veiculo($id_veiculo)
    {
        $veiculo = veiculo::findOrFail($id_veiculo);

        $Registro_em_uso_portaria = DB::table('portaria')->where('fk_id_veiculo', $id_veiculo)->exists();

        if (!Gate::allows('delete', $veiculo)) {
            return view('pagina_nao_permitido');
        } else {

            if ($Registro_em_uso_portaria > 0) {
                return redirect('/veiculos/listar')->with('ERRO', 'Registro não pode ser excluído por estar
                relacionado com os dados da portaria');
            } else {

                if (veiculo::findOrFail($id_veiculo)->delete()) {
                    return redirect('/veiculos/listar')->with('msg', 'veiculo excluido com sucesso');
                } else {
                    return redirect('/veiculos/listar')->with('ERRO', 'Erro ao excluir dados');
                }
            }
        }

        //findOrFail encontrado o funcioanrio eo delete() apagando ele
    }


    public function editar_veiculo($id_veiculo)
    {
        $veiculo = veiculo::findOrFail($id_veiculo);

        if (!Gate::allows('editar', $veiculo)) {
            return view('pagina_nao_permitido');
        } else {

            $base_do_veiculo = Base::findOrFail($veiculo->id_base);
            $bases = DB::table('bases')->get();

            $dados = [
                'veiculo' =>  $veiculo,
                'veiculo_base' => $base_do_veiculo,
                'bases' => $bases
            ];

            return view('veiculos.editar', $dados);
        }
    }

    public function actulizar_veiculo(VeiculoRequest $receber)
    {
        $receber->validated();
        $veiculo = veiculo::findOrFail($receber->id);

        if ($receber->foto_de_perfil != null) {

            $camniho_do_arquivo = Storage::path($veiculo->imagem);

            if (file_exists($camniho_do_arquivo)) {
                // Apango primerio do servidor
                Storage::delete($veiculo->imagem);
            }

            $caimniho = $receber->foto_de_perfil->store('imagens/veiculos');

            $dados_actulizar = [
                'id_base' => $receber->base,
                'imagem' => $caimniho,
                'marca' =>  $receber->marca,
                'prefixo' =>   $receber->prefixo,
                'matricula' =>   $receber->matricula,
                'modelo' => $receber->modelo,
                'motor' =>  $receber->motor,
                'chassis' =>  $receber->chassis,
                'lugares_sentados' => $receber->lugares_sentados,
                'lugares_em_pe' =>    $receber->em_pe,
                'lotacao' =>  $receber->lotacao,
                'ano' =>  $receber->ano_fabrico,
                'pais' => $receber->pais,
                'kilometragem' => $receber->kilometragem,
                'situacao' => $receber->situacao[0],
            ];
        } else {

            $dados_actulizar = [
                'id_base' => $receber->base,
                'marca' =>  $receber->marca,
                'prefixo' =>   $receber->prefixo,
                'matricula' =>   $receber->matricula,
                'modelo' => $receber->modelo,
                'motor' =>  $receber->motor,
                'chassis' =>  $receber->chassis,
                'lugares_sentados' => $receber->lugares_sentados,
                'lugares_em_pe' =>    $receber->em_pe,
                'lotacao' =>  $receber->lotacao,
                'ano' =>  $receber->ano_fabrico,
                'pais' => $receber->pais,
                'kilometragem' => $receber->kilometragem,
                'situacao' => $receber->situacao[0],
            ];
        }

        $veiculo = DB::table('veiculos')->where('id_veiculo', $receber->id)->update($dados_actulizar);

        if ($veiculo) {
            return redirect('/veiculos/listar')->with('msg', 'Dados Actulizado com sucesso');
        } else {
            return redirect('/veiculos/listar')->with('ERRO', 'Erro ao actulizar dados tente novamente');
        }
    }

    public function exportar_exel()
    {

        return Excel::download(new VeiculoExport, 'veiculo.xlsx');
    }


    public function perfil($id)
    {
        $TotaldeSaidasEntradasdoVeiculo = array();
        $TotalDeSaidasdoVeiculo = array();
        $TotalDeEntradasdoVeiculo = array();
        $Ultima_saida_Do_Veiculo = array();
        $Ultima_Entrada_Do_Veiculo = array();

        $veiculo = DB::table('veiculos')
            ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
            ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('bases.*', 'municipios.*', 'provincias.*', 'veiculos.*')->where('veiculos.id_veiculo', '=', $id)->get();

        // veificando se o veiculo ja realizou alguma saida ou entrada
        if (DB::table('portaria')->where('fk_id_veiculo', $id)->exists()) {

            $TotaldeSaidasEntradasdoVeiculo = DB::table('portaria')->where('fk_id_veiculo', $id)->get();

            // verificar se existe algum registo de saida do veiculo
            if (DB::table('portaria')->where('fk_id_veiculo', '=', $id)->where('portaria_tipo', '=','Entrada')->exists()) {
                
                $TotalDeSaidasdoVeiculo = DB::table('portaria')->where('fk_id_veiculo', '=', $id)
                    ->where('portaria_tipo', '=', 'Saida')->get();

                $Ultima_Entrada_Do_Veiculo = DB::table('portaria as P')
                    ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                    ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                    ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                    ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                    ->join('bases', 'bases.id_base', '=', 'supervisor.id_base')
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
                    )->where('fk_id_veiculo', '=', $id)
                    ->where('portaria_tipo', '=', 'Entrada')->orderBy('id_portaria', 'Desc')->get();
            }

            // verificar se existe algum registo de entrada do veiculo
            if (DB::table('portaria')->where('fk_id_veiculo', '=', $id)->where('portaria_tipo', '=', 'Saida')->exists()) {

                $Ultima_saida_Do_Veiculo = DB::table('portaria as P')
                    ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                    ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                    ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                    ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                    ->join('bases', 'bases.id_base', '=', 'supervisor.id_base')
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
                    )->where('fk_id_veiculo', '=', $id)
                    ->where('portaria_tipo', '=','Saida')->orderBy('id_portaria', 'Desc')->get();
            }
        }

        $dados = [
            'veiculo' => $veiculo,
            'TotaldeSaidasEntradasdoVeiculo' => $TotaldeSaidasEntradasdoVeiculo,
            'TotalDeEntradasdoVeiculo'  => $TotalDeEntradasdoVeiculo,
            'TotalDeSaidasdoVeiculo'  => $TotalDeSaidasdoVeiculo,
            'Ultima_Entrada_Do_Veiculo'  => $Ultima_Entrada_Do_Veiculo,
            'Ultima_saida_Do_Veiculo'  => $Ultima_saida_Do_Veiculo,
            'id_veiculo' => $id
        ];

        return view('veiculos.perfil', $dados);
    }
}
