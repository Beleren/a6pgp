<div id="modal-sequencia-detalhes" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
                <h4 class="modal-title">Atividade</h4>
            </div>
            <div class="modal-body">
                <form id="form-detalhes">
                    {{ csrf_field() }}

                    <!-- Duração -->
                    <div class="form-group">
                        <label for="duracao" class="control-label">Duração:</label>
                        <input type="number" id="duracao" name="duracao" min="0" class="form-control">
                    </div>

                    <!-- Requer Recursos -->
                    <div class="form-group">
                        <label for="requer-recursos" class="control-label">
                            <input type="checkbox" id="requer-recursos" name="requer-recursos">
                            Requer Recursos?
                        </label>
                    </div>

                    <!-- Início Otimista -->
                    <div class="form-group">
                        <label for="inicio-otimista" class="control-label">Início Otimista:</label>
                        <input type="date" id="inicio-otimista" name="inicio-otimista" class="form-control">
                    </div>

                    <!-- Início Pessimista -->
                    <div class="form-group">
                        <label for="inicio-pessimista" class="control-label">Início Pessimista:</label>
                        <input type="date" id="inicio-pessimista" name="inicio-pessimista" class="form-control">
                    </div>

                    <!-- Fim Otimista -->
                    <div class="form-group">
                        <label for="fim-otimista" class="control-label">Fim Otimista:</label>
                        <input type="date" id="fim-otimista" name="fim-otimista" class="form-control">
                    </div>

                    <!-- Fim Pessimista -->
                    <div class="form-group">
                        <label for="fim-pessimista" class="control-label">Fim Pessimista:</label>
                        <input type="date" id="fim-pessimista" name="fim-pessimista" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Sair
                </button>
                <button id="botaoEnviarDetalhes" type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
