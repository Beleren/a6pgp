<?php
/**
 * Created by PhpStorm.
 * User: marivaldo
 * Date: 18-Oct-17
 * Time: 20:24
 */

namespace App;

use Doctrine\Common\Comparable;

class No implements Comparable
{
    private $id;
    private $duracao;
    private $predecessoras = [];
    private $sucessoras = [];
    private $nome;
    private $pdi; // Primeira Data de Início
    private $pdf; // Primeira Data de Fim
    private $udi; // Última Data de Início
    private $udf; // Última Data de Fim
    private $folga;
    private static $maiorPDF;

    public function __construct($id, $duracao, $nome)
    {
        $this->id = $id;
        $this->duracao = $duracao;
        $this->nome = $nome;
    }

    public function adicionarPredecessora(No $atividade){
        array_push($this->predecessoras, $atividade);
        $atividade->adicionarSucessora($this);
    }

    public function adicionarSucessora(No $atividade) {
        array_push($this->sucessoras, $atividade);
    }

    /* Getters */
    public function getPDI() {
        return $this->pdi;
    }

    public function getPDF() {
        return $this->pdf;
    }

    public function getUDI() {
        return $this->udi;
    }

    public function getUDF() {
        return $this->udf;
    }

    public static function getMaiorPDF() {
        return self::$maiorPDF;
    }

    public function getDuracao() {
        return $this->duracao;
    }

    public function getPredecessoras() {
        return $this->predecessoras;
    }

    public function getSucessoras() {
        return $this->sucessoras;
    }

    /* Setters */
    public function setPDI($valor) {
        $this->pdi = $valor;
    }

    public function setPDF($valor) {
        $this->pdf = $valor;
    }

    public function setUDI($valor) {
        $this->udi = $valor;
    }

    public function setUDF($valor) {
        $this->udf = $valor;
    }

    public function setMaiorPDF($valor) {
        self::$maiorPDF = $valor;
    }

    /* Processos */
    public function calcPDI() {
        $resultado = 0;

        foreach ($this->predecessoras as $predecessora) {
            if ($predecessora->getPDF() > 0) {
                if ($predecessora->getPDF() > $resultado) {
                    $resultado = $predecessora->getPDF();
                }
            } else {
                $resultado = 0;
            }
        }

        $this->setPDI($resultado);
    }

    public function calcPDF() {
        $resultado = 0;
        $maior_pdf = 0;

        foreach ($this->predecessoras as $predecessora) {
            if ($predecessora->getPDF() > 0) {
                if ($predecessora->getPDF() > $maior_pdf) {
                    $maior_pdf = $predecessora->getPDF();
                    $resultado = $maior_pdf + $this->duracao;
                }
            } else {
                $resultado = $this->duracao;
            }
        }

        $this->setPDF($resultado);
    }

    public function calcUDI() {
        $resultado = $this->getUDF() - $this->getDuracao();

        $this->setUDI($resultado);
    }

    public function calcUDF() {
        $udf_procurado = self::getMaiorPDF();
        $resultado = $this->getPDF();

        foreach($this->predecessoras as $predecessora) {
            if ($predecessora->getUDF() > 0 && $predecessora->getUDI() < $udf_procurado) {
                $udf_procurado = $predecessora->getUDI();
            } else {
                if ($predecessora->getPDF() != self::getMaiorPDF()) {
                    $predecessora->calcUDF();
                    $predecessora->calcUDI();
                    $udf_procurado = $predecessora->getUDF();
                } else {
                    $udf_procurado = self::getMaiorPDF();
                    $resultado = $udf_procurado;
                    $this->setUDF($resultado);
                    $this->calcUDI();
                }
            }
        }

        $this->setUDF($resultado);
    }

    /* Método para comparar atividades. */
    public function compareTo($outra) {
        if (! $outra instanceof No) {
            throw new \Exception('Não é possível fazer a comparação.');
        }

        if ($this->getPDF() > $outra->getPDF()) {
            return 1;
        } else if ($this->getPDF() < $outra->getPDF()) {
            return -1;
        } else {
            return 0;
        }
    }
}