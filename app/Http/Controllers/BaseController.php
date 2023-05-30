<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\base;
use App\Models\Municipio;
use App\Http\Requests\BaseRequest;
use Faker\Provider\Base as ProviderBase;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function cadastrar()
    {

        $provincias_angola = [
            'Bengo', 'Benguela', 'Bié', 'Cabinda', 'Cuando-Cubango', 'Cuanza-Sul', 'Cuanza-Norte',
            'Cunene', 'Huambo', 'Huíla', 'Luanda', 'Lunda Norte', 'Lunda Sul', 'Malanje', 'Moxico', 'Namibe' . 'Uíge', 'Zaire'
        ];

        // $provincias = provincia_base::all();

        $muncipios_provincias = DB::table('municipios')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('municipios.*', 'provincias.*')->orderBy('provincias.nome_provincia', 'ASC')
            ->get();

        //   dd($muncipios_provincias);

        $dados = [
            'exibir_formulario_provincia' => 'd-none',
            'provincias' =>  $provincias_angola,
            'muncipios_provincias' => $muncipios_provincias,
        ];

        //  dd($muncipios_provincias);

        return view('base.cadastrar', $dados);
    }

    public function store(BaseRequest $receber)
    {
        //validando os dados do formulario

        $receber->validated();
        //
        $municipio = Municipio::findOrFail($receber->id_municipio);

        $base = new base();

        $caimniho  = $receber->foto_de_perfil != null ? $receber->foto_de_perfil->store('imagens/funcionarios') : '';
        $caimniho_do_arquivo = $caimniho;
        $base->nome_base =  $receber->nome_base;
        $base->descricao_base =  $receber->descricao ?? '';;
        $base->imagem = $caimniho_do_arquivo;
        $base->id_municipio =  $municipio->id_municipio;
        $base->registrado_por = Auth::user()->id;

        if ($base->save()) {
            return redirect('/base/listar')->with('msg', 'Cadastro relizado com sucesso');
        } else {
            return redirect('/base/listar')->with('ERRO', 'Erro ao salvar veiculo na Base de dados');
        }
    }

    public function listar()
    {
        $Bases = DB::table('bases')
            ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('bases.*', 'municipios.*', 'provincias.*')
            ->paginate();

        //dd($Bases);

        $dados = [
            'Bases' => $Bases,
        ];

        //dd(Funcionario::where(1));

        return view('base.listar', $dados);
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

        $Bases = DB::table('bases')
            ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('bases.*', 'municipios.*', 'provincias.*')
            ->where('bases.nome_base', 'like', '%' . $receber->pesquisar . '%')
            ->orWhere('municipios.nome_municipio', 'like', '%' . $receber->pesquisar . '%')
            ->orWhere('provincias.nome_provincia', 'like', '%' . $receber->pesquisar . '%')
            ->paginate();

        // dd($Bases);
        /*
        $funcionarios = Base::where('Nome', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('Sobrenome', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('numero_mecanografico', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('funcionario_tipo', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('class_funcao1', 'LIKE', '%' . $receber->pesquisar . '%')
            ->orWhere('class_funcao2', 'LIKE', '%' . $receber->pesquisar . '%')
            ->paginate();
          */
        //dd($funcionarios);
        $dados = [
            'pesquisar' =>      $Bases,
            'Bases' => $Bases,
        ];

        //  dd($Bases);

        return view('base.listar', $dados);
    }

    public function deletar_base($id)
    {
        //findOrFail encontrado o funcioanrio eo delete() apagando ele

        //verificando a relação com outras tabelas antes de apagar
        $Registro_em_uso_muncipios = DB::table('bases')->where('id_municipio', $id)->exists();
        $Registro_em_uso_veiculos = DB::table('veiculos')->where('id_base', $id)->exists();
        $Registro_em_uso_funcionarios = DB::table('funcionarios')->where('id_base', $id)->exists();

        if ($Registro_em_uso_muncipios > 0 || $Registro_em_uso_veiculos > 0 ||  $Registro_em_uso_funcionarios) {
            return redirect('/base/listar')->with('ERRO', 'Registro não pode ser excluído por estar em uso');
        } else {
            if (Municipio::findOrFail($id_checklist)->delete()) {
                return redirect('/base/listar')->with('msg', 'Dados excluidos com sucesso');
            } else {
                return redirect('/base/listar')->with('ERRO', 'Erro ao excluir registro na Base de dados');
            }
        }
    }

    public function editar_base($id)
    {

        $Base = DB::table('bases')
            ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('bases.*', 'municipios.*', 'provincias.*')->where('bases.id_base', '=', $id)
            ->get();

        //dd($Base);
        $muncipios_provincias = DB::table('municipios')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('municipios.*', 'provincias.*')->orderBy('provincias.nome_provincia', 'ASC')
            ->get();

        // dd($muncipios_provincias);

        $dados = [
            'exibir_formulario_provincia' => 'd-none',
            'muncipios_provincias' =>  $muncipios_provincias,
            'base' => $Base,
        ];

        return view('base.editar', $dados);
    }


    public function actulizar_base(BaseRequest $receber)
    {
        $receber->validated();

        $municipio = Municipio::findOrFail($receber->id_municipio);

        $caimniho = $receber->foto_de_perfil != null ? $receber->foto_de_perfil->store('imagens/bases') : '';

        $dados_actulizar = [
            'nome_base' => $receber->nome_base,
            'id_municipio' => $municipio->id_municipio,
            'descricao_base' => $receber->descricao,
            'imagem' =>  $caimniho,
        ];

        $base = DB::table('bases')->where('id_base', $receber->id)->update($dados_actulizar);

        if ($base) {
            return redirect('/base/listar')->with('msg', 'Dados Actulizado com sucesso');
        } else {
            return redirect('/base/listar')->with('ERRO', 'Erro ao actulizar dados tente novamente');
        }
    }

    public function perfil($id)
    {
        $TotaldeoVeiculodaBase = array();
        $TotaldeoFunionariosdaBase = array();
        $TotaldeSaidas = array();
        $TotaldeEntradas = array();

        $base = DB::table('bases')
            ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('bases.*', 'municipios.*', 'provincias.*')->where('bases.id_base', '=', $id)->get();

        // verificando se exite veiculo ou funcionario associado a base
        if (
            DB::table('veiculos')->where('id_base', $id)->exists()
            || DB::table('funcionarios')->where('id_base', $id)->exists()
        ) {

            if (DB::table('veiculos')->where('id_base', $id)->exists()) {

                $TotaldeoVeiculodaBase = DB::table('veiculos')->where('id_base', $id)->get();
            }

            // verificando se exite funcionario associado a esta base
            if (DB::table('funcionarios')->where('id_base', $id)->exists()) {

                $TotaldeoFunionariosdaBase = DB::table('funcionarios')->where('id_base', $id)->get();
            }

            // verificado se existe um veiculo da que ja fez uma entrada ou saida
            if (DB::table('portaria as P')
                ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                ->select('P.*', 'veiculos.*',)->where('veiculos.id_base', '=', $id)
                ->where('portaria_tipo', '=','Entrada')->exists()
            ) {

                $TotaldeEntradas = DB::table('portaria as P')
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
                    )->where('veiculos.id_base', '=', $id)
                    ->where('portaria_tipo', '=', 'Entrada')->orderBy('id_portaria', 'Desc')->get();
            }

            // verificado se existe um veiculo da que ja fez uma saida
            if (DB::table('portaria as P')
                ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                ->select('P.*', 'veiculos.*',)->where('veiculos.id_base', '=', $id)
                ->where('portaria_tipo', '=', 'Saida')->exists()
            ) {

                $TotaldeSaidas = DB::table('portaria as P')
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
                    )->where('veiculos.id_base', '=', $id)
                    ->where('portaria_tipo', '=', 'Saida')->orderBy('id_portaria', 'Desc')->get();
            }
        }

        $dados = [
            'TotaldeoVeiculodaBase'  => $TotaldeoVeiculodaBase,
            'TotaldeoFunionariosdaBase'  => $TotaldeoFunionariosdaBase,
            'TotaldeEntradas'  => $TotaldeEntradas,
            'TotaldeSaidas'  => $TotaldeSaidas,
            'id_veiculo' => $id,
            'base' => $base
        ];

        return view('base.perfil', $dados);
    }
}
