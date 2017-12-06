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

    public function getCenario() {
        return $this->cenario;
    }

    public function getProjeto() {
        return $this->projeto;
    }

    public function getAtividade() {
        return $this->atividade;
    }

    /* Setters */
    public function setPDI($valor) {
        $this->pdi = $valor;
        $this->persistirPDI();
    }
    public function setPDF($valor) {
        $this->pdf = $valor;
        $this->persistirPDF();
    }
    public function setUDI($valor) {
        $this->udi = $valor;
        $this->persistirUDI();
    }
    public function setUDF($valor) {
        $this->udf = $valor;
        $this->persistirUDF();
    }
    public static function setMaiorPDF($valor) {
        self::$maiorPDF = $valor;
    }
    /* Processos */
    /*precisaremos usar o conceito de varredura de árvore para programação de atividades
    acredito que o problema dos cálculos em relação ao código em java é a ordenação do array*/
    public function calcPDI() {
        $resultado = 0;
        foreach ($this->predecessoras as $predecessora) {
            if (! $predecessora->getPDF()) {
                $predecessora->calcPDF();
            }
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
        $resultado = null;
        $menor_udi = null;
        /* Verifica se a atividade possui sucessoras */
        if ($this->sucessoras) {
            foreach ($this->sucessoras as $sucessora) {
                /* Predecessora possui UDI calculado */
                if (! $sucessora->getUDI()) {
                    $sucessora->calcUDI();
                    $this->calcUDI();
                    $menor_udi = $sucessora->getUDI();
                    $resultado = $menor_udi - $this->duracao;
                }
                else{
                    //condição para verificar menor UDI para comparar
                    if (! $menor_udi){
                        $menor_udi = $sucessora->getUDI();
                        $resultado = $sucessora->getUDI() - $this->duracao;
                    }
                    elseif ($sucessora->getUDI() < $menor_udi){
                        $menor_udi = $sucessora->getUDI();
                        $resultado = $sucessora->getUDI() - $this->duracao;
                    }
                }
            }
        }
        //condição para atividaes finais
        else {
            $resultado = (self::getMaiorPDF() - $this->duracao);
        }
        $this->setUDI($resultado);
    }
    public function calcUDF() {
        $resultado = $this->pdf;
        $menor_udi = null;
        foreach ($this->sucessoras as $sucessora) {
            if (! $sucessora->getUDI()) {
                $sucessora->calcUDI();
            }
            else{
                if (! $menor_udi) {
                    $menor_udi = $sucessora->getUDI();
                    $resultado = $sucessora->getUDI();
                }
                elseif ($sucessora->getUDI() < $menor_udi) {
                    $menor_udi = $sucessora->getUDI();
                    $resultado = $sucessora->getUDI();
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
            ', PDI: ' . $this->getPDI() . ', PDF: ' . $this->getPDF() .
        ', UDI: ' . $this->getUDI() . ', UDF: ' . $this->getUDF() . "\n";
    }

    /**
     * @param $carbon_date
     */
    private function obterMedidaTempo($carbon_date)
    {
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
    }

    private function persistirPDF() {
        $carbon_date = $this->obterDataInicioProjeto();

        $this->obterMedidaTempo($carbon_date);

        $sequencias = $this->atividade
            ->sequencias->where('cenario_id', $this->cenario->id);

        /*
         * Refatorar. Este trecho faz a varredura de cada registro encontrado.
         * No entanto, não é a forma mais eficiente, mesmo levando em conta que as
         * sequências estão restritas a um mesmo cenário e atividade.
         */
        $sequencias->each(function($item) use ($carbon_date) {
           $item->update(['fim_otimista' => $carbon_date]);
        });
    }

    private function persistirPDI() {
        $carbon_date = $this->obterDataInicioProjeto();

        $this->obterMedidaTempo($carbon_date);

        $sequencias = $this->atividade
            ->sequencias->where('cenario_id', $this->cenario->id);

        $sequencias->each(function($item) use ($carbon_date) {
            $item->update(['inicio_otimista' => $carbon_date]);
        });
    }

    private function persistirUDI() {
        $carbon_date = $this->obterDataInicioProjeto();

        $this->obterMedidaTempo($carbon_date);

        $sequencias = $this->atividade
            ->sequencias->where('cenario_id', $this->cenario->id);

        $sequencias->each(function($item) use ($carbon_date) {
            $item->update(['inicio_pessimista' => $carbon_date]);
        });
    }

    private function persistirUDF() {
        $carbon_date = $this->obterDataInicioProjeto();

        $this->obterMedidaTempo($carbon_date);

        $sequencias = $this->atividade
            ->sequencias->where('cenario_id', $this->cenario->id);

        $sequencias->each(function($item) use ($carbon_date) {
            $item->update(['fim_pessimista' => $carbon_date]);
        });
    }

    /**
     * @return mixed|static
     */
    private function obterDataInicioProjeto()
    {
        if ($this->cenario->data_inicio_projeto) {
            $carbon_date = $this->cenario->data_inicio_projeto;
        } else {
            $carbon_date = Carbon::now();
        }
        return $carbon_date;
    }
}