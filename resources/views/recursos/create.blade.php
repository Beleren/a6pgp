@extends('layouts.app')

@section('conteudo')
    <div class="container">
        @include('layouts.partials.erros')

        <form action="{{ route('recursos.store', ['projeto' => $projeto->id]) }}"
            class="form-horizontal" method="post">

            {{ csrf_field() }}

            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">Nome:</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome')  }}">
                </div>
            </div>

            <!-- Tipo de Recurso -->
            <div class="form-group">
                <label for="tipo_recurso" class="control-label col-sm-2 col-md-2">Tipo de Recurso:</label>
                <div class="col-sm-6 col-md-6">
                    <select name="tipo_recurso" id="tipo_recurso" class="form-control">
                        <option value="1">Humano</option>
                        <option value="2">Físico</option>
                        <option value="3">Financeiro</option>
                        <option value="4">Tecnológico</option>
                    </select>
                </div>
            </div>

            <!-- Custo Unitário -->
            <div class="form-group">
                <label for="custo" class="control-label col-sm-2 col-md-2">Custo Unitário:</label>
                <div class="col-sm-6 col-md-6">
                    <input type="number" id="custo" name="custo" min="0"
                    class="form-control" value="{{ old('custo') }}">
                </div>
            </div>

            <!-- Botão Submit -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('projetos.show', ['projeto' => $projeto->id]) }}" class="btn btn-default">Voltar</a> |
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#custo').change(function() {
                if($(this).val() < 0) {
                    inserirNotificacaoErro($(this));
                } else {
                    removerNotificacaoErro($(this));
                }
            });

            $('#custo').keyup(function() {
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
                    .attr('title', 'Custo não pode ser negativo!')
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