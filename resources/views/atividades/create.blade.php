@extends('layouts.app')

@section('conteudo')

    <div class="container">
        @include('layouts.partials.erros')

        <form action="{{ route('atividades.store', ['projeto' => $projeto->id]) }}"
              class="form-horizontal" method="post">
            <div class="form-group">
                {{ csrf_field() }}

                <!-- Nome -->
                <div class="form-group">
                    <label for="nome" class="control-label col-sm-2 col-md-2">Nome:</label>
                    <div class="col-sm-6 col-md-6">
                        <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome') }}">
                    </div>
                </div>

                <!-- Descrição -->
                <div class="form-group">
                    <label for="descricao" class="control-label col-sm-2 col-md-2">Descrição:</label>
                    <div class="col-sm-6 col-md-6">
                        <textarea name="descricao" id="descricao"
                            cols="30" rows="10" class="form-control">{{ old('descricao') }}
                        </textarea>
                    </div>
                </div>

                <!-- Botão Submit -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                        <a href="{{ route('projetos.show', ['projeto' => $projeto->id]) }}" class="btn btn-default">Voltar</a> |
                        <button type="submit" class="btn btn-primary">Criar</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#duracao').change(function() {
                if($(this).val() < 0) {
                    inserirNotificacaoErro($(this));
                } else {
                    removerNotificacaoErro($(this));
                }
            });

            $('#duracao').keyup(function() {
                if($(this).val() < 0) {
                    inserirNotificacaoErro($(this));
                } else {
                    removerNotificacaoErro($(this));
                }
            });

            function inserirNotificacaoErro(elem) {
                $(elem)
                    .attr('data-toggle', 'tooltip')
                    .attr('data-placement', 'top')
                    .attr('title', 'Duração não pode ser negativa!')
                    .parent()
                    .addClass('has-error')
                ;
            }

            function removerNotificacaoErro(elem) {
                $(elem)
                    .removeAttr('data-toggle')
                    .removeAttr('data-placement')
                    .removeAttr('title')
                    .parent()
                    .removeClass('has-error')
                ;
            }
        });
    </script>
@endsection