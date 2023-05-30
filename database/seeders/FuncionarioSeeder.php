<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funcionarios')->insert([
            'numero_mecanografico' => 66554334556,
            'id_base' =>  2,
            'Nome' => 'admin',
            'Sobrenome' => 'pinto',
            'imagem' => Str::random(10),
            'funcionario_tipo' => 'administrador_base',
            'descricao' => Hash::make('password'),
            'registrado_por' => null
        ]);
    
        DB::table('users')->insert([
            'id_funcionario' => DB::getPdo()->lastInsertId(),
            'email' =>'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('11111111'),
            'remember_token' => Str::random(10)
        ]);

    }
}
