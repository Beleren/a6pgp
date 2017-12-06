@extends('layouts.app')

@section('conteudo')
    <div class="container">
        @include('layouts.partials.erros')

        <form action="{{ route('cenarios.store', ['projeto' => $projeto->id]) }}"
              class="form-horizontal" method="post">
            {{ csrf_field() }}

            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-md-2 col-sm-2">@lang('paginas.cenarios.nome')</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome') }}">
                </div>
            </div>

            <!-- Data de Início do Projeto -->
            <div class="form-group">
                <label for="data_inicio_projeto" class="control-label col-md-2 col-sm-2">@lang('paginas.cenarios.data-inicio-projeto')</label>
                <div class="col-sm-6 col-md-6">
                    <input type="date" id="data_inicio_projeto"
                       name="data_inicio_projeto" class="form-control" value="{{ old('data_inicio_projeto') }}">
                </div>
            </div>

            <!-- Descrição -->
            <div class="form-group">
                <label for="descricao" class="control-label col-sm-2 col-md-2">
                    @lang('paginas.descricao')
                </label>
                <div class="col-sm-6 col-md-6">
                    <textarea id="descricao" name="descricao"
                          cols="30" rows="10" class="form-control">{{ old('descricao') }}
                    </textarea>
                </div>
            </div>

            <!-- Botões -->
            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('projetos.show', ['projeto' => $projeto->id]) }}" class="btn btn-default">Voltar</a> |
                    <button type="submit" class="btn btn-primary">
                        Criar
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection