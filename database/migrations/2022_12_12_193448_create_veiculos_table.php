<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id('id_veiculo');
            $table->string('imagem');
            $table->string('marca');
            $table->string('prefixo')->unique();
            $table->string('matricula')->unique();
            $table->string('modelo');
            $table->string('motor');
            $table->string('chassis');
            $table->integer('lugares_sentados');
            $table->integer('lugares_em_pe');
            $table->integer('lotacao');
            $table->year('ano');
            $table->string('pais');
            $table->Double('kilometragem');
            $table->string('situacao');
            $table->bigInteger('registrado_por');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('veiculos');
    }
};
