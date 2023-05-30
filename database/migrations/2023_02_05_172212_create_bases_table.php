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
        Schema::create('provincias', function (Blueprint $table) {
            $table->id('id_provincia');
            $table->string('nome_provincia');
            $table->bigInteger('registrado_por');
            $table->timestamps();
        });

         /***Municipio***/
        Schema::create('municipios', function (Blueprint $table) {
            $table->id('id_municipio');
            $table->string('nome_municipio');
            $table->bigInteger('registrado_por');
            $table->timestamps();
        });

      
         /*** Bases   ***/
        Schema::create('bases', function (Blueprint $table) {
         $table->id('id_base');
         $table->string('nome_base');
         $table->text('descricao_base');
         $table->text('imagem');
         $table->bigInteger('registrado_por');
         $table->timestamps();  
        });

        Schema::table('municipios', function (Blueprint $table) {
            $table->unsignedBigInteger('id_provincia');
            $table->foreign('id_provincia')->references('id_provincia')->on('provincias');
        });

        Schema::table('bases', function (Blueprint $table) {
            $table->unsignedBigInteger('id_municipio');
            $table->foreign('id_municipio')->references('id_municipio')->on('municipios');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bases');
    }
};
