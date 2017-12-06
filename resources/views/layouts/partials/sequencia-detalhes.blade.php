<div id="modal-sequencia-detalhes" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
                <h4 class="modal-title">@lang('paginas.sequencias.atividade')</h4>
            </div>
            <div class="modal-body">
                <form id="form-detalhes">
                    {{ csrf_field() }}

                    <!-- Duração -->
                    <div class="form-group">
                        <label for="duracao" class="control-label">@lang('paginas.sequencias.duracao')</label>
                        <input type="number" id="duracao" name="duracao" min="0" class="form-control">
                    </div>

                    <!-- Requer Recursos -->
                    <div class="form-group">
                        <label for="requer-recursos" class="control-label">
                            <input type="checkbox" id="requer-recursos" name="requer-recursos">
                            @lang('paginas.sequencias.requer-recursos')
                        </label>
                    </div>

                    <!-- Início Otimista -->
                    <div class="form-group">
                        <label for="inicio-otimista" class="control-label">@lang('paginas.sequencias.inicio-otimista')</label>
                        <input type="date" id="inicio-otimista" name="inicio-otimista" class="form-control" readonly>
                    </div>

                    <!-- Início Pessimista -->
                    <div class="form-group">
                        <label for="inicio-pessimista" class="control-label">@lang('paginas.sequencias.inicio-pessimista')</label>
                        <input type="date" id="inicio-pessimista" name="inicio-pessimista" class="form-control" readonly>
                    </div>

                    <!-- Fim Otimista -->
                    <div class="form-group">
                        <label for="fim-otimista" class="control-label">@lang('paginas.sequencias.fim-otimista')</label>
                        <input type="date" id="fim-otimista" name="fim-otimista" class="form-control" readonly>
                    </div>

                    <!-- Fim Pessimista -->
                    <div class="form-group">
                        <label for="fim-pessimista" class="control-label">@lang('paginas.sequencias.fim-pessimista')</label>
                        <input type="date" id="fim-pessimista" name="fim-pessimista" class="form-control" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    @lang('paginas.sair')
                </button>
                <button id="botaoEnviarDetalhes" type="button" class="btn btn-primary">@lang('paginas.salvar')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
