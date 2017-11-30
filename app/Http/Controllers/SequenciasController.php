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

                /*
                 * Atividade não possui predecessora, mas possui detalhes de duração.
                 * Neste caso é necessário criar um registro de sequência para salvar os detalhes.
                 */
                if ($detalhe) {
                    $sequencia = Sequencia::firstOrCreate([
                        'atividade_id' => $atividade->id,
                        'cenario_id' => $request->input('cenario'),
                    ]);

                    $this->salvarDetalhes($sequencia, $detalhe);
                    $sequencia->save();
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
                            $this->salvarDetalhes($sequencia, $detalhe);
                            $sequencia->save();
                        }
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
                        $sequencia->recurso_id = null;
                    }

                    $sequencia->save();

                    $this->limpezaDeCampos($sequencia);

                    $detalhe = $this->processarDetalhes($detalhes);

                    /*
                     * O trecho abaixo foi refatorado porque havia problemas na leitura de datas.
                     */

                    if ($detalhe) {
                        $this->salvarDetalhes($sequencia, $detalhe);
                        $sequencia->save();
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
                        $this->salvarDetalhes($sequencia, $detalhe);
                        $sequencia->save();
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
            'tempoAlocado' => 'timezone|nullable|min:0',
        ];

        $mensagens = [
            'qtd.numeric' => trans('paginas.sequencias.validacoes.detalhes.recursos.qtd.numeric'),
            'qtd.min' => trans('paginas.sequencias.validacoes.detalhes.recursos.qtd.min'),
            'dataDispRecurso.date' => trans('paginas.sequencias.validacoes.detalhes.recursos.dataDispRecurso.date'),
            'data.after' => trans('paginas.sequencias.validacoes.detalhes.recursos.data.after'),
            'tempoAlocado.timezone' => trans('paginas.sequencias.validacoes.detalhes.recursos.tempoAlocado.timezone'),
            'tempoAlocado.min' => trans('paginas.sequencias.validacoes.detalhes.recursos.tempoAlocado.min'),
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
            'duracao' => 'numeric|min:0',
            'requerRecursos' => [
                Rule::in(['true', 'false', 'on', 'off', '1', '0', 1, 0, true, false ]),
            ]
        ];

        $mensagens = [
            'duracao.integer' => trans('paginas.sequencias.validacoes.detalhes.atividades.duracao.integer'),
            'duracao.min' => trans('paginas.sequencias.validacoes.detalhes.atividades.duracao.min'),
            'requerRecursos.in' => trans('paginas.sequencias.validacoes.detalhes.atividades.requerRecursos.in'),
            'inicioOtimista.date' => trans('paginas.sequencias.validacoes.detalhes.atividades.inicioOtimista.date'),
            'inicioPessimista.after_or_equal' => trans('paginas.sequencias.validacoes.detalhes.atividades.inicioPessimista.after_or_equal'),
            'fimOtimista.date' => trans('paginas.sequencias.validacoes.detalhes.atividades.fimOtimista.date'),
            'fimPessimista.after_or_equal' => trans('paginas.sequencias.validacoes.detalhes.atividades.fimPessimista.after_or_equal'),
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

        if ($sequencia) {
            /* Detalhes */
            $json['detalhes']['duracao'] = $sequencia->duracao;
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
                if ($recurso['recurso_id']) {
                    $valores = [
                        'atividadeId' => $recurso['atividade_id'],
                        'recursoId' => $recurso['recurso_id'],
                        'qtd' => $recurso['quantidade_recurso'],
                        'tempoalocado' => $recurso['tempo_alocado'],
                        'dataDispRecurso' => $recurso['data_inicio_disp_recurso'],
                    ];

                    array_push($json['recursos'], $valores);
                }
            }
        } else {
            $json = '{detalhes: {}, recursos: []}';
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
        $this->limpezaDeCamposDeDetalhes($sequencia);
        $this->limpezaDeCampoDeRecursos($sequencia);
    }

    private function limpezaDeCamposDeDetalhes(Sequencia $sequencia) {
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

    private function limpezaDeCampoDeRecursos(Sequencia $sequencia) {
        $sequencia->quantidade_recurso = null;
        $sequencia->tempo_alocado = null;
        $sequencia->data_inicio_disp_recurso = null;
    }

    private function ajustarFormatoDeDataJSON($vetor, $chave) {
        if (is_array($vetor)) {
            if (array_key_exists($chave, $vetor)) {
                if ($vetor[$chave]) {
                    return date($vetor[$chave]);
                }
            } else {
                return $vetor;
            }
        }
        return null;
    }

    private function verificarExistenciaChave($vetor, $chave) {
        if (is_array($vetor)) {
            if (array_key_exists($chave, $vetor)) {
                if ($vetor[$chave]) {
                    return $vetor[$chave];
                }
            }
        }
        return null;
    }

    private function salvarDetalhes(Sequencia $sequencia, $detalhe){
        if ($this->verificarExistenciaChave($detalhe, 'recursos')) {
            if ($this->verificarExistenciaChave($detalhe['recursos'][0], 'qtd')) {
                $sequencia->quantidade_recurso = $detalhe['recursos'][0]['qtd'];
            }

            if ($this->verificarExistenciaChave($detalhe['recursos'][0], 'dataDispRecurso')) {
                $sequencia->data_inicio_disp_recurso = $detalhe['recursos'][0]['dataDispRecurso'];
            }

            if ($this->verificarExistenciaChave($detalhe['recursos'][0], 'tempoAlocado')) {
                $sequencia->tempo_alocado = $detalhe['recursos'][0]['tempoAlocado'];
            }
        }

        if ($this->verificarExistenciaChave($detalhe, 'detalhes')) {
            if ($this->verificarExistenciaChave($detalhe['detalhes'], 'duracao')) {
                $sequencia->duracao = $detalhe['detalhes']['duracao'];
            }

            if ($this->verificarExistenciaChave($detalhe['detalhes'], 'requerRecursos')) {
                $sequencia->requer_recursos = $detalhe['detalhes']['requerRecursos'];
            }
        }
    }
}