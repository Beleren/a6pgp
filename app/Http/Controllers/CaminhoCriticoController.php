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
        $nos = [];

        foreach ($atividades as $atividade) {
            $sequencias = $atividade->sequencias->where('cenario_id', $cenario->id);

            $aux = $sequencias->first();

            if ($aux) {
                $duracao = $aux->duracao;
            } else {
                $duracao = null;
            }

            $no = new No($atividade->id, $duracao, $atividade->nome);

            foreach ($sequencias as $sequencia) {

                if ($sequencia->atividade_predecessora_id) {
                    dd($sequencia);

                    /* Corrigir este foreach */
                    $no->adicionarPredecessora($no_pred);
                }
            }

            array_push($nos, $no);
        }

        foreach ($nos as $no) {
            $no->calcPDI();
            $no->calcPDF();
        }

        $this->mostrarCaminhoCritico($nos);
    }

    private function verificarDependenciaRecursiva() {

    }

    private function mostrarCaminhoCritico($nos) {
        $caminho = new Caminho($nos);
        $caminho->mostrarCaminhoCritico();
    }
}