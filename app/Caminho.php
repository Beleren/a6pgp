<?php
/**
 * Created by PhpStorm.
 * User: marivaldo
 * Date: 24-Oct-17
 * Time: 21:37
 */

namespace App;

class Caminho
{
    public $nos = [];
    public $duracao;

    public function __construct(Caminho $caminho = null) {
        if ($caminho) {
            $this->duracao = $caminho->duracao;
            $this->nos = $caminho->nos;
        }
    }

    public function adicionarNo(No $no){
        array_push($this->nos, $no);
    }
}