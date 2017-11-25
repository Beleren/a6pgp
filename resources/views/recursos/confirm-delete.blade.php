@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="col-sm-offset-2 col-md-offset-2">
            <p>@lang('paginas.recursos.deseja-excluir')</p>
        </div>

        <form action="{{ route('recursos.destroy', ['projeto' => $projeto->id, 'recurso' => $recurso->id]) }}"
            class="form-horizontal" method="post">

            {{ method_field('DELETE') }}

            {{ csrf_field() }}

            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">@lang('paginas.nome')</label>

                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control"
                           value="{{ $recurso->nome }}" readonly="readonly">
                </div>
            </div>

            <!-- Custo Unitário -->
            <div class="form-group">
                <label for="custo" class="control-label col-sm-2 col-md-2">@lang('paginas.recursos.index.custo-unitario')</label>

                <div class="col-sm-6 col-md-6">
                    <input type="number" id="custo" name="custo" class="form-control"
                           value="{{ $recurso->custo }}" readonly="readonly">
                </div>
            </div>

            <!-- Tipo de Recurso -->
            <div class="form-group">
                <label for="tipo_recurso" class="control-label col-sm-2 col-md-2">@lang('paginas.recursos.index.tipo-recurso')</label>
                <div class="col-sm-6 col-md-6">
                    @if($recurso->tipoRecurso->nome == 'Humano')
                    <input type="text" id="tipo_recurso" name="tipo_recurso" class="form-control"
                       value="@lang('paginas.recursos.index.tipos-recursos.humano')" readonly="readonly">
                    @elseif($recurso->tipoRecurso->nome == 'Tecnológico')
                    <input type="text" id="tipo_recurso" name="tipo_recurso" class="form-control"
                       value="@lang('paginas.recursos.index.tipos-recursos.fisico')" readonly="readonly">
                    @elseif($recurso->tipoRecurso->nome == 'Financeiro')
                    <input type="text" id="tipo_recurso" name="tipo_recurso" class="form-control"
                       value="@lang('paginas.recursos.index.tipos-recursos.financeiro')" readonly="readonly">
                    @else
                    <input type="text" id="tipo_recurso" name="tipo_recurso" class="form-control"
                       value="@lang('paginas.recursos.index.tipos-recursos.tecnologico')" readonly="readonly">
                    @endif
                </div>
            </div>

            <!-- Botão Submit -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('recursos.index', ['id' => $projeto->id ]) }}"
                       class="btn btn-default">Voltar</a>
                    <button type="submit" class="btn btn-danger">@lang('paginas.confirmar-exclusao')</button>
                </div>
            </div>
        </form>
    </div>
@endsection