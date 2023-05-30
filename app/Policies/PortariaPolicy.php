<?php

namespace App\Policies;
use App\Models\User;
use App\Models\portaria;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortariaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
  
   public function updateportaria(User $user,Portaria $portaria)
    {
        return $user->funcionario->id_funcionario == $portaria->fk_id_supervisor;
    }

    public function view(User $user, portaria $portaria = null)
    {
        $funcionarios_permitidos = ["administrador_base","administrador_senior","administrador","supervisor"];

        if(in_array($user->funcionario->funcionario_tipo,$funcionarios_permitidos)) {
               return true;
         }else {
             return false;
         }

    }

    public function EditarImgem(User $user,Portaria $portaria)
    {
        return $user->id == $portaria->fk_id_supervisor;
    }

}
    
