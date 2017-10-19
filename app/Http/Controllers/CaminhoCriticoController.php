<?php

namespace App\Http\Controllers;

use App\Caminho;
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
        $inicio = new Caminho(0, 0, 'início');
        $a = new Caminho(1, 2, 'a');
        $b = new Caminho(2, 4, 'b');
        $c = new Caminho(3, 10, 'c');
        $d = new Caminho(4, 6, 'd');
        $e = new Caminho(5, 4, 'e');
        $f = new Caminho(6, 5, 'f');
        $g = new Caminho(7, 7, 'g');
        $h = new Caminho(8, 9, 'h');
        $i = new Caminho(9, 7, 'i');
        $j = new Caminho(10, 8, 'j');
        $k = new Caminho(11, 4, 'k');
        $l = new Caminho(12, 5, 'l');
        $m = new Caminho(13, 2, 'm');
        $n = new Caminho(14, 6, 'n');
        $fim = new Caminho(15, 0, 'fim');

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

        foreach($atividades as $atividade) {
            $html = $html . '<li>Atividade: ' . $atividade->nome;

            foreach ($atividade->predecessoras as $predecessora) {
                $html = $html . '<li>' . $predecessora->nome . '</li>';
            }
            $html = $html . '</li>';
        }
        $html = $html . '</ul>';
        echo $html;
    }
}