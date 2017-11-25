@extends('layouts.app')

@section('conteudo')
    <div class="container">
        @include('layouts.partials.erros')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>{{ $atividade->nome }}</h3>
            </div>

            <div class="panel-body">
                <form action="{{ route('atividades.update', [
                    'projeto' => $projeto->id, 'atividade' => $atividade->id]) }}"
                    class="form-horizontal" method="post">

                    {{ method_field('PATCH') }}

                    {{ csrf_field() }}

                    <input type="hidden" name="nome" id="nome" value="{{ $atividade->nome }}">

                    <!-- Descrição -->
                    <div class="form-group">
                        <label for="descricao" class="control-label col-sm-2 col-md-2">@lang('paginas.descricao')</label>

                        <div class="col-sm-6 col-md-6">
                            <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="10"
                                      readonly="readonly">{{ $atividade->descricao }}
                            </textarea>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                            <a href="{{ route('atividades.index', ['id' => $projeto->id]) }}"
                               class="btn btn-default">@lang('paginas.voltar')</a> |
                            <button type="submit" class="btn btn-primary" disabled="disabled">@lang('paginas.alterar')</button>
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
            $('input[type=text], input[type=number], textarea').dblclick(function() {
                $(this)
                    .attr('readonly', false);
                $('button, bytton[type=submit], input[type=submit]')
                    .attr('disabled', false);
            });

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