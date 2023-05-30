<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginRequest;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Funcionario;

class UsuarioController extends Controller
{

    public function login()
    {
        if(Auth::check()){
            return redirect('/');
         }

        return view('auth.login');
    }

    public function entrar(loginRequest $receber)
    {

        $receber->validated();
     
        $credencias = ['email' => $receber->usuario,'password' => $receber->senha];
  
        if (Auth::attempt($credencias)) {
           
            return redirect('/');

        } else {

            return redirect('/login')->with('erro_login', 'Usuario ou Senha Invalida');
        }
    }

    protected function create(UsuarioRequest $receber)
    {
        $funcionarios_permitidos_a_fazer_login = ['administrador', 'supervisor'];
        //findOrFail encontrado o funcioanrio eo delete() apagando ele
        $funcionario =  Funcionario::findOrFail($receber->id_funcionario);
       
        //verificanfo funcionario ja pertence a tabela usuarios
        //$funcionario_usuario = DB::table('user')->where('fk_id_funcionario', '=',$funcionario->id_funcionario);
        $funcionario_usuario  = User::where('fk_id_funcionario', '=', $funcionario->id_funcionario)->first();

      //veirficando se o funcionario pode ser um usario no sistema !e se ele nao existe na tabela usuarios
        if (in_array($funcionario->funcionario_tipo,$funcionarios_permitidos_a_fazer_login) 
        && $funcionario_usuario == null ) {

            $receber->validated();
            // inserindo dados do usuario no banco
          
            $user = new User();
            $user->nome = 'test';
            $user->senha = bcrypt($receber->funionario_senha);
            $user->email = $receber->funionario_email;
            $user->id_funcionario = $receber->id_funcionario;
        
            /*
            $user =  DB::table('users')->insert([
                'nome' => 'lucio',
                'email' =>  $receber->funionario_email,
                'senha' =>  Hash::make($receber->senha),
                'fk_id_funcionario' =>  $receber->id_funcionario,
            ]);
            */
            if ($user->save()) {
               
                $funcionario =  Funcionario::findOrFail($receber->id_funcionario);
              
                return redirect('/funcionario/listar')->with('msg', 'Funcionario Actulizado com sucesso');
             
            } else {
                return redirect('/funcionario/listar')->with('ERRO', 'Erro ao actulizar dados tente novamente');
            }
        } else {
            return redirect('/funcionario/listar')->with('ERRO', 'Erro ao actulizar dados tente novamente');
        }
    }

    protected function update(UsuarioRequest $receber,$id_funcionario)
    {
        $funcionarios_permitidos_a_fazer_login = ['administrador', 'supervisor'];
        //findOrFail encontrado o funcioanrio eo delete() apagando ele
        $funcionario =  Funcionario::findOrFail($receber->id_funcionario);
       
        //verificanfo funcionario ja pertence a tabela usuarios
        //$funcionario_usuario = DB::table('user')->where('fk_id_funcionario', '=',$funcionario->id_funcionario);
        $funcionario_usuario  = User::where('fk_id_funcionario', '=', $funcionario->id_funcionario)->first();

       //veirficando se o funcionario pode ser um usario no sistema !e se ele ja e um usuario
       if (in_array($funcionario->funcionario_tipo,$funcionarios_permitidos_a_fazer_login) 
        && $funcionario_usuario != null ) {
    
            $receber->validated();
          
            $dados = ['email' => $receber->usuario,'senha' => $receber->funionario_senha];
           
            $user = auth()->user()->update($dados);

            if ($user) {
               
                $funcionario =  Funcionario::findOrFail($receber->id_funcionario);
              
              return redirect('/funcionario/listar')->with('msg', 'Funcionario Actulizado com sucesso');
             
            } else {
                return redirect('/funcionario/listar')->with('ERRO', 'Erro ao actulizar dados tente novamente');
            }
        } else {
            return redirect('/funcionario/listar')->with('ERRO', 'Erro ao actulizar dados tente novamente');
        }
    }
}
