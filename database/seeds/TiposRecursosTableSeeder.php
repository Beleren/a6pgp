<?php

use Illuminate\Database\Seeder;

class TiposRecursosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_recursos')->delete();

        $dados = [
            1 => 'Humano',
            2 => 'Físico',
            3 => 'Financeiro',
            4 => 'Tecnológico',
        ];

        foreach ($dados as $chave => $valor)
        {
            DB::table('tipos_recursos')->insert([
                'id' => $chave,
                'nome' => $valor,
            ]);
        }
    }
}
