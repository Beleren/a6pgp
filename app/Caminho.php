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
    private $nos = [];
    private static $caminhoCritico = [];

    public function __construct($atividades) {
        foreach ($atividades as $atividade) {
            array_push($this->nos, $atividade);
        }
    }

    public function adicionarAtividade(No $atividade) {
        array_push($this->nos, $atividade);
    }

    public function __toString() {
        $resultado = '';

        foreach ($this->nos as $atividade) {
            $resultado .= $atividade->getNome() . ', PDF: ' . $atividade->getPDF() . '<br>';
        }

        return $resultado;
    }

    public function mostrarCaminhoCritico() {
        dd($this->nos);

        $this->nos = collect($this->nos)->sortBy(function($item, $chave) {
            return dd($item);
        });

        $atividade = $this->nos->last();
        No::setMaiorPDF($atividade->getPDF());

        array_push(self::$caminhoCritico, $atividade);
        $maior_pdf = 0;
        $temp = null;

        while ($atividade != null && $atividade->getPredecessoras() != null) {

            foreach ($atividade->getPredecessoras() as $atividade) {
                if ($atividade->getPDF() >= $maior_pdf) {
                    $maior_pdf = $atividade->getPDF();
                    $temp = $atividade;
                }
            }

            array_push(self::$caminhoCritico, $temp);

            $atividade = $temp;

            if (!($atividade->getPDF() > 0)) {
                $atividade = null;
            }

            foreach (self::$caminhoCritico as $atividade) {
                echo $atividade;
            }
        }
    }

    public function getCaminhoCritico() {
        return self::$caminhoCritico;
    }
}