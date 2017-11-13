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

        $this->calcPDF();
    }

    public function adicionarPredecessora(No $atividade){
        array_push($this->predecessoras, $atividade);
    }

    public function calcPDI() {
        $maior_fim = null;

        foreach($this->predecessoras as $predecessora) {
            if ($predecessora->pdf) {
                if ($maior_fim < $predecessora->pdf) {
                    $maior_fim = $predecessora->pdf;
                }
            } else {
                if ($maior_fim <= $predecessora->duracao) {
                    $maior_fim = $predecessora->pdf;
                }
            }
        }

        $this->pdi = $maior_fim;
    }

    public function calcPDF() {
        $fim = null;

        foreach ($this->predecessoras as $predecessora) {
            if ($predecessora->pdf) {
                if ($fim < $predecessora->pdf) {
                    $fim = $predecessora->pdf;
                }
            } else {
                $fim = $predecessora->pdf + $this->duracao;
            }
        }

        $this->pdf = $fim;
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