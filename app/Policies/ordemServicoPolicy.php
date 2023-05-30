<?php

namespace App\Policies;

use App\Models\OrdemServico;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ordemServicoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function updateOrdemServico(User $user, OrdemServico $OS)
    {
       //dd($user->funcionario->id_funcionario == $OS->id_supervisor);
        return $user->funcionario->id_funcionario == $OS->id_funcionario	;

    }

    public function view(User $user, OrdemServico $OS = null)
    {
        $funcionarios_permitidos = ["administrador_base", "administrador_senior", "administrador", "supervisor"];

        if (in_array($user->funcionario->funcionario_tipo, $funcionarios_permitidos)) {
            return true;
        } else {
            return false;
        }
    }

    public function EditarImgem(User $user, OrdemServico $OS)
    {
        return $user->funcionario->id_funcionario == $OS->id_supervisor;
    }
}
