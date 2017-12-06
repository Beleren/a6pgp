<?php

namespace App\Http\Controllers;

use App\Cenario;
use App\Atividade;
use App\Projeto;
use App\Sequencia;
use Validator;

class ResultadoController extends Controller
{
    public function index(Projeto $projeto, Cenario $cenario = null)
    {

        $this->authorize('view-projeto', $projeto);

        //agrupamento de sequencias por atividade para construção de elementos únicos

//        $sequencias = Sequencia::selectRaw(
//            '`atividade_id`,
//            `inicio_otimista` as inicio_otimista,
//            `fim_otimista` as fim_otimista,
//            `inicio_pessimista` as inicio_pessimista,
//            `fim_pessimista` as fim_pessimista,
//            `atividade_predecessora_id` as atividade_predecessora_id,
//            `is_caminho_critico` as is_caminho_critico,
//            `duracao` as duracao')
//            ->where('cenario_id', $cenario->id)
//            ->groupBy('atividade_id','atividade_predecessora_id')
//            ->get();

        $sequencias = Sequencia::where('cenario_id', $cenario->id)
            ->groupBy('atividade_id', 'atividade_predecessora_id')
            ->get();

        //variável com código javascript para construção do diagrama
        $diagrama = $this->contruirDiagrama($sequencias);

        return view('resultado.index', [
            'projeto' => $projeto,
            'sequencias' => $sequencias,
            'cenario' => $cenario,
            'cenarios' => $projeto->cenarios,
            'diagrama' => $diagrama,
            'atividades' => $projeto->atividades,
            'recursos' => $projeto->recursos,
        ]);
    }

    //construção do diagrama em javascript
    public function contruirDiagrama($sequencias){

        //inicializa diagrama
        $diagrama = 'image = Viz("digraph g { node [shape=record];\n" +';

        //construção dos elementos
        foreach ($sequencias as $elemento){

            $atividade = Atividade::where([
                'id' => $elemento->atividade_id
            ])->first();

            $diagrama = $diagrama.'"\"'.$atividade->nome.'\"[label = \"{'.$elemento->inicio_otimista.' | '
                .$elemento->inicio_pessimista.'}|{'.$atividade->nome.'|'.$elemento->duracao.'}| {'
                .$elemento->fim_otimista.'|'.$elemento->fim_pessimista.'}\"]"+';
        }

        //construção do sequenciamento, não é necessário ordernar
        foreach ($sequencias as $sequencia){

            //variável para atividade principal da sequência
            $atividade = Atividade::where([
                'id' => $sequencia->atividade_id
            ])->first();

            //variável predecessora da sequência
            $atividadePredecessora=Atividade::where([
                'id' => $sequencia->atividade_predecessora_id
            ])->first();

            //Condição para construir sequência só realiza ligação entre sequências se possuir predecessora
            if (!empty($atividadePredecessora)) {

                $diagrama = $diagrama . '"\"' . $atividadePredecessora->nome . '\"->\"' . $atividade->nome . '\"';

                //variável para verificar se tanto predecessora quanto sequência atual fazem parte do caminho crítico
                $sequenciaPredecessora = Sequencia::where([
                    'atividade_id' => $atividadePredecessora->id
                ])->first();


                if ($sequencia->is_caminho_critico && $sequenciaPredecessora->is_caminho_critico) {
                    $diagrama = $diagrama . '[color=\"red\"]"+';
                } else
                    $diagrama = $diagrama . '"+';

            }
        }

        //formato da imagem e encerramento do diagrama
        $diagrama = $diagrama.'"struct3 [label=\" {' .
            trans('paginas.resultado.pdi') . '|' . trans('paginas.resultado.udi') . '}|{' .
            trans('paginas.resultado.atividade') . '|'.
            trans('paginas.resultado.duracao') .
            '}|{' . trans('paginas.resultado.pdt') . '|' . trans('paginas.resultado.udt') .
            '}\"]; }", { format: "png-image-element" });';

        return $diagrama;
    }
}