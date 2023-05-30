<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Manutencaopreventiva;
use Illuminate\Auth\Access\HandlesAuthorization;

class ManutencaoPreventivaPolicy
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

    
    public function update(User $user, Manutencaopreventiva $manutencao)
    {
       //dd($user->funcionario->id_funcionario == $OS->id_supervisor);
        return $user->funcionario->id_funcionario == $manutencao->id_funcionario;

    }
}
