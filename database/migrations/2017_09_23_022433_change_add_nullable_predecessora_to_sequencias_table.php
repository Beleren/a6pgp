<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAddNullablePredecessoraToSequenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sequencias', function (Blueprint $table) {
            $table->unsignedInteger('atividade_predecessora')->nullable()->change();
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
            $table->unsignedInteger('atividade_predecessora')->change();
        });
    }
}
