<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNomeAtividadePredecessoraOnSequenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sequencias', function (Blueprint $table) {
            $table->renameColumn('atividade_predecessora', 'atividade_predecessora_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sequencias', function (Blueprint $table) {
            $table->renameColumn('atividade_predecessora_id', 'atividade_predecessora');
        });
    }
}
