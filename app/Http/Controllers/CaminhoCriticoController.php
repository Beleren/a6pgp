<?php

namespace App\Http\Controllers;

use App\No;
use App\Cenario;
use App\Projeto;
use Illuminate\Http\Request;

class CaminhoCriticoController extends Controller
{
    public function index(Projeto $projeto, Cenario $cenario) {
        $this->authorize('view-projeto', $projeto);

        $this->caminhoCriticoPorMaiorDuracao($projeto, $cenario);

        dd('TODO');
        return 'CaminhoCriticoController@index';
    }

    private function calculoIngenuo(Projeto $projeto, Cenario $cenario) {
        $this->authorize('view-projeto', $projeto);

    }

    private function caminhoCriticoPorMaiorDuracao(Projeto $projeto, Cenario $cenario) {
        $atividades = $projeto->sequencias->where();

        foreach ($atividades as $atividade) {
            dd($atividade->sequencias->all());
        }

        dd($atividades);
    }

    public function verificarDependenciaRecursiva() {

    }
}