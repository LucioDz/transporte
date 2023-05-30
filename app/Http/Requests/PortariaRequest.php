<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortariaRequest extends FormRequest
{
   
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
              'tipo' => ['required','regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'situacao' => ['required','regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'veiculo' => ['required','numeric','present'],
              'motorista' => ['required','regex:/^[0-9]+$/','present'],
              'kilometragem' => ['required','numeric'],
              'cobrador' => ['required','regex:/^[0-9]+$/','present'],
              'imagens.*' => ['photo'=>'mimetypes:image/jpeg,image/png',"array"],
              'imagens.*' => ['photo'=>'mimes:jpg,bmp,png','max:10240'],
              'item_check' => ['required', "array"],       
              'descricao' => ['present']       
        ];

             // redirect()->route('login');
    }

    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
              'tipo.required' => 'Selecione o tipo',
              'tipo.regex' => 'valor imformado esta invalido',
              'situacao.required' => 'Situação do veiculo',
              'situacao.regex' => 'valor imformado esta invalido',
              'veiculo.required' => 'Selecione o veiculo',
              'veiculo.numeric' => 'valor invalido',
              'motorista.regex:/^[0-9]+$/' => 'valor invalido',
              'motorista.required' => 'Selecione o Motorista',
              'cobrador.regex:/^[0-9]+$/' => 'valor invalido',
              'cobrador.required' => 'Selecione o Cobrador',
              'kilometragem.between' => 'valor invalido',
              'kilometragem.required' => 'Insira a kilometrgem do Veiculo',
              'imagens.mimetypes' => 'Extensão não Permitida',
              'imagens.mimes' => 'Extensão não Permitida',
              'imagens.mimes' => 'Extensão do arquivo não Permitida',
              'imagens.max' => 'A foto de deve ter no maximo 10 megabytes',
              'item_check.required' => 'Selecione Um item no cheklist',
          ];
   
    }
}
