<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseRequest extends FormRequest
{
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
              'id_municipio' => ['required','numeric','present'],
              'nome_base' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/',Rule::unique('bases','nome_base')->ignore($this->id,'id_base')],
              'foto_de_perfil' => ['photo'=>'mimetypes:image/jpeg,image/png'],
              'foto_de_perfil' => ['photo'=>'mimes:jpg,bmp,png','max:10240'],
        ];

             // redirect()->route('login');
    }

    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
              'nome_base.regex' => 'valor informado esta invalido',
              'nome_base.unique' => 'o valor informado ja existe',
              'nome_base.required' =>'O campo nome pode estar vazio',
              'id_municipio.numeric' => 'o valor informado ja existe',
              'id_municipio.required' =>'selecione a provincia',
              'id_municipio.present' =>'O id não esta present',
              'foto_de_perfil.mimetypes' => 'Extensão não Permitida',
              'foto_de_perfil.mimes' => 'Extensão não Permitida',
              'foto_de_perfil.mimes' => 'Extensão do arquivo não Permitida',
              'foto_de_perfil.max' => 'A foto de deve ter no maximo 10 megabytes',
          ];
          
    }

}
