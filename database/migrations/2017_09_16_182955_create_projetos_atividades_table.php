<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjetosAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projetos_atividades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('projeto_id');
            $table
                ->foreign('projeto_id')
                ->references('id')
                ->on('projetos')
                ->onDelete('cascade');

            $table->unsignedInteger('atividade_id');
            $table
                ->foreign('atividade_id')
                ->references('id')
                ->on('atividades')
                ->onDelete('cascade');

            $table->index(['projeto_id', 'atividade_id']);

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
        Schema::dropIfExists('projetos_atividades');
    }
}
