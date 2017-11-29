<?php

namespace App\Http\Controllers;

use App\Atividade;
use App\Caminho;
use App\No;
use App\Cenario;
use App\Projeto;
use Illuminate\Http\Request;

class CaminhoCriticoController extends Controller
{
    public function index(Projeto $projeto, Cenario $cenario) {
        $this->authorize('view-projeto', $projeto);

        $this->caminhoCriticoPorMaiorDuracao($projeto, $cenario);

        return 'CaminhoCriticoController@index';
    }

    private function calculoIngenuo(Projeto $projeto, Cenario $cenario) {
        $this->authorize('view-projeto', $projeto);

    }

    private function caminhoCriticoPorMaiorDuracao(Projeto $projeto, Cenario $cenario) {
        $atividades = $projeto->atividades;

        foreach ($atividades as $atividade) {
            $predecessoras = $atividade->sequencias->where('cenario_id', $cenario->id);

            $duracao = $predecessoras->first();

            if (! $duracao) {
                $duracao = null;
            }

            $no = new No($atividade->id, $duracao, $atividade->nome);

            foreach ($predecessoras as $predecessora) {
                $no_pred = new No($predecessora->atividade_id, $predecessora->duracao, $predecessora->atividade->nome);

                $no->adicionarPredecessora($no_pred);
            }
        }

        $this->mostrarCaminhoCritico($atividades);
    }

    public function verificarDependenciaRecursiva() {

    }

    public function mostrarCaminhoCritico($atividades) {
        $caminho = new Caminho($atividades);
        $caminho->mostrarCaminhoCritico();
    }
}