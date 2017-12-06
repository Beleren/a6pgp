@extends('layouts.app')

@section('conteudo')
    <div class="container">
        @include('layouts.partials.erros')

        <form action="{{ route('cenarios.update', ['projeto' => $cenario->projeto->id, 'cenario' => $cenario->id]) }}"
              class="form-horizontal" method="post">

            {{ method_field('PATCH') }}

            {{ csrf_field() }}

            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">@lang('paginas.nome')</label>

                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control"
                       value="{{ $cenario->nome }}">
                </div>
            </div>

            <!-- Data de Início do Projeto -->
            <div class="form-group">
                <label for="data_inicio_projeto" class="control-label col-sm-2 col-md-2">@lang('paginas.cenarios.data-inicio-projeto')</label>

                <div class="col-sm-6 col-md-6">
                    <input type="date" id="data_inicio_projeto" name="data_inicio_projeto" class="form-control"
                       value="{{ $cenario->data_inicio_projeto }}">
                </div>
            </div>

            <!-- Descrição -->
            <div class="form-group">
                <label for="descricao" class="control-label col-sm-2 col-md-2">@lang('paginas.descricao')</label>
                <div class="col-sm-6 col-md-6">
                    <textarea name="descricao" id="descricao" cols="30" rows="10" class="form-control">{{ $cenario->descricao }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('cenarios.index', ['id' => $cenario->projeto->id]) }}" class="btn btn-default">@lang('paginas.voltar')</a> |
                    <button type="submit" class="btn btn-primary">@lang('paginas.alterar')</button>
                    <div class="pull-right">
                        <a href="{{ route('sequencias.index', [
                            'projeto' => $projeto,
                            'cenario' => $cenario->id,
                        ]) }}" class="btn btn-default">
                            @lang('paginas.cenarios.visualizar-sequencias')
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection