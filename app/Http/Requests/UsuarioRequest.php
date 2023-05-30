<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
            'id_funcionario' => ['required','numeric','present'],
            'funionario_email' => ['required','email',Rule::unique('users','email')->ignore($this->id,'id')],
            'funionario_senha' => ['required','min:8'],
            'funionario_confirmar_senha' => ['required','same:funionario_senha'],
        ];
    }
    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
            'funionario_email.required' => 'Preencha o campo Usuario',
            'funionario_email.email' => 'Email Invalido',
            'funionario_email.unique' => 'Este email ja existe existe',
            'funionario_senha.required' => 'Preencha o Campo Senha',
            'funionario_senha.required' => 'Preecnha o campo senha',
            'funionario_senha.min' => 'A senha seve ter no minimo :min caracteres',
            'funionario_confirmar_senha.required' => 'Comfirme a Senha',
            'funionario_confirmar_senha.same' => 'A senhas são diferentes',
          ];
    }

}
