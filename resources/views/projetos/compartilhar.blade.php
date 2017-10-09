@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="modal fade" tabindex="-1" role="dialog" id="compartilhar-projeto">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Compartilhar Projeto</h4>
                    </div>
                    <div class="modal-body">
                        <p>Digite o(s) e-mail(s) do(s) usuário(s) separados por vírgula (&semi;) que você deseja compartilhar este projeto.</p>
                        <form action="{{ route('projetos.salvar-compartilhamento', [
                                'projeto' => $projeto,
                            ]) }}"
                              class="form-horizontal"
                              method="post"
                        >
                            <div class="form-group">
                                <label for="projeto-nome" class="control-label">Projeto:</label>
                                <div class="well">

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="projeto-usuarios" class="control-label"></label>
                                <div>
                                    <textarea name="projeto-usuarios" id="projeto-usuarios"
                                        cols="30" rows="6" class="form-control"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                        <button type="button" class="btn btn-primary">Compartilhar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('#compartilhar-projeto').modal('show');
        });
    </script>
@endsection