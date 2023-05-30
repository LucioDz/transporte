<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProvinciaRequest extends FormRequest
{
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
              'nome_provincia' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/',Rule::unique('provincias','nome_provincia')->ignore($this->id,'id_provincia')],
        ];

             // redirect()->route('login');
    }

    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
             
              'nome_provincia.regex' => 'valor informado esta invalido',
              'nome_provincia.unique' => 'o valor informado ja existe',
              'nome_provincia.required' =>'O campo provincia não pode estar vazio',
          ];
    }

}
