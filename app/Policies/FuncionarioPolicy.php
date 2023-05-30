<?php

namespace App\Policies;

use App\Models\Funcionario;
use App\Http\Requests\FuncionarioRequest;
use App\Models\User;
use App\Models\Base;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;


class FuncionarioPolicy
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
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Funcionario $funcionario = null)
    {
        $funcionarios_permitidos = ["administrador_base", "administrador_senior", "administrador"];

        if (in_array($user->funcionario->funcionario_tipo, $funcionarios_permitidos)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
    }
    /**
     * Determine whether the user can update the model.
     * @param  \App\Models\User  $user
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function editar(User $user, Funcionario $funcionario)
    {
        $funcionarios_permitidos = ["administrador_senior"];

        // verificando se pertencem a mesma base
        if (
            $user->funcionario->id_base == $funcionario->id_base
            && $user->funcionario->funcionario_tipo == "administrador_base"
        ) {
            return true;
        } else {
            // verificando se o tem permissao para editar 
            if (in_array($user->funcionario->funcionario_tipo, $funcionarios_permitidos)) {
                return true;
            } else {
                return false;
            }
        }
    }
    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Funcionario $funcionario)
    {
        $funcionarios_permitidos = ["administrador_senior"];

        // verificando se pertencem a mesma base
        if (
            $user->funcionario->id_base == $funcionario->id_base
            && $user->funcionario->funcionario_tipo == "administrador_base"
        ) {
            return true;
        } else {
            // verificando se o tem permissao para editar 
            if (in_array($user->funcionario->funcionario_tipo, $funcionarios_permitidos)) {
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
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Funcionario $funcionario)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Funcionario $funcionario)
    {
        //
    }

    public function isAdmin(User $user, Funcionario $funcionario = null)
    {
        $funcionarios_permitidos = ["administrador_base", "administrador_senior", "administrador"];

        if (in_array($user->funcionario->funcionario_tipo, $funcionarios_permitidos)) {
            return true;
        } else {
            return false;
        }
    }

    public function isMotoristaOuCobrador(User $user, Funcionario $funcionario)
    {
        $funcionarios_permitidos = ["motorista", "cobrador"];

        if (in_array($funcionario->funcionario_tipo, $funcionarios_permitidos)) {
            return true;
        } else {
            return false;
        }
    }

    public function isCobrador(User $user, Funcionario $funcionario)
    {
        $funcionarios_permitidos = ["cobrador"];

        if (in_array($funcionario->funcionario_tipo, $funcionarios_permitidos)) {
            return true;
        } else {
            return false;
        }
    }

    public function isMotorista(User $user, Funcionario $funcionario)
    {
        $funcionarios_permitidos = ["motorista"];

        if (in_array($funcionario->funcionario_tipo, $funcionarios_permitidos)) {
            return true;
        } else {
            return false;
        }
    }
}
