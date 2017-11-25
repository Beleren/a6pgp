@extends('layouts.app')

@section('conteudo')
    <div class="container">
        @include('layouts.partials.erros')

        <form action="{{ route('recursos.update', [
            'projeto' => $projeto->id, 'recurso' => $recurso->id]) }}"
              class="form-horizontal" method="post">

            {{ method_field('PATCH') }}

            {{ csrf_field() }}

            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">@lang('paginas.nome')</label>

                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control"
                           value="{{ $recurso->nome }}">
                </div>
            </div>

            <!-- Custo Unitário -->
            <div class="form-group">
                <label for="custo" class="control-label col-sm-2 col-md-2">@lang('paginas.recursos.index.custo-unitario')</label>

                <div class="col-sm-6 col-md-6">
                    <input type="number" id="custo" name="custo" step="10" min="0"
                       class="form-control" value="{{ $recurso->custo }}">
                </div>
            </div>

            <!-- Tipo de Recurso -->
            <div class="form-group">
                <label for="tipo_recurso" class="control-label col-sm-2 col-md-2">@lang('paginas.recursos.index.tipo-recurso')</label>
                <div class="col-sm-6 col-md-6">
                    <select name="tipo_recurso" id="tipo_recurso" class="form-control">
                        <option value="1" @if($recurso->tipoRecurso->nome === 'Humano') selected="selected" @endif>
                            @lang('paginas.recursos.index.tipos-recursos.humano')</option>
                        <option value="2" @if($recurso->tipoRecurso->nome === 'Físico') selected="selected" @endif>
                            @lang('paginas.recursos.index.tipos-recursos.fisico')</option>
                        <option value="3" @if($recurso->tipoRecurso->nome === 'Financeiro') selected="selected" @endif>
                            @lang('paginas.recursos.index.tipos-recursos.financeiro')</option>
                        <option value="4" @if($recurso->tipoRecurso->nome === 'Tecnológico') selected="selected" @endif>
                            @lang('paginas.recursos.index.tipos-recursos.tecnologico')</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('recursos.index', ['id' => $projeto->id]) }}"
                       class="btn btn-default">@lang('paginas.voltar')</a> |
                    <button type="submit" class="btn btn-primary">@lang('paginas.alterar')</button>
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