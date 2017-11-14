<?php

namespace App\Http\Controllers;

use App\Cenario;
use App\Atividade;
use App\Projeto;
use App\Sequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;

class ResultadoController extends Controller
{
    public function index(Projeto $projeto, Cenario $cenario = null)
    {
        $this->authorize('view-projeto', $projeto);
        $sequencias = $projeto->sequencias->where('cenario_id', $cenario->id);

        //agrupamento de sequencias por atividade para construção de elementos únicos
        $elementos = Sequencia::selectRaw(
            'atividade_id,
            ANY_VALUE(inicio_otimista) as inicio_otimista,
            ANY_VALUE(fim_otimista) as fim_otimista,
            ANY_VALUE(inicio_pessimista) as inicio_pessimista,
            ANY_VALUE(fim_pessimista) as fim_pessimista,
            ANY_VALUE(atividade_predecessora_id) as atividade_predecessora_id,
            ANY_VALUE(duracao) as duracao')
            ->where('cenario_id', $cenario->id)
            ->groupBy('atividade_id')
            ->get();

        //variável com código javascript para construção do diagrama
        $diagrama = $this->contruirDiagrama($elementos, $sequencias);
        return view('resultado.index', [
            'projeto' => $projeto,
            'sequencias' => $sequencias,
            'elementos' => $elementos,
            'cenario' => $cenario,
            'cenarios' => $projeto->cenarios,
            'diagrama' => $diagrama,
            'atividades' => $projeto->atividades,
            'recursos' => $projeto->recursos,
        ]);
    }
    //construção do diagrama em javascript
    public function contruirDiagrama($elementos, $sequencias){
        //inicializa diagrama
        $diagrama = 'image = Viz("digraph g { node [shape=record];\n" +';
        //construção dos elementos
        foreach ($elementos as $elemento){
            $atividade = Atividade::where([
                'id' => $elemento->atividade_id
            ])->first();
            $diagrama = $diagrama.'"\"'.$atividade->nome.'\"[label = \"{'.$elemento->inicio_otimista.' | '.$elemento->inicio_pessimista.'}|{'.$atividade->nome.'|'.$atividade->duracao.'}| {'.$elemento->fim_otimista.'|'.$elemento->fim_pessimista.'}\"]"+';
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

                //condição para verificar e ligar atividades do caminho crítico
                if (
                    $sequenciaPredecessora->inicio_otimista - $sequenciaPredecessora->inicio_pessimista == 0 &&
                    $sequenciaPredecessora->fim_otimista - $sequenciaPredecessora->fim_pessimista == 0 &&
                    $sequencia->inicio_otimista - $sequencia->inicio_pessimista == 0 &&
                    $sequencia->fim_otimista - $sequencia->fim_pessimista == 0
                ) {
                    $diagrama = $diagrama . '[color=\"red\"]"+';
                }
                else
                    $diagrama = $diagrama.'"+';
            }
        }
        //formato da imagem e encerramento do diagrama
        $diagrama = $diagrama.'"struct3 [label=\" {PDI| UDI}|{Atividade|Duração}|{PDT|UDT}\"]; }", { format: "png-image-element" });';

        return $diagrama;
    }



}