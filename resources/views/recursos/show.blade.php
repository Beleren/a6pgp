@extends('layouts.app')

@section('conteudo')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>{{ $recurso->nome }}</h3>
            </div>

            <div class="panel-body">
                <form action="{{ route('recursos.update', [
                    'projeto' => $projeto->id, 'recurso' => $recurso->id]) }}"
                    class="form-horizontal" method="post">

                    {{ method_field('PATCH') }}

                    {{ csrf_field() }}

                    <input type="hidden" id="nome" name="nome" value="{{ $recurso->nome }}">

                    <!-- Custo Unitário -->
                    <div class="form-group">
                        <label for="custo" class="control-label col-sm-2 col-md-2">Custo Unitário:</label>

                        <div class="col-sm-6 col-md-6">
                            <input type="number" id="custo" name="custo" min="0"
                               class="form-control" value="{{ $recurso->custo }}"
                               readonly="readonly">
                        </div>
                    </div>

                    <!-- Tipo de Recurso -->
                    <div class="form-group">
                        <label for="tipo_recurso" class="control-label col-sm-2 col-md-2">Tipo de Recurso:</label>
                        <div class="col-sm-6 col-md-6">
                            <select name="tipo_recurso" id="tipo_recurso" class="form-control" readonly="readonly">
                                <option value="1">Humano</option>
                                <option value="2">Físico</option>
                                <option value="3">Financeiro</option>
                                <option value="4">Tecnológico</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                            <a href="{{ route('recursos.index', ['id' => $projeto->id]) }}"
                               class="btn btn-default">Voltar</a> |
                            <button type="submit" class="btn btn-primary" disabled="disabled">Alterar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('input[type=text], input[type=number], textarea, select').dblclick(function() {
                $(this)
                    .attr('readonly', false);
                $('button, bytton[type=submit], input[type=submit]')
                    .attr('disabled', false);
            });

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
