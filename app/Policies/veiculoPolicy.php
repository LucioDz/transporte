<?php

namespace App\Policies;
use App\Models\User;
use App\Models\veiculo;
use Illuminate\Auth\Access\HandlesAuthorization;

class veiculoPolicy
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
     * @param  \App\Models\veiculo  $veiculo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, veiculo $veiculo = null)
    {
        //
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
     * @param  \App\Models\veiculo  $veiculo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, veiculo $veiculo)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\veiculo  $veiculo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function editar(User $user, veiculo $veiculo)
    {
        $funcionarios_permitidos = ["administrador_senior"];

        if ($user->funcionario->id_base == $veiculo->id_base 
        && $user->funcionario->funcionario_tipo == "administrador_base") {
                return true;
        } else {
            // verificando se o tem permissao para editar 
            if (in_array($user->funcionario->funcionario_tipo,$funcionarios_permitidos)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function delete(User $user, veiculo $veiculo)
    {
        $funcionarios_permitidos = ["administrador_senior"];

        if ($user->funcionario->id_base == $veiculo->id_base 
        && $user->funcionario->funcionario_tipo == "administrador_base") {
                return true;
        } else {
            // verificando se o tem permissao para editar 
            if (in_array($user->funcionario->funcionario_tipo,$funcionarios_permitidos)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\veiculo  $veiculo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, veiculo $veiculo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\veiculo  $veiculo
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, veiculo $veiculo)
    {
        //
    }
}
