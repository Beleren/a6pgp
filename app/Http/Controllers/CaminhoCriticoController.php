<?php

namespace App\Http\Controllers;

use App\Atividade;
use App\Caminho;
use App\No;
use App\Cenario;
use App\Projeto;
use App\Sequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /*
     *  popular nós; - acredito que ainda esteja com problemas, os nós não programam as predecessores nem sucessores em cada nó.
     */
    private function caminhoCriticoPorMaiorDuracao(Projeto $projeto, Cenario $cenario) {
        $atividades = $projeto->atividades;

        //array de nós para programação
        $nos = [];

        //iteração de todas atividades do projeto
        foreach ($atividades as $atividade) {
            $sequencias = Sequencia::selectRaw(
                'atividade_id,
                            ANY_VALUE(inicio_otimista) as inicio_otimista,
                            ANY_VALUE(fim_otimista) as fim_otimista,
                            ANY_VALUE(inicio_pessimista) as inicio_pessimista,
                            ANY_VALUE(fim_pessimista) as fim_pessimista,
                            ANY_VALUE(atividade_predecessora_id) as atividade_predecessora_id,
                            ANY_VALUE(duracao) as duracao')
                ->where('cenario_id', $cenario->id)
                ->where('atividade_id', $atividade->id)
                ->groupBy('atividade_id','atividade_predecessora_id')
                ->get();

            if ($sequencias->first()) {
                /*
                 * Captura duração da atividade atual porque a duração existe na entidade
                 * Sequência.
                 */

                $duracao = $sequencias->first()->duracao;
            } else {
                /*
                 * Se não houver sequências no banco de dados, a duração é nula.
                 */
                $duracao = null;
            }

            //instancia um novo nó para a atividade atual
            $no = new No($atividade->id, $duracao, $atividade->nome, $projeto->id, $cenario->id);

            array_push($nos, $no);
        }

        foreach ($nos as $i => $no) {
            $no->calcPDF();
            $no->calcPDI();
        }

        dd($nos);

        $this->mostrarCaminhoCritico($nos);
    }

    private function verificarDependenciaRecursiva() {

    }

    private function mostrarCaminhoCritico($nos) {
        $caminho = new Caminho($nos);
        $caminho->mostrarCaminhoCritico();
    }
}