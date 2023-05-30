<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class cheklistRequest extends FormRequest
{
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
              'nome' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/',Rule::unique('checklists','nome_item')->ignore($this->id,'id_checklist')],
             //'tipo' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/',], 
        ];

             // redirect()->route('login');
    }

    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){
          return [   
              'nome.regex' => 'valor informado esta invalido',
              'nome.unique' => 'o valor informado ja existe no checklist',
              'nome.required' =>'O campo nome não pode estar vazio',
             //'tipo.regex' => 'valor informado esta invalido',
             //'tipo.required' =>'O campo tipo não pode estar vazio',
          ];
    }
}
