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
        Schema::create('ordem_servico', function (Blueprint $table) {
            $table->id('id_os');
            $table->string('tipo_os');
            $table->string('situacao_os');
            $table->string('descricao_os');
            $table->timestamps();
        });

        Schema::create('servicos_requesitados', function (Blueprint $table) {
            $table->id('id_servico');
            $table->string('nome_servico');
            $table->string('descricao');
            $table->timestamps();
        });

        Schema::create('ordem_servico_imagens', function (Blueprint $table) {
            $table->id('id_imagem_os');
            $table->string('caminho_imagem');
            $table->timestamps();
        });

        Schema::create('ordem_servico_servicos_requesitados', function (Blueprint $table) {
            $table->id('id_servico_servicos_requesitados');
            $table->Integer('item_selecionado');
            $table->timestamps();
        });

        /**** criando relacionamentos  *******************************/
        Schema::table('servicos_requesitados', function (Blueprint $table) {
            $table->unsignedBigInteger('id_os');
            $table->foreign('id_os')->references('id_os')->on('ordem_servico');
        });

        Schema::table('ordem_servico', function (Blueprint $table) {
            $table->unsignedBigInteger('id_veiculo');
            $table->foreign('id_veiculo')->references('id_veiculo')->on('veiculos');
        });

    
        Schema::table('ordem_servico_servicos_requesitados', function (Blueprint $table) {
            $table->unsignedBigInteger('id_servico');
            $table->foreign('id_servico')->references('id_servico')->on('servicos_requesitados');
        });

        Schema::table('ordem_servico_servicos_requesitados', function (Blueprint $table) {
            $table->unsignedBigInteger('id_os');
            $table->foreign('id_os')->references('id_os')->on('ordem_servico');
        });

        Schema::table('ordem_servico_imagens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_os');
            $table->foreign('id_os')->references('id_os')->on('ordem_servico');
        });
        /********************** criando relacionamentos ****************************/
        Schema::create('ordem_servico_cheklist', function (Blueprint $table) {
            $table->id('id_os_checklist');
            $table->Integer('item_selecionado');
            $table->timestamps();
        });

        Schema::table('ordem_servico_cheklist', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_os');
            $table->foreign('fk_id_os')->references('id_os')->on('ordem_servico');
        });

        Schema::table('ordem_servico_cheklist', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_item_checklist');
            $table->foreign('fk_id_item_checklist')->references('id_checklist')->on('checklists');
        });

        Schema::table('ordem_servico', function (Blueprint $table) {
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
        Schema::dropIfExists('ordem_servico');
        Schema::dropIfExists('ordem_servico_imagens');
        Schema::dropIfExists('servicos_requesitados');
    }
};
