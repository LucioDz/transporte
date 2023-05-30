<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicosRequisitados extends Model
{
    use HasFactory;

    public $table = "servicos_requesitados";
    protected $primaryKey = "id_servico";

}
