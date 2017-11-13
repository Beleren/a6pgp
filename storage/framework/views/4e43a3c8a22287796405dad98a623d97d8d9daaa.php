<div id="modal-detalhes-recursos" class="modal fade" tabindex="-1" role="dialog"
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
                <form id="form-detalhes-recursos">
                    <?php echo e(csrf_field()); ?>


                    <!-- Quantidade de Recursos -->
                    <div class="form-group">
                        <label for="quantidade-recurso" class="control-label">Quantidade de Rercurso</label>
                        <input type="number" id="quantidade-recurso" name="quantidade-recurso[]"
                            min="0" class="form-control">
                    </div>

                    <!-- Data de Disponbilização do Recurso -->
                    <div class="form-group">
                        <label for="data-inicio-disp-recurso" class="control-label">
                            Data de Disponibilização do Recurso
                        </label>
                        <input type="date" id="data-inicio-disp-recurso" name="data-inicio-disp-recurso"
                               class="form-control">
                    </div>

                    <!-- Tempo Alocado -->
                    <div class="form-group">
                        <label for="tempo-alocado" class="control-label">
                            Tempo Alocado:
                        </label>
                        <input type="time" id="tempo-alocado" name="tempo-alocado" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Sair
                </button>
                <button id="botaoEnviarDetalhesRecursos" type="button" class="btn btn-primary">Salvar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->