<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manutencao_preventiva_imagens extends Model
{
    use HasFactory;

    public $table = "manutencao_preventiva_imagens";
    protected $primaryKey = "id_imagem_preventiva";

}
