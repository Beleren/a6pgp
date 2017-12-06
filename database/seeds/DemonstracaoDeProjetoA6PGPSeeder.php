<?php

use Illuminate\Database\Seeder;

class DemonstracaoDeProjetoA6PGPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Projetos */
        DB::table('projetos')->insert([
            'nome' => 'Demonstração do Projeto A6PGP',
        ]);


    }
}
