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
        Schema::create('portaria', function (Blueprint $table) {
            $table->id('id_portaria');
            $table->string('portaria_tipo');
            $table->text('descricao');
            $table->string('portaria_kilometragem');
            $table->string('situcao_veiculo');
            $table->timestamps();
            $table->timestamp('dataHora')->useCurrent();
        });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portaria');
    }
};
