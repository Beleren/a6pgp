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
        $atividades = $projeto->sequencias()->where('cenario_id', $cenario->id);

        foreach ($atividades as $atividade) {
            $no = new No()
        }

        dd($atividades);
    }

    public function verificarDependenciaRecursiva() {

    }
}