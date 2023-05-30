<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Http\Requests\MunucipioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MuncipioController extends Controller
{
    public function cadastrar()
    {
     $provincias_angola = ['Bengo','Benguela','Bié','Cabinda','Cuando-Cubango','Cuanza-Sul','Cuanza-Norte',
        'Cunene','Huambo','Huíla','Luanda','Lunda Norte','Lunda Sul','Malanje','Moxico','Namibe'.'Uíge','Zaire'];

      //  $provincias = provincia_base::all();
      $provincias = DB::table('provincias')->orderBy('id_provincia', 'DESC')->get();

      $provincias_pais = DB::table('provincias')->orderBy('nome_provincia', 'ASC')->paginate(10);

        //dd($funcionarios);

         $dados = [
             'exibir_formulario_provincia' => 'd-none',
             'provincias' =>   $provincias,
             'provincias_pais' => $provincias_pais,
         ];

        return view('provincia.cadastrar',$dados);
    }

    public function store(MunucipioRequest $receber)
    {

        // validando os dados do formulario
      
        $receber->validated();
     
        $municipio = new Municipio();

        $municipio->id_provincia =  $receber->id_provincia;
        $municipio->nome_municipio =  $receber->nome_municipio;
        $municipio->registrado_por = Auth::user()->id;

        if ($municipio->save()) {
            return redirect('/cadastrar/provincia')->with('msg', 'Cadastro relizado com sucesso');
        } else {
            return redirect('/cadastrar/provincia')->with('ERRO', 'Erro ao salvar veiculo na Base de dados');
        }
    
    }

      public function deletar_municipio($id_checklist)
    {
        
        $municipios = DB::table('bases')->where('id_municipio',$id_checklist)->exists();
         
        if ($municipios > 0) {
            return redirect('/cadastrar/provincia')->with('ERRO', 'Registro não pode ser excluído por estar em uso');
        }
        else {
            if (Municipio::findOrFail($id_checklist)->delete()) {
                return redirect('/cadastrar/provincia')->with('msg', 'Dados excluidos com sucesso');
            }
            else {
                return redirect('/cadastrar/provincia')->with('ERRO', 'Erro ao excluir registro na Base de dados');
            }
        }
    
    }

    public function editar_municipio($id)
    {

        $municipio =  Municipio::findOrFail($id);

        $provincias = DB::table('provincias')->orderBy('id_provincia', 'DESC')->get();
        
        $dados = [
            'municipio' =>   $municipio,
            'provincias' =>   $provincias,
        ];

          return view('municipio.editar', $dados);
    }


    public function actulizar_municipio(MunucipioRequest  $receber)
    {

         $receber->validated();

         $dados_actulizar = [
            'id_provincia' => $receber->id_provincia,
            'nome_municipio' =>   $receber->nome_municipio,
        ];

        $municipios = DB::table('municipios')->where('id_municipio',$receber->id)->update($dados_actulizar);

        if ($municipios) {
            return redirect('/cadastrar/provincia')->with('msg', 'Dados Actulizado com sucesso');
        } else {
            return redirect('/cadastrar/provincia')->with('ERRO', 'Erro ao actulizar dados tente novamente');
        }
    }



}
