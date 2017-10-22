<?php
/**
 * Created by PhpStorm.
 * User: marivaldo
 * Date: 18-Oct-17
 * Time: 20:24
 */

namespace App;


class No
{
    public $id;
    public $duracao;
    public $predecessoras = [];
    public $nome;
    public $pdi; // Primeira Data de Início
    public $pdf; // Primeira Data de Fim
    public $udi; // Última Data de Início
    public $udf; // Última Data de Fim
    public $folga;


    public function __construct($id, $duracao, $nome)
    {
        $this->id = $id;
        $this->duracao = $duracao;
        $this->nome = $nome;
    }

    public function adicionarPredecessora(No $atividade){
        array_push($this->predecessoras, $atividade);
    }

    public function calcPDI() {
        $soma = 0;

        foreach ($this->predecessoras as $predecessora) {
            $soma += $predecessora->getPDF();
        }

        if ($soma <= 0 && $this->duracao == 0) {
            $soma = 0;
        } else {
            $soma += 1;
        }

        $this->pdi = $soma;
    }

    public function calcPDF() {
        $soma = 0;

        $this->calcPDI();

        if ($this->pdi) {
            $soma = $this->pdi + $this->duracao - 1;
        } else {
            $soma = $this->duracao;
        }

        $this->pdf = $soma;
    }

    public function getPDI() {
        $this->calcPDI();
        return $this->pdi;
    }

    public function getPDF() {
        $this->calcPDF();
        return $this->pdf;
    }
}