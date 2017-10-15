<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataInicioDispRecursoToSequenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sequencias', function (Blueprint $table) {
            $table->dateTime('data_inicio_disp_recurso')->nullable();
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
            $table->dropColumn('data_inicio_disp_recurso');
        });
    }
}
