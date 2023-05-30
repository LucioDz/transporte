<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manutencao_preventiva_cheklist extends Model
{
    use HasFactory;
    
    public $table = "manutencao_preventiva_cheklist";
    protected $primaryKey = "id_checklist";

}
