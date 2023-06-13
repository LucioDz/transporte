<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FuncionarioRequest;
use App\Http\Requests\ServicosRequisitadosRequest;
use App\Models\Funcionario;
use App\Models\User;
use App\Models\Base;
use App\Models\ServicosRequisitados;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class FuncionarioController extends Controller
{
    public function cadastrar()
    {
        //$bases = DB::table('bases')->where('id_base',Auth::user()->funcionario->id_base)->get();
        $bases = DB::table('bases')->get();

        $dados = [
            'bases' => $bases
        ];

        return view('funionarios.cadastrar', $dados);
    }

    public function store(FuncionarioRequest $receber)
    {
        // validando os dados do formulario
        $receber->validated();
        $funcionarios_permitidos_ha_login = ['administrador', 'supervisor'];

        ///fazendo o uploaed de arquivos recuperando via storage
        $caimniho  = $receber->foto_de_perfil != null ? $receber->foto_de_perfil->store('imagens/funcionarios') : '';
        $caimniho_do_arquivo = $caimniho;

        $funcionario = new Funcionario();
        $funcionario->numero_mecanografico =  $receber->numero_mecanografico;
        $funcionario->nome =  $receber->nome;
        $funcionario->sobrenome =  $receber->sobrenome;
        $funcionario->imagem =  $caimniho_do_arquivo;
        $funcionario->funcionario_tipo = $receber->funcionario_tipo[0];
        $funcionario->descricao = $receber->descricao ?? '';
        $funcionario->registrado_por = Auth::user()->id;
        $funcionario->id_base = $receber->base;

        if ($funcionario->save()) {
            return redirect('funcionario/listar/base')->with('msg', 'Cadastro relizado com sucesso');
        } else {
            return redirect('funcionario/listar/base')->with('ERRO', 'Erro ao salvar os dados na Base de dados');
        }
    }

    public function listar()
    {
        $funcionarios  = DB::table('funcionarios')
            ->join('bases', 'bases.id_base', '=', 'funcionarios.id_base')
            ->select('bases.*', 'funcionarios.*')
            ->orderBy('funcionarios.nome', 'ASC')
            ->paginate(10);

        $dados = [
            'funcionarios' =>  $funcionarios,
            'rota_de_pesquisa' => '/funcionario/pesquisar'
        ];

        //dd(Funcionario::where(1));
        return view('funionarios.listar', $dados);
    }

    public function listar_base()
    {
        $base =  Funcionario::findOrFail(Auth::user()->id_funcionario);

        $funcionarios  = DB::table('funcionarios')
            ->join('bases', 'bases.id_base', '=', 'funcionarios.id_base')
            ->select('bases.*', 'funcionarios.*')
            ->where('bases.id_base', '=', $base->id_base)
            ->orderBy('funcionarios.nome', 'ASC')
            ->paginate(10);

        $dados = [
            'funcionarios' =>  $funcionarios,
            'rota_de_pesquisa' => '/funcionario/pesquisar/base'
        ];

        return view('funionarios.listar', $dados);
    }


    public function deletar_usuario($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        if (!Gate::allows('editar', $funcionario)) {
            return view('pagina_nao_permitido');
        } else {

            //verificando a relação com outras tabelas antes de apagar
            $Registro_em_uso_ajudante = DB::table('portaria')->where('fk_id_ajudante', $id)->exists();
            $Registro_em_uso_motorista = DB::table('portaria')->where('fk_id_motorista', $id)->exists();
            $Registro_em_uso_supervisor = DB::table('portaria')->where('fk_id_supervisor', $id)->exists();
            $Registro_em_uso_supervisor_user = DB::table('users')->where('id_funcionario', $id)->exists();

            if ($Registro_em_uso_supervisor_user > 0) {

                return redirect('/funcionario/listar')->with('ERRO', 'Registro não pode ser excluído por estar
             relacionado com os dados do usuarios');
            } else if ($Registro_em_uso_motorista > 0) {
                return redirect('/funcionario/listar')->with('ERRO', 'Registro não pode ser excluído por estar
            relacionado com os dados da portaria');
            } else if ($Registro_em_uso_ajudante > 0) {
                return redirect('/funcionario/listar')->with('ERRO', 'Registro não pode ser excluído por estar
            relacionado com os dados da portaria');
            } else if ($Registro_em_uso_supervisor_user > 0) {
                return redirect('/funcionario/listar')->with('ERRO', 'Registro não pode ser excluído por estar
            relacionado com os dados da portaria');
            } else {
                if (Funcionario::findOrFail($id)->delete()) {
                    return redirect('/funcionario/listar')->with('msg', 'Funcionario excluido com sucesso');
                } else {
                    return redirect('/funcionario/listar')->with('ERRO', 'Erro ao excluir dados');
                }
            }
            //findOrFail encontrado o funcioanrio eo delete() apagando ele 
        }
    }

    public function editar_usuario($id_funcionario)
    {
        $funcionario = Funcionario::findOrFail($id_funcionario);

        if (!Gate::allows('editar', $funcionario)) {
            return view('pagina_nao_permitido');
        } else {
            $funcionarios_permitidos_a_fazer_login = ["administrador_base", "administrador_senior", "supervisor"];

            $base_do_funcionario = Base::findOrFail($funcionario->id_base);
            //verificanfo funcionario ja pertence a tabela usuarios
            //  $funcionario_usuario = DB::table('user')->where('fk_id_funcionario', '=',$funcionario->id_funcionario);
            $funcionario_usuario  = User::where('id_funcionario', '=', $funcionario->id_funcionario)->first();

            //$bases = DB::table('bases')->where('id_base',Auth::user()->funcionario->id_base)->get();
            $bases = DB::table('bases')->get();

            $dados = [
                'funcionario' =>  $funcionario,
                'permitidos_login' =>  $funcionarios_permitidos_a_fazer_login,
                'funcionario_usuario' =>  $funcionario_usuario,
                'base' => $base_do_funcionario,
                'bases' => $bases
            ];

            return view('funionarios.editar', $dados);
        }
    }

    public function actulizar_funcionario(FuncionarioRequest $receber)
    {
        $receber->validated();

        $funcionario = Funcionario::findOrFail($receber->id);

        $descricao = $receber->descricao ?? '';
        //vericando se a foto de perfil esta a ser alterada

        if ($receber->foto_de_perfil != null) {

            $camniho_do_arquivo = Storage::path($funcionario->imagem);

            if (file_exists($camniho_do_arquivo)) {
                // Apango primerio do servidor
                Storage::delete($funcionario->imagem);
            }

            $caimniho = $receber->foto_de_perfil->store('imagens/funcionarios');

            $dados_actulizar = [
                'id_base' => $receber->base,
                'numero_mecanografico' =>  $receber->numero_mecanografico,
                'Nome' =>  $receber->nome,
                'Sobrenome' =>  $receber->sobrenome,
                'imagem' =>  $caimniho,
                'funcionario_tipo' => $receber->funcionario_tipo[0],
                'descricao' =>  $descricao,
            ];
        } else {
            $dados_actulizar = [
                'id_base' => $receber->base,
                'numero_mecanografico' =>  $receber->numero_mecanografico,
                'Nome' =>  $receber->nome,
                'Sobrenome' => $receber->sobrenome,
                'funcionario_tipo' => $receber->funcionario_tipo[0],
                'descricao' =>  $descricao,
            ];
        }

        $funcionario = DB::table('funcionarios')->where('id_funcionario', $receber->id)->update($dados_actulizar);

        if ($funcionario) {
            return redirect('/funcionario/listar')->with('msg', 'Dados actualizados com sucesso');
        } else {
            return redirect('/funcionario/listar')->with('ERRO', 'Erro ao actualizar dados tente novamente');
        }
    }

    public function perfil($id)
    {
        $funcionario = Funcionario::findOrFail($id);
        $perfil = 0;
        $TotaldeSaidasEntradas = array();
        $TotalDeSaidasdoVeiculo = array();
        $TotalDeEntradasdoVeiculo = array();
        $Ultima_saida_Do_Veiculo = array();
        $TotalDeEntradas = array();
        $TotalDeSaidas = array();
        $Ultima_Entrada_Do_Veiculo = array();
        $Ultima_saida_Do_Veiculo = array();
        
        $base_do_funcionario = DB::table('bases')
            ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('bases.*', 'municipios.*', 'provincias.*')->where('bases.id_base', '=', $funcionario->id_base)->get();

        if ($funcionario->funcionario_tipo == "motorista") {
            $perfil = 'fk_id_motorista';
        } elseif ($funcionario->funcionario_tipo == "cobrador") {
            $perfil = 'fk_id_ajudante';
        } elseif ($funcionario->funcionario_tipo == "supervisor") {
            $perfil = 'fk_id_supervisor';
        } elseif ($funcionario->funcionario_tipo == "administrador_base") {
            $perfil = 'fk_id_supervisor';
        } elseif ($funcionario->funcionario_tipo == "administrador_senior") {
            $perfil = 'fk_id_supervisor';
        } else {
            abort(403);
        }

        if (DB::table('portaria')->where($perfil, $id)->exists()) {

            if (DB::table('portaria')->where($perfil, $id)->exists()) {

                $TotaldeSaidasEntradas = DB::table('portaria')->where($perfil, $id)->get();

                if (DB::table('portaria')->where($perfil,'=',$id)->where('portaria_tipo', '=','Entrada')->exists()) {

                    $TotalDeEntradas = DB::table('portaria')->where($perfil, '=', $id)
                        ->where('portaria_tipo', '=', 'Entrada')->get();

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
                        )->where($perfil, '=', $id)
                        ->where('portaria_tipo', '=', 'Entrada')->orderBy('id_portaria', 'Desc')->get();
                }

                if ($TotalDeSaidas = DB::table('portaria')->where($perfil, '=', $id)->where('portaria_tipo', '=', 'Saida')->exists()) {

                    $TotalDeSaidas = DB::table('portaria')->where($perfil, '=', $id)->where('portaria_tipo', '=', 'Saida')->get();

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
                        )->where($perfil, '=', $id)
                        ->where('portaria_tipo', '=', 'Saida')->orderBy('id_portaria', 'Desc')->get();
                }
            }
        }

        $dados = [
            'funcionario' =>  $funcionario,
            'base' => $base_do_funcionario,
            'TotaldeSaidasEntradas' => $TotaldeSaidasEntradas,
            'TotalDeEntradas'  => $TotalDeEntradas,
            'TotalDeSaidas'  => $TotalDeSaidas,
            'Ultima_Entrada_Do_Veiculo' => $Ultima_Entrada_Do_Veiculo,
            'Ultima_saida_Do_Veiculo' => $Ultima_saida_Do_Veiculo,
            'pefil'  => $perfil,
            'id_funcionario' => $id
        ];

        return view('funionarios.perfil', $dados);
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
        //$book = array('Nome','Sobrenome');
        $funcionarios  = DB::table('funcionarios')
            ->join('bases', 'bases.id_base', '=', 'funcionarios.id_base')
            ->select('bases.*', 'funcionarios.*')
            ->where('Nome', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('Sobrenome', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('numero_mecanografico', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('funcionario_tipo', 'LIKE', '%' . $receber->pesquisar . '%')
            ->paginate();

        //dd($funcionarios);
        $dados = [
            'funcionarios' =>  $funcionarios,
            'pesquisar' =>  $funcionarios,
            'rota_de_pesquisa' => '/funcionario/pesquisar',
        ];
        //dd(Funcionario::where(1));

        return view('funionarios.listar', $dados);
    }
    public function pesquisar_base(Request $receber)
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
        $funcionarios  = DB::table('funcionarios')
            ->join('bases', 'bases.id_base', '=', 'funcionarios.id_base')
            ->select('bases.*', 'funcionarios.*')
            ->where('bases.id_base', '=', Auth::user()->funcionario->id_base)
            ->where('Nome', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('Sobrenome', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('numero_mecanografico', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('funcionario_tipo', 'LIKE', '%' . $receber->pesquisar . '%')
            ->paginate();

        $dados = [
            'funcionarios' =>  $funcionarios,
            'pesquisar' =>  $funcionarios,
            'rota_de_pesquisa' => '/funcionario/pesquisar/base'

        ];
        //dd(Funcionario::where(1));

        return view('funionarios.listar', $dados);
    }


}


