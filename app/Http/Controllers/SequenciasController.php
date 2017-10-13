<?php

namespace App\Http\Controllers;

use App\Cenario;
use App\Atividade;
use App\Projeto;
use App\Sequencia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class SequenciasController extends Controller
{
    public function index(Projeto $projeto, Cenario $cenario = null)
    {
        $this->authorize('view-projeto', $projeto);

        /* Definir cenário padrão. */
        if (! $cenario->id)
            $cenario = $projeto->cenarios->first();

        $sequencias = $projeto->sequencias->where('cenario_id', $cenario->id);

        return view('sequencias.index', [
            'projeto' => $projeto,
            'sequencias' => $sequencias,
            'cenario' => $cenario,
            'cenarios' => $projeto->cenarios,
            'atividades' => $projeto->atividades,
            'recursos' => $projeto->recursos,
        ]);
    }

    /**
     * @param Request $request
     * @param Projeto $projeto
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Projeto $projeto)
    {
        $this->authorize('view-projeto', $projeto);

        $dados = $request->input('sequencias.*');

        foreach ($projeto->atividades as $index => $atividade) {
            $has_post_recursos = false;
            $has_post_predecessoras = false;
            $has_post_detalhes = false;

            $sequencias = Sequencia::where('atividade_id', $atividade->id)
                ->where('cenario_id', $request->input('cenario'))->get();

            /* Verifica os dados enviados */
            if ($dados[$index]['predecessoras']) {
                $has_post_predecessoras = true;
                $predecessoras = explode(';', $dados[$index]['predecessoras']);
            }

            if ($dados[$index]['recursos']) {
                $has_post_recursos = true;
                $recursos = explode(';', $dados[$index]['recursos']);
            }

            if ($dados[$index]['detalhes']) {
                $has_post_detalhes = true;
                $detalhes = $dados[$index]['detalhes'];
            }

            /*
             * Se não houver recursos e atividades enviadas para processamento,
             * as sequências cadastradas no banco de dados devem ser excluídos.
             */
            if (! $has_post_predecessoras && ! $has_post_recursos) {
                if ($sequencias) {
                    Sequencia::whereIn('id', $sequencias->pluck('id'))
                        ->delete();
                }
            }


            /*
             * Verificar se houveram posts com atividades e recursos.
             */
            else if ($has_post_predecessoras && $has_post_recursos) {
                foreach ($recursos as $index => $recurso) {

                    collect($predecessoras)->each(function ($predecessora, $chave)
                    use ($request, $recurso, $atividade) {

                        /*
                         * Criação de sequências com seus respectivos recursos.
                         */
                        $sequencia = Sequencia::firstOrCreate([
                            'cenario_id' => $request->input('cenario'),
                            'atividade_id' => $atividade->id,
                            'atividade_predecessora_id' => $predecessora,
                            'recurso_id' => $recurso,
                        ]);
                    });

                    $para_excluir = $sequencias->filter(function ($item, $chave)
                        use ($recursos, $predecessoras) {
                        return ! $item->recurso_id ||
                            ! $item->atividade_predecessora_id ||
                            ! in_array($item->atividade_predecessora_id, $predecessoras) ||
                            ! in_array($item->recurso_id, $recursos)
                            ;
                    });

                    if ($para_excluir) {
                        Sequencia::destroy($para_excluir->pluck('id')->toArray());
                    }

                    // Estou aqui.

                    $this->processarDetalhes($detalhes);
                }
            }


            else if ($has_post_predecessoras && ! $has_post_recursos) {
                foreach ($predecessoras as $predecessora) {
                    $sequencia = Sequencia::firstOrCreate([
                        'cenario_id' => $request->input('cenario'),
                        'atividade_id' => $atividade->id,
                        'atividade_predecessora_id' => $predecessora,
                    ]);

                    if ($sequencia->recurso_id) {
                        $sequencias->recurso_id = null;
                    }
                }

                $para_excluir = $sequencias->filter(function ($item, $chave)
                    use ($predecessoras) {
                    return $item->recurso_id ||
                        ! in_array($item->atividade_predecessora_id, $predecessoras);
                });

                if ($para_excluir) {
                    Sequencia::destroy($para_excluir->pluck('id')->toArray());
                }
            }


            else if (! $has_post_predecessoras && $has_post_recursos) {
                foreach ($recursos as $recurso) {
                    $sequencia = Sequencia::firstOrCreate([
                        'cenario_id' => $request->input('cenario'),
                        'atividade_id' => $atividade->id,
                        'recurso_id' => $recurso,
                    ]);

                    if ($sequencia->atividade_predecessora_id) {
                        $sequencia->atividade_predecessora_id = null;
                    }
                }

                $para_excluir = $sequencias->filter(function ($item, $chave)
                    use ($recursos) {
                    return $item->atividade_predecessora_id ||
                        ! in_array($item->recurso_id, $recursos);
                });

                if ($para_excluir) {
                    Sequencia::destroy($para_excluir->pluck('id')->toArray());
                }
            }

            else {
                return 'Erro!';
            }
        }

        return redirect(route('sequencias.index', [
            'projeto' => $projeto,
            'cenario' => $request->input('cenario'),
        ]));
    }

    public function salvarDetalhes(Request $request, Projeto $projeto) {
        dd($request);
    }

    public function salvarDetalhesRecursos(Request $request, Projeto $projeto) {
        dd($request->input('sequencias.*.detalhes'));
    }

    private function processarDetalhesRecursos($valor) {
        $has_erros = true;

        $regras = [
            'qtd' => 'integer|min:0',
            'dataDispRecurso' => 'date|after_or_equal:today',
            'tempoAlocado' => 'timezone|min:0',
        ];

        $mensagens = [
            'qtd.numeric' => 'Quantidade deve ser um número inteiro.',
            'qtd.min' => 'Quantidade deve ser maior que zero.',
            'dataDispRecurso.date' => 'Data de Disponibilização do Recurso está em formato inválido.',
            'data.after' => 'Data de Disponibilização do Recurso deve posterior ou igual a data de hoje.',
            'tempoAlocado.timezone' => 'Tempo Alocado deve ter formato de horário.',
            'tempoAlocado' => 'Tempo Alocado não pode ser negatívo.',
        ];

        $validator = Validator::make($valor, $regras, $mensagens);
        
        if (! $validator->fails()) {
            $has_erros = false;
        }

        return $has_erros;
    }

    private function processarDetalhesAtividades($valor) {
        $has_erros = true;

        $regras = [
            'duracao' => 'integer|min:0',
            'requerRecursos' => [
                Rule::in(['true', 'false', 'on', 'off', '1', '0', 1, 0, true, false ]),
            ]
        ];

        $mensagens = [
            'duracao.integer' => 'Duração deve ser um número inteiro.',
            'duracao.min' => 'Duração deve ser maior quer zero.',
            'requerRecursos.in' => 'Requer Recurso deve ser um valor verdadeiro ou falso.',
            'inicioOtimista.date' => 'Início Otimista deve ter um formato de data.',
            'inicioPessimista.after_or_equal' => 'Início Pessimista deve ser posterior ou igual a data de hoje.',
            'fimOtimista.date' => 'Fim Otimista deve ter um formato de data.',
            'fimPessimista.after_or_equal' => 'Fim Pessimista deve ser posterior ou igual a data de hoje.',
        ];

        $validator = Validator::make($valor, $regras, $mensagens);

        if (! $validator->fails()) {
            $has_erros = false;
        }

        return $has_erros;
    }

    private function processarDetalhes($valor) {
        $vetor = json_decode($valor, true);

        if ($vetor) {
            $this->processarDetalhesRecursos($vetor['recursos']);
            $this->processarDetalhesAtividades($vetor['detalhes']);
        }

        dd('Fim!');
        /* TODO: Informar qual é a atividade onde houve o erro. */
    }
}