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
    private $no_maior_pdf = null;
    private static $caminhoCritico = [];

    public function __construct($atividades, $no_maior_pdf) {
        foreach ($atividades as $atividade) {
            array_push($this->nos, $atividade);
        }

        $this->no_maior_pdf = $no_maior_pdf;
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


        $no = $this->no_maior_pdf;
        array_push(self::$caminhoCritico, $no);

        $temp = null;

        while ($no != null && $no->getPredecessoras()) {

            $maior_pdf = 0;

            foreach ($no->getPredecessoras() as $i => $no) {
                if ($no->getPDF() >= $maior_pdf) {
                    $maior_pdf = $no->getPDF();
                    $temp = $no;
                }
            }

            array_push(self::$caminhoCritico, $temp);

            $no = $temp;

            if (! $no->getPDF()) {
                $no = null;
            }
        }
    }

    public function getCaminhoCritico() {
        return self::$caminhoCritico;
    }


}