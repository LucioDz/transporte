<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class veiculo extends Model
{
    use HasFactory;

    protected $primaryKey = "id_veiculo";

    protected $fillable = [
        'id_base',
        'marca' ,
        'prefixo' ,
        'matricula' ,
        'modelo',
        'motor',
        'chassis',
        'lugares_sentados',
        'lugares_em_pe',
        'lotacao',
        'ano',
        'pais',
        'kilometragem' ,
        'situacao',
        'registrado_por',
    ];

}

