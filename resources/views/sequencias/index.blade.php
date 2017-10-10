@extends('layouts.app')

@section('conteudo')
    <div class="container-fluid">
        <div class="col-sm-9 col-md-9">
            <form id="form-dependencias" action="{{ route('sequencias.store', ['projeto' => $projeto->id]) }}"
                class="horizontal-form" method="post">

                {{ csrf_field() }}

                <div class="form-group">
                    <a href="{{ route('atividades.index', ['projeto' => $projeto]) }}"
                        class="btn btn-default">
                        Voltar
                    </a>
                    <button id="btnSalvar" name="btnSalvar" type="button" class="btn btn-primary">
                        Salvar
                    </button>
                </div>
                <div class="form-group">
                    <label for="cenario" class="control-label">Cenário:</label>
                    <div>
                        <select id="cenario" name="cenario" class="form-control">
                            @foreach($cenarios as $cenario)
                                <option value="{{ $cenario->id }}">{{ $cenario->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover tablesorter col-sm-8 col-md-8">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Atividades Predecessoras</th>
                        <th>Recursos</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($atividades as $atividade)
                            <tr>
                                <td class="col-sm-3 col-md-3">{{ $atividade->nome }}
                                    <input type="hidden" id="sequencia-{{ $atividade->id }}-dependecias"
                                        name="sequencias[{{ $atividade->id }}][predecessoras]" value="">
                                    <input type="hidden" id="sequenciador-{{ $atividade->id }}-recursos"
                                        name="sequencias[{{ $atividade->id }}][recursos]" value="">
                                    <input type="hidden" id="detalhes-{{ $atividade->id }}"
                                        name="sequencias[{{ $atividade->id }}][detalhes]" value="">
                                </td>
                                <td class="col-sm-5 col-md-5">
                                    <ul class="dependencias list-group">
                                        @forelse($sequencias->where('atividade_id', $atividade->id) as $sequencia)
                                            <li class="list-group-item atividades"
                                                data-atividade-id="{{ $sequencia->atividadePredecessora['id'] }}">
                                                {{ $sequencia->atividadePredecessora['nome'] }}
                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </li>
                                        @empty
                                            <span></span>
                                        @endforelse
                                    </ul>
                                </td>
                                <td class="col-sm-4 col-md-4">
                                    <ul class="dependencias-recursos list-group">
                                        @forelse($sequencias->where('atividade_id', $atividade->id) as $sequencia)
                                            <li class="list-group-item recursos"
                                                data-recurso-id="{{ $sequencia->recurso['id'] }}">
                                                {{ $sequencia->recurso['nome'] }}
                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </li>
                                        @empty
                                            <span></span>
                                        @endforelse
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>

        @include('layouts.partials.sequencia-gestao-recursos', [
            'atividades' => $atividades,
            'recursos' => $recursos,
        ])

        @include('layouts.partials.sequencia-detalhes', [
            'projeto' => $projeto,
            'sequencia' => $sequencia,
            'atividade' => $atividade,
        ])

        @include('layouts.partials.detalhes-recursos', [
            'projeto' => $projeto,
            'sequencia' => $sequencia,
            'atividade' => $atividade,
        ])
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.bootstrap.css') }}">
    <style>
        ul.dependencias,
        ul.dependencias-recursos {
            display: block;
            width: 99.5%;
            height: 2em;
            margin: 0;
            padding: 0;
        }

        ul.dependencias li,
        ul.dependencias-recursos li {
            display: inline;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
    <script src="{{ asset('js/widget-filter.min.js') }}"></script>
    <script>
        $(function() {
            var sequencias = [];

            iniciarDragAndDrop();
            inserirDependencias();
            removerAtividadesEmBranco();
            removerRecursosEmBranco();
            ajustarDropdownCenario();
            verificarSeExistemAtividades();
            habilitarExclusao();
            corrigirLoad();
            habilitarAbrirModalRecursos();
            habilitarSalvarDetalhesRecursos();

            $('table tr td:first-child').click(function (event) {
                event.stopPropagation();
                mostrarModal($(this));
            });

            $('#cenario').change(function (event) {
                event.stopPropagation();

                obterSequenciasDeCenario($(this).val());
            });

            function verificarSeExistemAtividades() {
                var sequencias = $('input[type=hidden][id*=sequencia]');
                if (sequencias.length < 1) {
                    $('#btnSalvar').attr('disabled', 'disabled');
                }
            }

            /* Inicia a capacidade de arrastar e soltar. */
            function iniciarDragAndDrop() {
                $(".dependencias").sortable({
                    revert: true
                }).droppable({
                    drop: function (event, ui) {
                        corrigirDrop();
                        verificarAutoDependencia(ui.draggable);
                        removerAtividadesDuplicadas(ui.draggable);
                    }
                });

                $(".atividades").draggable({
                    connectToSortable: ".dependencias",
                    helper: "clone",
                    revert: "invalid"
                });


                /* Recursos */
                $(".dependencias-recursos").sortable({
                    revert: true
                }).droppable({
                    drop: function (event, ui) {
                        corrigirDrop();
                        if (removerRecursosDuplicados(ui.draggable) == false) {
                            abrirModalDetalhesDeRecursos(ui.draggable);
                        }
                    }
                });

                $(".recursos").draggable({
                    connectToSortable: ".dependencias-recursos",
                    helper: "clone",
                    revert: "invalid"
                });

                //$( "ul, li" ).disableSelection();
            }

            /* Fim da função de arrastar e soltar. */

            /* Correção de drag and drop */
            function corrigirDrop(acionador) {
                $('ul.dependencias li')
                    .attr('style', '')
                    .addClass('col-sm-3')
                    .addClass('col-md-3')
                    .each(function (index, element) {
                        if ($(element).find('span').length > 0) {
                            $(element).find('span').each(function (i, span) {
                                if (!$(span).hasClass('glyphicon-remove-circle')) {
                                    $(span).addClass('glyphicon-remove-circle');
                                }
                            });
                        } else {
                            $(element).append('<span class="glyphicon glyphicon-remove-circle"></span>')
                        }
                    })
                ;

                $('ul.dependencias-recursos li')
                    .addClass('col-sm-3')
                    .addClass('col-md-3')
                    .each(function (index, element) {
                        if ($(element).find('span').length > 0) {
                            $(element).find('span').each(function (i, span) {
                                if (!$(span).hasClass('glyphicon-remove-circle')) {
                                    $(span).addClass('glyphicon-remove-circle');
                                }
                            });
                        } else {
                            $(element).append('<span class="glyphicon glyphicon-remove-circle"></span>')
                        }
                    })
                ;

                habilitarExclusao();
                habilitarAbrirModalRecursos();
            }

            /* Fim da correção de drag and drop */

            function inserirDependencias() {
                $('#btnSalvar').on('click', function (event) {
                    event.preventDefault();
                    inserirAtividadesPredecessoras();
                    inserirRecursosComoDependencia();
                    $('#form-dependencias').submit();
                });
            }

            function inserirAtividadesPredecessoras() {
                sequencias = $('input[type=hidden][id*=sequencia]');

                $(sequencias).val('');

                $(sequencias).each(function (index, sequencia) {
                    var atividades = '';
                    $(sequencia)
                        .parent()
                        .next()
                        .find('li')
                        .each(function (i, atividade) {
                            atividades = atividades + ';' + $(atividade).attr('data-atividade-id');
                        });

                    atividades = atividades.substr(1, atividades.length);
                    $(sequencia).val(atividades);
                    ;
                });
            }

            function verificarAutoDependencia(atividade) {
                if (atividade.text().trim() ===
                    atividade
                        .closest('tr')
                        .find('td')
                        .eq(0)
                        .text()
                        .trim()
                ) {
                    atividade.remove();
                }
            }

            function removerAtividadesEmBranco() {
                var atividades = $('.atividades[data-atividade-id]');
                atividades.each(function (i, atividade) {
                    if (!$(atividade).attr('data-atividade-id')) {
                        $(atividade).remove();
                    }
                });
            }

            function obterSequenciasDeCenario(cenario) {
                window.location.href =
                    '/projetos/{{ $projeto->id }}/sequencias/cenarios/' + cenario;
            }

            function ajustarDropdownCenario() {
                var caminho = window.location.pathname;

                if (caminho.substr(caminho.length - 1, 1) === '/') {
                    caminho = caminho.substr(0, caminho.length - 1);
                    alert('Comp: ' + caminho);
                }

                var cenario = caminho.substr(caminho.lastIndexOf('/') + 1);

                if (!isNaN(cenario)) {
                    $('#cenario').val(parseInt(cenario));
                }
            }

            function removerAtividadesDuplicadas(acionador) {
                var celula = $(acionador).parent();

                var colecao = celula.find('.atividades[data-atividade-id]');

                if (colecao.length < 1) return;

                colecao.each(function (i, item) {
                    if (
                        celula.find('.atividades[data-atividade-id=' +
                            $(item).attr('data-atividade-id')
                            + ']'
                        ).length > 1
                    ) {
                        celula.find('.atividades[data-atividade-id=' +
                            $(item)
                                .attr('data-atividade-id')
                            + ']:not(:first)'
                        ).remove();
                    }
                })
            }

            function removerRecursosDuplicados(acionador) {
                var celula = $(acionador).parent();
                var remover = false;
                var colecao = celula.find('.recursos[data-recurso-id]');

                if (colecao.length < 1) remover = true;

                colecao.each(function (i, item) {
                    if (
                        celula.find('.recursos[data-recurso-id=' +
                            $(item).attr('data-recurso-id')
                            + ']'
                        ).length > 1
                    ) {
                        celula.find('.recursos[data-recurso-id=' +
                            $(item)
                                .attr('data-recurso-id')
                            + ']:not(:first)'
                        ).remove();

                        remover = true;
                    }
                });

                return remover;
            }

            function removerRecursosEmBranco() {
                var recursos = $('.recursos[data-recurso-id]');

                recursos.each(function (i, recurso) {
                    if (!$(recurso).attr('data-recurso-id')) {
                        $(recurso).remove();
                    }
                });
            }

            function habilitarExclusao() {
                $('ul.dependencias li span.glyphicon-remove-circle')
                    .on('click', function () {
                        $(this).parent().remove();
                    });

                $('ul.dependencias-recursos li span.glyphicon-remove-circle')
                    .on('click', function () {
                        $(this).parent().remove();
                    });
            }

            function inserirRecursosComoDependencia() {
                var sequencias_recursos = $('input[type=hidden][id*=sequenciador]');

                $(sequencias_recursos).val('');

                $(sequencias_recursos).each(function (index, sequencia_recurso) {
                    var recursos = '';
                    $(sequencia_recurso)
                        .parent()
                        .next()
                        .next()
                        .find('li')
                        .each(function (i, recurso) {
                            recursos = recursos + ';' + $(recurso).attr('data-recurso-id');
                        });

                    recursos = recursos.substr(1, recursos.length);
                    $(sequencia_recurso).val(recursos);
                    ;
                });
            }

            function corrigirLoad() {
                var colecao = $('ul.dependencias li.atividades.ui-draggable');

                $(colecao).each(function (index, item) {
                    removerAtividadesDuplicadas(item);
                });

                colecao = $('ul.dependencias-recursos li.recursos.ui-draggable');

                $(colecao).each(function (index, item) {
                    removerRecursosDuplicados(item);
                });
            }

            function mostrarModal(alvo) {
                var nomeAtividade = alvo.text();

                $('#modal-sequencia-detalhes').modal('show')
                    .find('h4.modal-title').text(nomeAtividade)
                ;
            }

            $('.tablesorter').tablesorter({
                widgets: ["filter"],
                widgetOptions: {
                    // filter_anyMatch replaced! Instead use the filter_external option
                    // Set to use a jQuery selector (or jQuery object) pointing to the
                    // external filter (column specific or any match)
                    filter_external: '.search',
                    // add a default type search to the first name column
                    filter_defaultFilter: {1: '~{query}'},
                    // include column filters
                    filter_columnFilters: true,
                    filter_placeholder: {search: 'Procurar ...'},
                    filter_saveFilters: true,
                    filter_reset: '.reset'
                }
            });

            function abrirModalDetalhesDeRecursos(alvo) {
                $('#modal-detalhes-recursos').modal('show');
                habilitarSalvarDetalhesRecursos();
            }

            function testeDetalhesDeSequencias(alvo) {
                $('#botaoEnviarDetalhes').on('click', function (event) {
                    event.preventDefault();
                    $('#form-detalhes').submit();
                });
            }

            function salvarDetalhesDeRecursos() {
                var detalhes = [];
                var modal = $('#modal-detalhes-recursos');

                detalhes.push({
                    id: $(alvo).attr('data-recurso-id'),
                    qtd: model.find('#quantidade_recurso').va(),
                    dataDispRecurso: modal.find('#data_inicio_disp_recurso'),
                    tempoAlocado: modal.find('#tempo_alocado').val(),
                });

                alert(detalhes[detalhes.length - 1]);
            }

            function habilitarAbrirModalRecursos() {
                $('ul.dependencias-recursos li').on('click', function () {
                    abrirModalDetalhesDeRecursos($(this));
                });
            };

            testeDetalhesDeSequencias();

            function habilitarSalvarDetalhesRecursos() {
                $('#botaoEnviarDetalhes').on('click', function() {
                    salvarDetalhesDeRecursos();
                });
            }
        });
    </script>
@endsection