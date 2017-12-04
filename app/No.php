<?php
/**
 * Created by PhpStorm.
 * User: marivaldo
 * Date: 18-Oct-17
 * Time: 20:24
 */

namespace App;

use Carbon\Carbon;
use Doctrine\Common\Comparable;

class No implements Comparable
{
    private $id;
    private $duracao;
    private $predecessoras = [];
    private $sucessoras = [];
    private $nome_atividade;
    private $pdi; // Primeira Data de Início
    private $pdf; // Primeira Data de Fim
    private $udi; // Última Data de Início
    private $udf; // Última Data de Fim
    private $projeto;
    private $cenario;
    private $folga;
    private static $maiorPDF;
    private $atividade;


    public function __construct($id, $duracao, $nome, $projeto, $cenario)
    {
        $this->id = $id;
        $this->duracao = $duracao;
        $this->nome_atividade = $nome;
        $this->projeto = Projeto::find($projeto);
        $this->cenario = Cenario::find($cenario);
        $this->atividade = Atividade::find($id);
    }

    public function adicionarPredecessora(No $atividade){
        array_push($this->predecessoras, $atividade);

        $atividade->adicionarSucessora($this);
    }

    public function adicionarSucessora(No $atividade) {
        array_push($this->sucessoras, $atividade);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /* Getters */
    public function getPDI() {
        return $this->pdi;
    }

    public function getPDF() {
        $atividade = Sequencia::where('cenario_id', $this->cenario->id)
            ->where('atividade_id', $this->id)
            ->first();

        if ($atividade) {
            $pdf = $atividade->fim_otimista;
        } else {
            $pdf = null;
        }

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

    /*precisaremos usar o conceito de varredura de árvore para programação de atividades
    acredito que o problema dos cálculos em relação ao código em java é a ordenação do array*/
    public function calcPDI() {
        $resultado = 0;

        foreach ($this->predecessoras as $predecessora) {
            if ($predecessora->getPDF());

            if ($predecessora->getPDF()) {
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

        /* Verifica se a atividade possui predecessoras */
        if ($this->predecessoras) {
            $maior_pdf = 0;

            foreach ($this->predecessoras as $predecessora) {
                /* Predecessora possui PDF calculado */

                if (! $predecessora->getPDF()) {
                    $predecessora->calcPDF();
                    $this->calcPDF();
                    $maior_pdf = $predecessora->getPDF();
                    $resultado = $maior_pdf + $this->duracao;
                }

                if ($predecessora->getPDF() > $maior_pdf) {
                    $maior_pdf = $predecessora->getPDF();
                    $resultado = $maior_pdf + $this->duracao;
                }
            }
        /* Se não possui predecessoras, o PDF é a duração. */
        } else {
            $resultado = $this->duracao;
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
            if ($predecessora->getUDF() && $predecessora->getUDI() < $udf_procurado) {
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

    public function __toString()
    {
        return 'Atividade: ' . $this->nome_atividade .  ', Duração: ' . $this->getDuracao() .
            ', PDF: ' . $this->getPDF() . ', PDI: ' . $this->getPDI() . "\n";
    }

    private function persistirPDF() {
        $carbon_date = Carbon::createFromDate(2017, 12, 6);


        switch ($this->projeto->medida_tempo) {
            case 'hora':
                $carbon_date->addHours($this->getPDF());
                break;
            case 'dia':
                $carbon_date->addDays($this->getPDF());
                break;
            case 'semana':
                $carbon_date->addWeeks($this->getPDF());
                break;
            case 'quinzena':
                $carbon_date->addWeeks($this->getPDF() * 2);
                break;
            case 'mês':
                $carbon_date->addMonths($this->getPDF());
                break;
            default:
                $carbon_date->addHours($this->getPDF());
        }

        $sequencias = $this->cenario->where('atividade_id', $this->id)
            ->update([
               'fim_otimista' => $carbon_date,
            ])
        ;
    }
}