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
        Schema::create('manutencao_preventiva', function (Blueprint $table) {
            $table->id('id_preventiva');
            $table->string('tipo_manutencao');
            $table->string('previsao_da_manutencao');
            $table->string('estado');
            $table->timestamps();
        });

        Schema::create('ManutencaoPreventivaServicos', function (Blueprint $table) {
            $table->id('id_servico');
            $table->string('nome_servico');
            $table->string('descricao');
            $table->timestamps();
        });

        Schema::create('manutencao_preventiva_imagens', function (Blueprint $table) {
            $table->id('id_imagem_preventiva');
            $table->string('caminho_imagem');
            $table->timestamps();
        });

        /**** criando relacionamentos  *******************************/
        Schema::table('ManutencaoPreventivaServicos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_preventiva');
            $table->foreign('id_preventiva')->references('id_preventiva')->on('manutencao_preventiva');
        });

        Schema::table('manutencao_preventiva', function (Blueprint $table) {
            $table->unsignedBigInteger('id_veiculo');
            $table->foreign('id_veiculo')->references('id_veiculo')->on('veiculos');
        });

        Schema::table('manutencao_preventiva_imagens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_preventiva');
            $table->foreign('id_preventiva')->references('id_preventiva')->on('manutencao_preventiva');
        });

        /********************** criando relacionamentos ****************************/
        Schema::create('manutencao_preventiva_cheklist', function (Blueprint $table) {
            $table->id('id_checklist');
            $table->Integer('item_selecionado');
            $table->timestamps();
        });

        Schema::table('manutencao_preventiva_cheklist', function (Blueprint $table) {
            $table->unsignedBigInteger('id_preventiva');
            $table->foreign('id_preventiva')->references('id_preventiva')->on('manutencao_preventiva');
        });

        Schema::table('manutencao_preventiva_cheklist', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_item_checklist');
            $table->foreign('fk_id_item_checklist')->references('id_checklist')->on('checklists');
        });

        Schema::table('manutencao_preventiva', function (Blueprint $table) {
            $table->unsignedBigInteger('id_funcionario');
            $table->foreign('id_funcionario')->references('id_funcionario')->on('funcionarios');
        });
        /*************************************************************************/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manutencao_preventiva');
    }
};
