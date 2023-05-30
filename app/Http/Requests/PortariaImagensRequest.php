<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortariaImagensRequest extends FormRequest
{
   
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [   
              'imagens' => ['required'],
              'imagens.*' => ['required','photo'=>'mimetypes:image/jpeg,image/png',"array"],
              'imagens.*' => ['photo'=>'mimes:jpg,bmp,png','max:10240'],
        ];

             // redirect()->route('login');
    }

    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
              'imagens.required' => 'Selecione as imagens',
              'imagens.mimetypes' => 'Extensão não Permitida',
              'imagens.mimes' => 'Extensão não Permitida',
              'imagens.mimes' => 'Extensão do arquivo não Permitida',
              'imagens.max' => 'A foto de deve ter no maximo 10 megabytes',
             
          ];
    }
}
