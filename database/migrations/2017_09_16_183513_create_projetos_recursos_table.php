<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetosRecursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos_recursos', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('projeto_id');
            $table
                ->foreign('projeto_id')
                ->references('id')
                ->on('projetos')
                ->onDelete('cascade');

            $table->unsignedInteger('recurso_id');
            $table
                ->foreign('recurso_id')
                ->references('id')
                ->on('recursos')
                ->onDelete('cascade');

            $table->index(['projeto_id', 'recurso_id']);

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
        Schema::dropIfExists('projetos_recursos');
    }
}
