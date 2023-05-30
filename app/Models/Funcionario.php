<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $primaryKey = "id_funcionario";

    //protected $fillable = ['zip','numero_mecanografico,Nome,Sobrenome,imagem,funcionario_tipo,class_funcao1,class_funcao2'];
    //protected $fillable = ['options->enabled',];
  
       public function usuario()
    {
        return $this->hasOne('App\Models\Users','id','id_funcionario');
    }

}
