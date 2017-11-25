@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="col-sm-offset-2 col-md-offset-2">
            <p>@lang('paginas.cenarios.deseja-excluir')</p>
        </div>

        <form action="{{ route('cenarios.destroy', ['projeto' => $cenario->projeto->id, 'cenario' => $cenario->id]) }}"
              class="form-horizontal" method="post">

            {{ method_field('DELETE') }}

            {{ csrf_field() }}

            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">@lang('paginas.nome')</label>

                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control"
                       value="{{ $cenario->nome }}" readonly="readonly">
                </div>
            </div>

            <!-- Descrição -->
            <div class="form-group">
                <label for="descricao" class="control-label col-sm-2 col-md-2">@lang('paginas.descricao')</label>
                <div class="col-sm-6 col-md-6">
                    <textarea name="descricao" id="descricao" cols="30" rows="10"
                      class="form-control" readonly="readonly">{{ $cenario->descricao }}</textarea>
                </div>
            </div>

            <!-- Botão Submit -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('cenarios.index', ['id' => $cenario->projeto->id ]) }}"
                       class="btn btn-default">@lang('paginas.voltar')</a>
                    <button type="submit" class="btn btn-danger">@lang('paginas.confirmar-exclusao')</button>
                </div>
            </div>
        </form>
    </div>
@endsection