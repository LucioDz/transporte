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
        Schema::create('portaria_imagens', function (Blueprint $table) {
            $table->id('id_portaria_imagem');
            $table->text('caminho_imagem');
            $table->timestamps();
        });

        Schema::table('portaria_imagens', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_portaria');
            $table->foreign('fk_id_portaria')->references('id_portaria')->on('portaria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portaria_imagens');
    }
};
