<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicosRequisitadosRequest extends FormRequest
{

    public function rules()
    {
        return [
           'descricao' => ['present'],
            'tipo_os' => ['required',],
            'situacao_os' => ['required'],
            'veiculo' => ['required', 'numeric'],
            'servicos' => ['present',],
        ];
    }
/*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

        return [
            'imagens.mimetypes' => 'Extensão não Permitida',
            'imagens.mimes' => 'Extensão não Permitida',
            'imagens.mimes' => 'Extensão do arquivo não Permitida',
            'imagens.max' => 'A foto de deve ter no maximo 10 megabytes',
            'item_check.required' => 'Selecione Um item no cheklist',
        ];
 
  }

}
