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

    public static function adicionarAtividadeAoCaminhoCritico(No $atividade) {
        array_push(self::$caminhoCritico, $atividade);
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

            self::adicionarAtividadeAoCaminhoCritico($temp);

            $no = $temp;

            if (! $no->getPDF()) {
                $no = null;
            }
        }

        $this->persistirCaminhoCritico();
    }

    public function getCaminhoCritico() {
        return self::$caminhoCritico;
    }


    private function persistirCaminhoCritico() {
        $projeto = $this->no_maior_pdf->getProjeto();
        $cenario = $this->no_maior_pdf->getCenario();

        /*
         * Redefine o caminho crítico para evitar que o valor esteja errado quando for
         * gerar o gráfico.
         */
        $sequencias = $projeto->sequencias->where('cenario_id', $cenario->id);

        /* Refatorar. */
        $sequencias->each(function ($item) {
           $item->is_caminho_critico = false;
           $item->save();
        });

        /*
         * Atualizar a flag do caminho crítico das atividades que compõem o caminho.
         */
        foreach (self::getCaminhoCritico() as $no) {
            $sequencias = $projeto->sequencias
                ->where('cenario_id', $cenario->id)
                ->where('atividade_id', $no->getId());

            $sequencias->each(function ($item) {
               $item->is_caminho_critico = true;
               $item->save();
            });
        }
    }
}