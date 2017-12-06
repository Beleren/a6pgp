<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataInicioProjetoToCenariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cenarios', function (Blueprint $table) {
            $table->dateTime('data_inicio_projeto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cenarios', function (Blueprint $table) {
            $table->dropColumn('data_inicio_projeto');
        });
    }
}
