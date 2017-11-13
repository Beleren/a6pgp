<div class="modal fade" tabindex="-1" role="dialog" id="compartilhar-projeto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title">Compartilhar Projeto</h4>
            </div>
            <div class="modal-body">
                <p>
                    Digite o(s) e-mail(s) do(s) usuário(s) que você deseja compartilhar
                    este projeto separados por vírgula (&semi;).
                </p>
                <form action="#" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="projeto-nome" class="control-label">Projeto:</label>
                        <div class="well">
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="projeto-usuarios" id="projeto-usuarios"
                            cols="30" rows="6" class="form-control"
                            placeholder="Digite os e-mails separados por vírgula (&semi;) aqui."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                <button type="button" class="btn btn-primary" id="botao-compartilhar">Compartilhar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="compartilhar-projeto">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title">Compartilhar Projeto</h4>
            </div>
            <div class="modal-body">
                <p>
                    Digite o(s) e-mail(s) do(s) usuário(s) que você deseja compartilhar
                    este projeto separados por vírgula (&semi;).
                </p>
                <form action="#" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="projeto-nome" class="control-label">Projeto:</label>
                        <div class="well">
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="projeto-usuarios" id="projeto-usuarios"
                            cols="30" rows="6" class="form-control"
                            placeholder="Digite os e-mails separados por vírgula (&semi;) aqui."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                <button type="button" class="btn btn-primary" id="botao-compartilhar">Compartilhar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
