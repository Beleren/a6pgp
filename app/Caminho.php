<?php
/**
 * Created by PhpStorm.
 * User: marivaldo
 * Date: 18-Oct-17
 * Time: 20:24
 */

namespace App;


class Caminho
{
    public $id;
    public $duracao;
    public $predecessoras = [];
    public $nome;

    public function __construct($id, $duracao, $nome)
    {
        $this->id = $id;
        $this->duracao = $duracao;
        $this->nome = $nome;
    }

    public function adicionarPredecessora(Caminho $atividade){
        array_push($this->predecessoras, $atividade);
    }
}