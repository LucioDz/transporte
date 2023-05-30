<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
{
    
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
              'usuario' => ['required','email'],
              'senha' => ['required'],
        ];
    }

    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
              'usuario.required' => 'Preecnha o campo usuario',
              'usuario.email' => 'Usuario iformado invalido',
              'senha.required' => 'Preecnha o campo senha',
          ];
    }

}
