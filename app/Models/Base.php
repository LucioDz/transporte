<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;

    public $table = "bases";
    protected $primaryKey = "id_base";

    public function base(){
          return  $this->hasMany('App\Models\Users');
    }

}
