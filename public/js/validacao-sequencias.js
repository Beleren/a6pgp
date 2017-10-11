$(function() {
    /*
     * Fazer refatoração no Javascript para torná-lo mais legível.
     */
    var sequencias = [];
    var id_recurso = null;
    var id_atividade = null;

    var Sequencias = {
        detalhes: [],

        adicionarDetalhes: function(detalhe) {
            this.detalhes.push(detalhe);
        }
    };

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
        var caminho = window.location.pathname;
        var vetor = caminho.split('/');
        var indice = vetor[2];
        window.location.href =
            '/projetos/' + indice + '/sequencias/cenarios/' + cenario;
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
        $('#modal-detalhes-recursos')
            .modal('show')
            .find('.modal-header h4').text(
                alvo.closest('tr').find('td:first-child').text()
            )
        ;

        id_recurso = $(alvo).attr('data-recurso-id');
        id_atividade = alvo.closest('tr').find('td:first-child input[type=hidden][id*=detalhes]').attr('id');
        habilitarSalvarDetalhesRecursos();
    }

    function testeDetalhesDeSequencias(alvo) {
        $('#botaoEnviarDetalhes').on('click', function (event) {
            event.preventDefault();
            $('#form-detalhes').submit();
        });
    }

    function salvarDetalhesDeRecursos(id_recurso, atividade_id) {
        var modal = $('#modal-detalhes-recursos');

        Sequencias.adicionarDetalhes({
            recurso_id: id_recurso,
            atividade_id: atividade_id,
            qtd: modal.find('#quantidade_recurso').val(),
            dataDispRecurso: modal.find('#data_inicio_disp_recurso').val(),
            tempoAlocado: modal.find('#tempo_alocado').val(),
        });

        console.log(Sequencias);
    }

    function habilitarAbrirModalRecursos() {
        $('ul.dependencias-recursos li').on('click', function () {
            abrirModalDetalhesDeRecursos($(this));
        });
    };

    testeDetalhesDeSequencias();

    function habilitarSalvarDetalhesRecursos() {

        $('button#botaoEnviarDetalhes').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var id = id_atividade.substr(id_atividade.indexOf('-') + 1);
            salvarDetalhesDeRecursos(id_recurso, id);
        });
    }

    habilitarSalvarDetalhesRecursos();
});