<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manutencaopreventiva extends Model
{
    use HasFactory;
    public $table = "manutencao_preventiva";
    protected $primaryKey = "id_preventiva";
}
