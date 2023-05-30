<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FuncionarioRequest extends FormRequest
{
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
              'nome' => ['required','regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'sobrenome' => ['required','regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'base' => ['numeric','required'],
              'numero_mecanografico' => ['required','numeric',Rule::unique('funcionarios')->ignore($this->id,'id_funcionario')],
              'foto_de_perfil' => ['photo'=>'mimetypes:image/jpeg,image/png'],
              'foto_de_perfil' => ['photo'=>'mimes:jpg,bmp,png','max:10240'],
              'funcionario_tipo' => ['required', "array","min:1","max:1"]             
        ];
             // redirect()->route('login');
    }
    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
              'foto_de_perfil.mimetypes' => 'Extensão não Permitida',
              'foto_de_perfil.mimes' => 'Extensão não Permitida',
              'foto_de_perfil.mimes' => 'Extensão não Permitida',
              'foto_de_perfil.max' => 'A foto de deve ter no maximo 10 megabytes',
              'nome.required' => 'Preencha o campo Nome',
              'nome.regex' => 'Nome imformado esta invalido',
              'sobrenome.required' => 'Preencha o campo Sobrenome',
              'sobrenome.regex' => 'Sobrenome imformado esta invalido',
              'base.required' => 'Selecione a Base ',
              'base.numeric' => 'valor invalido',
              'numero_mecanografico.required' => 'Preencha O campo numero mecanografico',
              'numero_mecanografico.numeric' => 'Preencha o Campo com valores numericos',
              'numero_mecanografico.unique' => 'Este numero Mecanografico ja existe',
              'funcionario_tipo.required' => 'Selecione o tipo de funionario',
              'funcionario_tipo.max' => 'Selecione Apenas um tipo de Funcionario',  
          ];
    }
}

/* 
              'funionario_email' => ['required','email'],
              'funionario_senha' => ['required'],
              'funionario_confirmar_senha' => ['required','same:funionario_senha'],
--------------------
              'funionario_email.required' => 'Preencha o campo Usuario',
              'funionario_email.email' => 'Email Invalido',
              'funionario_senha.required' => 'Preencha o Campo Senha',
              'funionario_confirmar_senha.required' => 'Comfirme a Senha',
              'funionario_confirmar_senha.same' => 'A senhas são diferentes',
*/