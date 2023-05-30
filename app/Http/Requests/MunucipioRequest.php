<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MunucipioRequest extends FormRequest
{
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
              'id_provincia' => ['required','numeric','present'],
              'nome_municipio' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/',Rule::unique('municipios','nome_municipio')->ignore($this->id,'id_municipio')],
        ];

             // redirect()->route('login');
    }

    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
              'nome_municipio.regex' => 'valor informado esta invalido',
              'nome_municipio.unique' => 'o valor informado ja existe',
              'nome_municipio.required' =>'O campo muncipio não pode estar vazio',
              'id_provincia.numeric' => 'o valor informado ja existe',
              'id_provincia.required' =>'selecione a provincia',
              'id_provincia.present' =>'O id nao esta present',
          ];
          
    }

}
