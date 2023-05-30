<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ordem_servico_imagens extends Model
{
    use HasFactory;

    public $table = "ordem_servico_imagens";
    protected $primaryKey = "id_imagem_os";
    
}
