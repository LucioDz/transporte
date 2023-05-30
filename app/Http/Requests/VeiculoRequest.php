<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VeiculoRequest extends FormRequest
{
    public function rules()
    {
    //definido que campo email nao pode esta vazio e se formato do email esta correto
        return [
              'marca' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'prefixo' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/',Rule::unique('veiculos','prefixo')->ignore($this->id,'id_veiculo')],
              'matricula' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/',Rule::unique('veiculos','matricula')->ignore($this->id,'id_veiculo')],
              'modelo' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'motor' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'chassis' => ['required','regex:/^[0-9-A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'lugares_sentados' => ['required','numeric'],
              'em_pe' => ['required','numeric'],
              'lotacao' => ['required','numeric'],
              'ano_fabrico' => ['required','numeric'],
              'pais' => ['required','regex:/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]+$/'],
              'kilometragem' => ['required','numeric'],
              'base' => ['numeric','required'],
              'foto_de_perfil' => ['photo'=>'mimetypes:image/jpeg,image/png'],
              'foto_de_perfil' => ['photo'=>'mimes:jpg,bmp,png','max:10240'],
              'situacao' => ['required', "array","min:1","max:1"]             
        ];

             // redirect()->route('login');
    }

    /*Metodo para retornar mensagens caso as imformacoes fornicidas nao 
    atedam aos requisito acimsa  especificados */
    public function messages(){

          return [
              'foto_de_perfil.mimetypes' => 'Extensão não Permitida',
              'foto_de_perfil.mimes' => 'Extensão não Permitida',
              'foto_de_perfil.max' => 'A foto de deve ter no maximo 10 megabytes',
              'marca.required' =>'campo marcar não pode estar vazio',
              'marca.regex' => 'valor imformado esta invalido',
              'prefixo.required' =>'O campo prefixo não pode estar vazio',
              'prefixo.regex' => 'valor imformado esta invalido',
              'prefixo.unique' => 'Este prefixo ja existe',
              'matricula.required' =>'O campo matricula não pode estar vazio',
              'matricula.regex' => 'valor informado esta invalido',
              'matricula.unique' => 'Esta matricula ja Existe',
              'modelo.required' =>'O campo modelo não pode estar vazio',
              'modelo.regex' => 'valor informado esta invalido',
              'motor.required' =>'O campo motor não pode estar vazio',
              'motor.regex' => 'valor imformado esta invalido',
              'chassis.required' =>'O campo chassis não pode estar vazio',
              'chassis.regex' => 'valor informado esta invalido',
              'lugares_sentados.required' =>'O campo Lugares Sentados não pode estar vazio',
              'lugares_sentados.numeric' => 'Preencha o campo com valores numericos',
              'em_pe.required' =>'O campo Lugares Em Pe não pode estar vazio',
              'em_pe.numeric' => 'Preencha o campo com valores numericos',
              'lotacao.required' =>'O campo Lotação não pode estar vazio',
              'lotacao.numeric' => 'Preencha o campo com valores numericos',
              'kilometragem.required' =>'O campo Lotação não pode estar vazio',
              'kilometragem.numeric' => 'Preencha o campo com valores numericos',
              'ano_fabrico.required' =>'O campo ano de fabrico não pode estar vazio',
              'ano_fabrico.numeric' => 'Preencha o campo com valores numericos',
              'pais.required' => 'Selecione o pais',
              'pais.regex' => 'o valor informado esta invalido',  
              'base.required' => 'Selecione a Base ',
              'base.numeric' => 'valor invalido',
              'situacao.required' => 'Selecione a situção do veiculo',
              'situacao.max' => 'Selecione Apenas uma situção',
          ];
    }
}
