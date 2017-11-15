<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSequenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cenario_id');
            $table
                ->foreign('cenario_id')
                ->references('id')
                ->on('cenarios');

            $table->dateTime('inicio_otimista')->nullable();
            $table->dateTime('fim_otimista')->nullable();
            $table->dateTime('inicio_pessimista')->nullable();
            $table->dateTime('fim_pessimista')->nullable();

            $table->unsignedInteger('atividade_id');
            $table
                ->foreign('atividade_id')
                ->references('id')
                ->on('atividades');

            $table->unsignedInteger('recurso_id');
            $table
                ->foreign('recurso_id')
                ->references('id')
                ->on('recursos');


            $table->unsignedMediumInteger('quantidade_recurso')->nullable();
            $table->unsignedInteger('atividade_predecessora');
            $table
                ->foreign('atividade_predecessora')
                ->references('id')
                ->on('atividades');

            $table->boolean('requer_recursos')->default(false);
            $table->float('tempo_alocado')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sequencias');
    }
}
