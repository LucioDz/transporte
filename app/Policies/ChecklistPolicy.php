<?php

namespace App\Policies;

use App\Models\User;
use App\Models\checklist;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChecklistPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, checklist $checklist = null)
    {
       
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, checklist $checklist)
    {
        //
    } 

    public function editar(User $user, checklist $checklist)
    {
        $funcionarios_permitidos = ["administrador_senior","administrador_base"];
       
        //verificando se o tem permissao para deletar 
      if (in_array($user->funcionario->funcionario_tipo,$funcionarios_permitidos)) {
          return true;
       } else {
          return false;
       }
    } 

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, checklist $checklist)
    { 
          $funcionarios_permitidos = ["administrador_senior","administrador_base"];
       
              //verificando se o tem permissao para deletar 
            if (in_array($user->funcionario->funcionario_tipo,$funcionarios_permitidos)) {
                return true;
            } else {
                return false;
            }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, checklist $checklist)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\checklist  $checklist
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, checklist $checklist)
    {
        //
    }
}
