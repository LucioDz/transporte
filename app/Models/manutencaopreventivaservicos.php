<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manutencaopreventivaservicos extends Model
{
    use HasFactory;
    public $table = "manutencaopreventivaservicos";
    protected $primaryKey = "id_servico";
}
