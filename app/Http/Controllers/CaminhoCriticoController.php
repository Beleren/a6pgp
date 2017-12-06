<?php
namespace App\Http\Controllers;
use App\Atividade;
use App\Caminho;
use App\No;
use App\Cenario;
use App\Projeto;
use App\Sequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CaminhoCriticoController extends Controller
{
    public function index(Projeto $projeto, Cenario $cenario) {

        $this->authorize('view-projeto', $projeto);

        $this->caminhoCriticoPorMaiorDuracao($projeto, $cenario);

        return redirect(route('resultado.index', [
            'projeto' => $projeto,
            'cenario' => $cenario,
        ]));
    }

    private function calculoIngenuo(Projeto $projeto, Cenario $cenario) {

        $this->authorize('view-projeto', $projeto);
    }

    /*
     *  popular nós; - acredito que ainda esteja com problemas, os nós não programam as predecessores nem sucessores em cada nó.
     */
    private function caminhoCriticoPorMaiorDuracao(Projeto $projeto, Cenario $cenario) {

        $atividades = $projeto->atividades;

        $sequencias_f = Sequencia::selectRaw(
            'atividade_id,
                            ANY_VALUE(inicio_otimista) as inicio_otimista,
                            ANY_VALUE(fim_otimista) as fim_otimista,
                            ANY_VALUE(inicio_pessimista) as inicio_pessimista,
                            ANY_VALUE(fim_pessimista) as fim_pessimista,
                            ANY_VALUE(atividade_predecessora_id) as atividade_predecessora_id,
                            ANY_VALUE(duracao) as duracao')
            ->where('cenario_id', $cenario->id)
            ->groupBy('atividade_id','atividade_predecessora_id')
            ->get();

        //array de nós para programação
        $nos = [];

        //iteração de todas atividades do projeto
        foreach ($atividades as $atividade) {

            //instancia um novo nó para a atividade atual
            $sequencias = $sequencias_f->where('atividade_id', $atividade->id);

            $aux = $sequencias->first();

            if ($aux) {
                $duracao = $sequencias->first()->duracao;
            } else {
                $duracao = null;
            }

            $no = new No($atividade->id, $duracao, $atividade->nome, $projeto->id, $cenario->id);

            array_push($nos, $no);
            /* Verifica se existem sequências. */
        }

        foreach ($nos as $no){

            $sequencias = $sequencias = $sequencias_f->where('atividade_id', $no->getId());
            //iteração entre as sequências

            foreach ($sequencias as $sequencia) {

                //condição: se atividade tiver predecessora, popular o nó de predecessora dentro do nó da atividade atual
                if ($sequencia->atividade_predecessora_id != null) {

                    /*
                     * Verifica a existência de atividade predecessora no banco de dados.
                     */
                    $predecessoras = $sequencias_f->where('atividade_id', $sequencia->atividade_predecessora_id);
                    $predecessora = $predecessoras->first();

                    //percorre os nós para referenciar predecessoras
                    foreach ($nos as $no_predecessor){
                        if ($no_predecessor->getId()==$predecessora->atividade_id){
                            $no->adicionarPredecessora($no_predecessor);
                        }
                    }
                }
            }
        }

        $this->calcularDatasCedo($nos);
        $this->calcularDatasTarde($nos);
        $this->gerarCaminhoCritico($nos);
    }

    private function calcularDatasCedo($nos){

        foreach ($nos as $i => $no) {
            $no->calcPDI();
            $no->calcPDF();
        };
    }

    private function calcularDatasTarde($nos){

        $nos_ordenacao_asc = $this->ordenarNos($nos);
        $maior_pdf = $this->getNoMaiorPDF($nos_ordenacao_asc)->getMaiorPDF();
        $nos_ordenacao_desc = array_reverse($nos_ordenacao_asc->toArray());

        foreach ($nos_ordenacao_desc as $no_ordenacao_desc){
            $no_ordenacao_desc->setMaiorPDF($maior_pdf);
            $no_ordenacao_desc->calcUDF();
            $no_ordenacao_desc->calcUDI();
        }
    }

    //ordena nós de forma crescente
    private function ordenarNos($nos)
    {
        $nos_ordenados = collect($nos)->sortBy(function ($item, $chave) {
            return $item->getPDF();
        });

        return $nos_ordenados;
    }

    //necessário ordenar de forma crescente, retorna nó de maior pdf
    private function getNoMaiorPDF($nos){

        $no = $nos->last();

        No::setMaiorPDF($no->getPDF());

        return $no;
    }


    private function gerarCaminhoCritico($nos){

        $nos_ordenados = $this->ordenarNos($nos);

        $no_maior_pdf = $this->getNoMaiorPDF($nos_ordenados);

        $caminho = new Caminho($nos_ordenados, $no_maior_pdf);

        $caminho->mostrarCaminhoCritico();
    }

}