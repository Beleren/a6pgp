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
                <form>
                    <!-- Duração -->
                    <div class="form-group">
                        <label for="duracao" class="control-label">Duração:</label>
                        <input type="text" id="duracao" name="duracao" class="form-control">
                    </div>

                    <!-- Requer Recursos -->
                    <div class="form-group">
                        <label for="requer_recursos" class="control-label">
                            <input type="checkbox" id="requer_recursos" name="requer_recursos">
                            Requer Recursos?
                        </label>
                    </div>

                    <!-- Quantidade -->
                    <div class="form-group">
                        <label for="quantidade_recurso" class="control-label">Quantidade de Rercurso</label>
                        <input type="number" id="quantidade_recurso" name="quantidade_recurso[]"
                        class="form-control">
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
