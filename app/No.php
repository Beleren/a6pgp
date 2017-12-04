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

        $this->obterDependencias();
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

    private function obterDependencias() {
        /* Verifica se existem sequências. */
        $sequencias = Sequencia::selectRaw(
            'atividade_id,
                            ANY_VALUE(inicio_otimista) as inicio_otimista,
                            ANY_VALUE(fim_otimista) as fim_otimista,
                            ANY_VALUE(inicio_pessimista) as inicio_pessimista,
                            ANY_VALUE(fim_pessimista) as fim_pessimista,
                            ANY_VALUE(atividade_predecessora_id) as atividade_predecessora_id,
                            ANY_VALUE(duracao) as duracao')
            ->where('cenario_id', $this->cenario->id)
            ->where('atividade_id', $this->id)
            ->groupBy('atividade_id','atividade_predecessora_id')
            ->get();

        /*
         * Verifica se existem sequências no banco de dados.
         */

        if ($sequencias) {
            //iteração entre as sequências
            foreach ($sequencias as $sequencia) {

                //condição: se atividade tiver predecessora, popular o nó de predecessora dentro do nó da atividade atual
                if ($sequencia->atividade_predecessora_id != null) {

                    /*
                     * Verifica a existência de atividade predecessora no banco de dados.
                     *
                     * Observação: Não é possível usar array como parâmetro no método where. Neste caso,
                     * é necessário aninhar wheres.
                     */
                    $predecessora = Sequencia::where('atividade_id', $sequencia->atividade_predecessora_id)
                        ->where('cenario_id', $this->cenario->id)
                        ->first();

                    $duracao_pred = $predecessora ? $predecessora->duracao : null;

                    //instancia atividade predecessora e adiciona no nó
                    $no_pred = new No($predecessora->atividade_id, $duracao_pred, $predecessora->atividade->nome, $this->projeto->id, $this->cenario->id);
                    $this->adicionarPredecessora($no_pred);
                }
            }
        }
    }
}