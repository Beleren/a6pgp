<?php

namespace App\Http\Controllers;

use App\Cenario;
use App\Atividade;
use App\Projeto;
use App\Sequencia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;

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
                if ($has_post_detalhes) {
                    $detalhe = $this->processarDetalhes($detalhes);
                }

                if (
                    ! $detalhe &&
                    ! array_key_exists('detalhes', $detalhe)
                ) {
                    if ($sequencias) {
                        Sequencia::whereIn('id', $sequencias->pluck('id'))
                            ->delete();
                    }
                }

                if ($detalhe) {
                    if (array_key_exists('detalhes', $detalhe)) {
                        if (count($detalhe['detalhes'])) {
                            $sequencia = Sequencia::firstOrCreate([
                                'atividade_id' => $atividade->id,
                                'cenario_id' =>  $request->input('cenario'),
                            ]);

                            $resultado = collect($detalhe)
                                ->where('atividadeId', $sequencia->atividade_id)
                                ->first()
                            ;

                            $this->limpezaDeCampos($sequencia);

                            // Início Otimista
                            if ($resultado['inicioOtimista']) {
                                $sequencia->inicio_otimista = $resultado['inicioOtimista'];
                            }

                            // Início Pessimista
                            if ($resultado['inicioPessimista']) {
                                $sequencia->inicio_pessimista = $resultado['inicioPessimista'];
                            }

                            // Fim Otimista
                            if ($resultado['fimOtimista']) {
                                $sequencia->fim_otimista = $resultado['fimOtimista'];
                            }

                            // Fim Pessimista
                            if ($resultado['fimPessimista']) {
                                $sequencia->fim_pessimista = $resultado['fimPessimista'];
                            }

                            // Fim Pessimista
                            if (
                            in_array($resultado['requerRecursos'],
                                ['on', 'true', true, '1', 1]
                            )
                            ) {
                                $sequencia->requer_recursos = true;
                            }
                        }

                        $sequencia->save();
                    }
                }
            }


            /*
             * Verificar se houveram posts com atividades e recursos.
             */
            else if ($has_post_predecessoras && $has_post_recursos) {
                foreach ($recursos as $index => $recurso) {
                    collect($predecessoras)->each(function ($predecessora, $chave)
                    use ($request, $recurso, $atividade, $detalhes, $index) {

                        /*
                         * Criação de sequências com seus respectivos recursos.
                         */
                        $sequencia = Sequencia::firstOrCreate([
                            'cenario_id' => $request->input('cenario'),
                            'atividade_id' => $atividade->id,
                            'atividade_predecessora_id' => $predecessora,
                            'recurso_id' => $recurso,
                        ]);

                        $this->limpezaDeCampos($sequencia);

                        $detalhe = $this->processarDetalhes($detalhes);

                        /*
                         * O trecho abaixo foi refatorado porque havia problemas na leitura de datas.
                         */
                        if ($detalhe) {
                            /* Remover valores do banco de dados. */
                            $sequencia->quantidade_recurso = null;
                            $sequencia->tempo_alocado = null;
                            $sequencia->data_inicio_disp_recurso = null;

                            if (array_key_exists('recursos', $detalhe)) {
                                if (count($detalhe['recursos'])) {
                                    $resultado = collect($detalhe['recursos'])
                                        ->where('recursoId', $sequencia->recurso_id)
                                        ->where('atividadeId', $sequencia->atividade_id)
                                        ->first()
                                    ;

                                    // Quantidade de Recursos
                                    if ($resultado['qtd']) {
                                        $sequencia->quantidade_recurso = $resultado['qtd'];
                                    }

                                    // Tempo Alocado
                                    if ($resultado['tempoAlocado']) {
                                        $sequencia->tempo_alocado = $resultado['tempoAlocado'];
                                    }

                                    // Data de Início de Disponibilização de Recurso
                                    if ($resultado['dataDispRecurso']) {
                                        $sequencia->data_inicio_disp_recurso = $resultado['dataDispRecurso'];
                                    }
                                } else {

                                }
                            }

                            if (array_key_exists('detalhes', $detalhe)) {
                                if (count($detalhe['detalhes'])) {
                                    $resultado = collect($detalhe['detalhes'])
                                        ->where('recursoId', $sequencia->recurso_id)
                                        ->where('atividadeId', $sequencia->atividade_id)
                                        ->first()
                                    ;

                                    // Início Otimista
                                    if ($resultado['inicioOtimista']) {
                                        $sequencia->inicio_otimista = $resultado['inicioOtimista'];
                                    }

                                    // Início Pessimista
                                    if ($resultado['inicioPessimista']) {
                                        $sequencia->inicio_pessimista = $resultado['inicioPessimista'];
                                    }

                                    // Fim Otimista
                                    if ($resultado['fimOtimista']) {
                                        $sequencia->fim_otimista = $resultado['fimOtimista'];
                                    }

                                    // Fim Pessimista
                                    if ($resultado['fimPessimista']) {
                                        $sequencia->fim_pessimista = $resultado['fimPessimista'];
                                    }

                                    // Fim Pessimista
                                    if (
                                        in_array($resultado['requerRecursos'],
                                        ['on', 'true', true, '1', 1]
                                        )
                                    ) {
                                        $sequencia->requer_recursos = true;
                                    }
                                }
                            }
                        }

                        $sequencia->save();
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

                    $sequencia->save();
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

                    $this->limpezaDeCampos($sequencia);

                    $detalhe = $this->processarDetalhes($detalhes);

                    /*
                     * O trecho abaixo foi refatorado porque havia problemas na leitura de datas.
                     */
                    if ($detalhe) {
                        if (array_key_exists('detalhes', $detalhe)) {
                            if (count($detalhe['detalhes'])) {
                                $resultado = collect($detalhe['detalhes'])
                                    ->where('recursoId', $sequencia->recurso_id)
                                    ->where('atividadeId', $sequencia->atividade_id)
                                    ->first();

                                // Limpeza de dados.
                                $sequencia->inicio_otimista = null;
                                $sequencia->inicio_pessimista = null;
                                $sequencia->fim_otimista = null;
                                $sequencia->fim_pessimista = null;
                                $sequencia->requer_recursos = false;

                                // Início Otimista
                                if ($detalhe['detalhes']['inicioOtimista']) {
                                    $sequencia->inicio_otimista = $detalhe['detalhes']['inicioOtimista'];
                                }

                                // Início Pessimista
                                if ($detalhe['detalhes']['inicioPessimista']) {
                                    $sequencia->inicio_pessimista = $detalhe['detalhes']['inicioPessimista'];
                                }

                                // Fim Otimista
                                if ($detalhe['detalhes']['fimOtimista']) {
                                    $sequencia->fim_otimista = $detalhe['detalhes']['fimOtimista'];
                                }

                                // Fim Pessimista
                                if ($detalhe['detalhes']['fimPessimista']) {
                                    $sequencia->fim_pessimista = $detalhe['detalhes']['fimPessimista'];
                                }

                                // Fim Pessimista
                                if (
                                in_array($detalhe['detalhes']['requerRecursos'],
                                    ['on', 'true', true, '1', 1])
                                ) {
                                    $sequencia->requer_recursos = true;
                                }
                            }
                        }
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

                $sequencia->save();
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

                    $this->limpezaDeCampos($sequencia);

                    $detalhe = $this->processarDetalhes($detalhes);

                    /*
                     * O trecho abaixo foi refatorado porque havia problemas na leitura de datas.
                     */
                    if ($detalhe) {
                        if (array_key_exists('recursos', $detalhe)) {
                            if (count($detalhe['recursos'])) {

                                //dd($detalhe['recursos']);

                                $resultado = collect($detalhe['recursos'])
                                    ->where('recursoId', $sequencia->recurso_id)
                                    ->where('atividadeId', $sequencia->atividade_id)
                                    ->first()
                                ;

                                // Quantidade de Recursos
                                if ($resultado['qtd']) {
                                    $sequencia->quantidade_recurso = $resultado['qtd'];
                                } else {
                                    $sequencia->quantidade_recurso = null;
                                }

                                // Tempo Alocado
                                if ($resultado['tempoAlocado']) {
                                    $sequencia->tempo_alocado = $resultado['tempoAlocado'];
                                } else {
                                    $sequencia->tempo_alocado = null;
                                }

                                // Data de Início de Disponibilização de Recurso
                                if ($resultado['dataDispRecurso']) {
                                    $sequencia->data_inicio_disp_recurso = $resultado['dataDispRecurso'];
                                } else {
                                    $sequencia->data_inicio_disp_recurso = null;
                                }
                            }
                        }

                        if (array_key_exists('detalhes', $detalhe)) {
                            if (count($detalhe['detalhes'])) {
                                $resultado = collect($detalhe['detalhes'])
                                    ->where('recursoId', $sequencia->recurso_id)
                                    ->where('atividadeId', $sequencia->atividade_id)
                                    ->first()
                                ;

                                // Início Otimista
                                if ($detalhe['detalhes']['inicioOtimista']) {
                                    $sequencia->inicio_otimista = $detalhe['detalhes']['inicioOtimista'];
                                } else {
                                    $sequencia->inicio_otimista = null;
                                }

                                // Início Pessimista
                                if ($detalhe['detalhes']['inicioPessimista']) {
                                    $sequencia->inicio_pessimista = $detalhe['detalhes']['inicioPessimista'];
                                } else {
                                    $sequencia->inicio_pessimista = null;
                                }

                                // Fim Otimista
                                if ($detalhe['detalhes']['fimOtimista']) {
                                    $sequencia->fim_otimista = $detalhe['detalhes']['fimOtimista'];
                                } else {
                                    $sequencia->fim_otimista = null;
                                }

                                // Fim Pessimista
                                if ($detalhe['detalhes']['fimPessimista']) {
                                    $sequencia->fim_pessimista = $detalhe['detalhes']['fimPessimista'];
                                } else {
                                    $sequencia->fim_pessimista = null;
                                }

                                // Fim Pessimista
                                if (
                                in_array($detalhe['detalhes']['requerRecursos'],
                                    ['on', 'true', true, '1', 1]
                                )
                                ) {
                                    $sequencia->requer_recursos = true;
                                } else {
                                    $sequencia->requer_recursos = false;
                                }
                            }
                        }
                    }

                    $sequencia->save();
                }

                $para_excluir = $sequencias->filter(function ($item, $chave)
                    use ($recursos) {
                    return $item->atividade_predecessora_id ||
                        ! in_array($item->recurso_id, $recursos);
                });

                if ($para_excluir) {
                    Sequencia::destroy($para_excluir->pluck('id')->toArray());
                }

                $sequencia->save();
            }

            else {
                // TODO: Implementar tratativa de caso excepcional.
            }
        }

        return redirect(route('sequencias.index', [
            'projeto' => $projeto,
            'cenario' => $request->input('cenario'),
        ]));
    }

    private function processarDetalhesRecursos($valor) {
        $has_exito = false;

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
            $has_exito = true;
        }

        return $has_exito;
    }

    private function processarDetalhesAtividades($valor) {
        $has_exito = false;

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
            $has_exito = true;
        }

        return $has_exito;
    }

    private function processarDetalhes($valor) {
        $has_exito = false;
        $vetor = json_decode($valor, true);

        if ($vetor) {
            if (
                $this->processarDetalhesRecursos($vetor['recursos']) &&
                $this->processarDetalhesAtividades($vetor['detalhes'])
            ) {
                $has_exito = true;
            }
        } else {
            $has_exito = true;
        }

        if ($has_exito) {
            return $vetor;
        }

        return false;
        /* TODO: Informar qual é a atividade onde houve o erro. */
    }

    public function obterDetalhesSequencia(Projeto $projeto, Atividade $atividade, Cenario $cenario) {
        $this->authorize('view-projeto', $projeto);

        $sequencia = Sequencia::where([
            'cenario_id' => $cenario->id,
            'atividade_id' => $atividade->id,
        ])->first();

        /* Detalhes */
        $json['detalhes']['inicioOtimista'] = $sequencia->inicio_otimista;
        $json['detalhes']['inicioPessimista'] = $sequencia->inicio_pessimista;
        $json['detalhes']['fimOtimista'] = $sequencia->fim_otimista;
        $json['detalhes']['fimPessimista'] = $sequencia->fim_pessimista;
        $json['detalhes']['requerRecursos'] = $sequencia->requer_recursos;

        /* Ajustes na formatação do JSON */
        $json['detalhes']['inicioOtimista'] = $this->ajustarFormatoDeDataJSON($json['detalhes'], 'inicioOtimista');
        $json['detalhes']['inicioPessimista'] = $this->ajustarFormatoDeDataJSON($json['detalhes'], 'inicioPessimista');
        $json['detalhes']['fimOtimista'] = $this->ajustarFormatoDeDataJSON($json['detalhes'], 'fimOtimista');
        $json['detalhes']['fimPessimista'] = $this->ajustarFormatoDeDataJSON($json['detalhes'], 'fimPessimista');

        /* Obtenção de detalhes de recursos */
        $recursos = $this->obterDetalhesRecursos($atividade, $cenario);

        $json['recursos'] = [];

        foreach ($recursos as $recurso) {
            $valores = [
                'atividadeId' => $recurso['atividade_id'],
                'recursoId' => $recurso['recurso_id'],
                'qtd' => $recurso['quantidade_recurso'],
                'tempoalocado' => $recurso['tempo_alocado'],
                'dataDispRecurso' => $recurso['data_inicio_disp_recurso'],
            ];

            array_push($json['recursos'], $valores);
        }

        return $json;
    }

    private function obterDetalhesRecursos(Atividade $atividade, Cenario $cenario) {
        $sequencias = Sequencia::where([
           'cenario_id' => $cenario->id,
            'atividade_id' => $atividade->id,
        ])->get();

        return $sequencias;
    }

    private function limpezaDeCampos(Sequencia $sequencia) {
        /* Limpeza */
        $sequencia->inicio_otimista = null;
        $sequencia->fim_otimista = null;
        $sequencia->inicio_pessimista = null;
        $sequencia->fim_pessimista = null;
        $sequencia->quantidade_recurso = null;
        $sequencia->requer_recursos = false;
        $sequencia->tempo_alocado = null;
        $sequencia->data_inicio_disp_recurso = null;
        $sequencia->duracao = null;
    }

    private function ajustarFormatoDeDataJSON(array $vetor, $chave) {
        if (array_key_exists($chave, $vetor)) {
            if ($vetor[$chave]) {
                return date($vetor[$chave]);
            }
        } else {
            return $vetor;
        }
    }
}