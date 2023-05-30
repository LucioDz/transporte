<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\provincia;
use App\Models\Municipio;
use App\Http\Requests\ProvinciaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class provinciaController extends Controller
{
   
    public function cadastrar()
    {

     $provincias_angola = ['Bengo','Benguela','Bié','Cabinda','Cuando-Cubango','Cuanza-Sul','Cuanza-Norte',
        'Cunene','Huambo','Huíla','Luanda','Lunda Norte','Lunda Sul','Malanje','Moxico','Namibe'.'Uíge','Zaire'];

      //  $provincias = provincia_base::all();
      $provincias = DB::table('provincias')->orderBy('nome_provincia','ASC')->get();

      $provincias_pais = DB::table('provincias')->orderBy('nome_provincia','ASC')->paginate(50);

      $muncipios_provincias = DB::table('municipios')
            ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
            ->select('municipios.*', 'provincias.*')
            ->orderBy('nome_provincia','ASC')
            ->get();

        //dd($muncipios_provincias);

         $dados = [
             'exibir_formulario_provincia' => 'd-none',
             'provincias' =>   $provincias,
             'provincias_pais' => $provincias_pais,
             'muncipios_provincias' => $muncipios_provincias,
         ];

        return view('provincia.cadastrar',$dados);
    }


    public function store(ProvinciaRequest $receber)
    {

        // validando os dados do formulario
      
        $receber->validated();
     
        $provincia = new provincia();

        $provincia->nome_provincia =  $receber->nome_provincia;
        $provincia->registrado_por = Auth::user()->id;

        if ($provincia->save()) {
            return redirect('/cadastrar/provincia')->with('msg', 'Cadastro relizado com sucesso');
        } else {
            return redirect('/cadastrar/provincia')->with('ERRO', 'Erro ao salvar veiculo na Base de dados');
        }
    
    }

      public function deletar_provincia($id)
     {
       //$provincias = DB::table('municipios')->where('id_provincia',$id)->get();
       $provincias = DB::table('municipios')->where('id_provincia', $id)->exists();

        if ($provincias > 0) {
            return redirect('/cadastrar/provincia')->with('ERRO', 'Registro não pode ser excluído por estar em uso');
        }
        else {
            if (provincia::findOrFail($id)->delete()) {
                return redirect('/cadastrar/provincia')->with('msg', 'Dados excluidos com sucesso');
            }
            else {
                return redirect('/cadastrar/provincia')->with('ERRO', 'Erro ao excluir registro na Base de dados');
            }
        }
    
    }

    public function editar_provinvia($id)
    {

        $provincia =  provincia::findOrFail($id);

        $dados = [
            'provincia' => $provincia,
        ];

          return view('provincia.editar', $dados);
    }


    public function actulizar_provinvia(ProvinciaRequest  $receber)
    {

        $receber->validated();

            $dados_actulizar = [
                'nome_provincia' =>  $receber->nome_provincia,
            ];
        
        $checklist = DB::table('provincias')->where('id_provincia',$receber->id)->update($dados_actulizar);

        if ($checklist) {
            return redirect('/cadastrar/provincia')->with('msg', 'Dados Actulizado com sucesso');
        } else {
            return redirect('/cadastrar/provincia')->with('ERRO', 'Erro ao actulizar dados tente novamente');
        }
    }



}
