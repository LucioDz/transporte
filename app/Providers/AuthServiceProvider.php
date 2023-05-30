<?php

namespace App\Providers;

use App\Models\Checklist;
use App\Models\Funcionario;
use App\Models\Manutencaopreventiva;
use App\Models\OrdemServico;
use App\Models\User;
use App\Models\portaria;
use App\Models\veiculo;
use App\Policies\ChecklistPolicy;
use App\Policies\veiculoPolicy;
use App\Policies\PortariaPolicy;
use App\Policies\FuncionarioPolicy;
use App\Policies\ManutencaoPreventivaPolicy;
use App\Policies\ordemServicoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    //'App\Models\Model' => 'App\Policies\ModelPolicy',
         portaria::class => PortariaPolicy::class,
         Funcionario::class => FuncionarioPolicy::class,
         veiculo::class => veiculoPolicy::class,
         Checklist::class => ChecklistPolicy::class,
         OrdemServico::class => ordemServicoPolicy::class,
         Manutencaopreventiva::class => ManutencaoPreventivaPolicy::class,
    ];                                                                    

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
   
    public function boot()
    {
           Gate::define('AdcionarImagemPortaria', function (User $user, Portaria $portaria) {
                 return $user->id == $portaria->registrado_por;
           });

           $this->registerPolicies();
  
    }
}
