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
       Schema::create('portaria_cheklist', function (Blueprint $table) {
            $table->id('id_portaria_checklist');
            $table->Integer('item_selecionado');
            $table->timestamps();
        });

        Schema::table('portaria_cheklist', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_portaria');
            $table->foreign('fk_id_portaria')->references('id_portaria')->on('portaria');
        });

        Schema::table('portaria_cheklist', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_id_item_checklist');
            $table->foreign('fk_id_item_checklist')->references('id_checklist')->on('checklists');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portaria_cheklist');
    }
};
