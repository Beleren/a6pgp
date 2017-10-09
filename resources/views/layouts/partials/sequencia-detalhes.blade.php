<div id="myModal" class="modal fade" tabindex="-1" role="dialog"
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
                <form method="post">
                    {{ csrf_field() }}

                    <!-- Duração -->
                    <div class="form-group">
                        <label for="duracao" class="control-label">
                            Duração
                        </label>
                        <input type="number" id="duracao" name="duracao"
                            min="0" class="form-control">
                    </div>

                    <!-- Requer Recursos -->
                    <div class="form-group">
                        <label for="requer-recursos" class="control-label">
                            <input type="checkbox" id="requer-recursos" name="requer-recursos"
                                class="form-control">Requer Recursos?
                        </label>
                    </div>

                    <!-- Quantidade de Rercusos -->
                    <div class="form-group">
                        <label for="quantidade-recurso" class="control-label">
                            Quantidade de Recursos
                        </label>
                        <input type="number" id="quantidade-recurso" name="quantidade-recurso"
                            step="1" min="0" class="form-control">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Sair
                </button>
                <button type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
