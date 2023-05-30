<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provincias')->insert([
            'nome_provincia' => 'Luanda',
            'registrado_por' => 1,
        ]);

        DB::table('municipios')->insert([
            'id_provincia' => DB::getPdo()->lastInsertId(),
            'nome_municipio' => "Luanda"
        ]);

        DB::table('bases')->insert([
            'id_municipio' => DB::getPdo()->lastInsertId(),
            'nome_base' => 'Base de Viana',
            'registrado_por' => 1,
        ]);


        DB::table('funcionarios')->insert([
            'numero_mecanografico' => 665543345,
             'id_base' =>  DB::getPdo()->lastInsertId(),
            'Nome' => 'samuel',
            'Sobrenome' => 'pinto',
            'imagem' => Str::random(10),
            'funcionario_tipo' => 'administrador_base',
            'descricao' => Hash::make('password'),
            'registrado_por' => null
        ]);
    
        DB::table('users')->insert([
            'id_funcionario' => DB::getPdo()->lastInsertId(),
            'email' =>'samuelraio@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('11111111'),
            'remember_token' => Str::random(10)
        ]);

        DB::table('funcionarios')->insert([
            'numero_mecanografico' => 6655433455,
            'id_base' =>   1,
            'Nome' => 'tiago',
            'Sobrenome' => 'pinto',
            'imagem' => Str::random(10),
            'funcionario_tipo' => 'cobrador',
            'descricao' => Hash::make('password'),
            'registrado_por' => null
        ]);

        DB::table('funcionarios')->insert([
            'numero_mecanografico' => 6655433454,
            'id_base' =>   1,
            'Nome' => 'pedro',
            'Sobrenome' => 'paulo',
            'imagem' => Str::random(10),
            'funcionario_tipo' => 'motorista',
            'descricao' => Hash::make('password'),
            'registrado_por' => null
        ]);

        DB::table('veiculos')->insert([
            'id_base' =>   1,
            'prefixo' => '200UB3',
            'marca' => 'volvo',
            'modelo' => Str::random(10)
        ]);

    }
}
