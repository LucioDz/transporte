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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_funcionario');
            $table->foreign('id_funcionario')->references('id_funcionario')->on('funcionarios');
        });

        Schema::table('funcionarios', function (Blueprint $table) {
            $table->unsignedBigInteger('id_base');
            $table->foreign('id_base')->references('id_base')->on('bases');
        });

        Schema::table('veiculos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_base');
            $table->foreign('id_base')->references('id_base')->on('bases');
        });
        
        /*************  portaria  *********************************************/ 

        Schema::table('portaria', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_motorista');
            $table->foreign('fk_id_motorista')->references('id_funcionario')->on('funcionarios');
        });

        Schema::table('portaria', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_ajudante');
            $table->foreign('fk_id_ajudante')->references('id_funcionario')->on('funcionarios');
        });

        Schema::table('portaria', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_supervisor');
            $table->foreign('fk_id_supervisor')->references('id_funcionario')->on('funcionarios');
        });

        Schema::table('portaria', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_veiculo');
            $table->foreign('fk_id_veiculo')->references('id_veiculo')->on('veiculos');
        });

        /***********************************************************************/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
};
