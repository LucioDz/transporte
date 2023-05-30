<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("
            <h1 style='text-align:center;padding:30px;background-color:#f44336;color:white;
            border-radius:15px;margin:20px;'>
             Sem conexão com a base de dados</h1>");
        }        //
        Paginator::useBootstrap();

    }
}
