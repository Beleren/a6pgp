<?php

namespace App\Http\Controllers;

use App\Caminho;
use App\No;
use App\Cenario;
use App\Projeto;
use Illuminate\Http\Request;

class CaminhoCriticoController extends Controller
{
    public function index(Projeto $projeto, Cenario $cenario) {
        return 'CaminhoCriticoController@index';
    }

    private function calculoIngenuo(Projeto $projeto, Cenario $cenario) {
        $this->authorize('view-projeto', $projeto);

    }

    public function caminhoCriticoPorMaiorDuracao()
    {
        $inicio = new No(0, 0, 'início');
        $a = new No(1, 2, 'a');
        $b = new No(2, 4, 'b');
        $c = new No(3, 10, 'c');
        $d = new No(4, 6, 'd');
        $e = new No(5, 4, 'e');
        $f = new No(6, 5, 'f');
        $g = new No(7, 7, 'g');
        $h = new No(8, 9, 'h');
        $i = new No(9, 7, 'i');
        $j = new No(10, 8, 'j');
        $k = new No(11, 4, 'k');
        $l = new No(12, 5, 'l');
        $m = new No(13, 2, 'm');
        $n = new No(14, 6, 'n');
        $fim = new No(15, 0, 'fim');

        $atividades = [$inicio, $a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $fim];

        $a->adicionarPredecessora($inicio);
        $b->adicionarPredecessora($a);
        $c->adicionarPredecessora($b);
        $d->adicionarPredecessora($c);
        $e->adicionarPredecessora($c);
        $i->adicionarPredecessora($c);
        $g->adicionarPredecessora($d);
        $h->adicionarPredecessora($g);
        $h->adicionarPredecessora($e);
        $f->adicionarPredecessora($e);
        $j->adicionarPredecessora($i);
        $j->adicionarPredecessora($f);
        $k->adicionarPredecessora($j);
        $l->adicionarPredecessora($j);
        $n->adicionarPredecessora($k);
        $n->adicionarPredecessora($l);
        $m->adicionarPredecessora($h);
        $fim->adicionarPredecessora($m);
        $fim->adicionarPredecessora($n);

        $html = '<ul>';

        $caminhos = [];

        foreach($atividades as $atividade) {
            $caminho = new Caminho();

            $html = $html . '<li>Atividade: ' . $atividade->nome . ' (PDI: ' . $atividade->getPDI() .
                ', PDF:' . $atividade->getPDF() .')';

            foreach ($atividade->predecessoras as $predecessora) {
                $html = $html . '<li>' . $predecessora->nome . '</li>';
            }
            $html = $html . '</li>';
        }
        $html = $html . '</ul>';

        dd($atividades);
        echo $html;
    }
}