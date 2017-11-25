@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="col-sm-offset-2 col-md-offset-2">
            <p>@lang('paginas.atividades.confirm-delete.deseja-excluir')</p>
        </div>

        <form action="{{ route('atividades.destroy', ['projeto' => $projeto->id, 'atividade' => $atividade->id]) }}"
            class="form-horizontal" method="post">

            {{ method_field('DELETE') }}

            {{ csrf_field() }}

            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">@lang('paginas.nome')</label>

                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control"
                       value="{{ $atividade->nome }}" readonly="readonly">
                </div>
            </div>

            <!-- Descrição -->
            <div class="form-group">
                <label for="descricao" class="control-label col-sm-2 col-md-2">@lang('paginas.descricao')</label>
                <div class="col-sm-6 col-md-6">
                    <textarea name="descricao" id="descricao" cols="30" rows="10"
                        class="form-control" readonly="readonly">{{ $atividade->descricao }}</textarea>
                </div>
            </div>

            <!-- Botão Submit -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('atividades.index', ['id' => $projeto->id ]) }}"
                       class="btn btn-default">@lang('paginas.voltar')</a>
                    <button type="submit" class="btn btn-danger">@lang('paginas.atividades.confirm-delete.excluir')</button>
                </div>
            </div>
        </form>
    </div>
@endsection