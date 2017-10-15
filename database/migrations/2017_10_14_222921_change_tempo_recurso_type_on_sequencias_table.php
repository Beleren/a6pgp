<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTempoRecursoTypeOnSequenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sequencias', function (Blueprint $table) {
            $table->time('tempo_alocado')->change();
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
            $table->dateTime('tempo_alocado')->change();
        });
    }
}
