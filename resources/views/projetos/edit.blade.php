@extends('layouts.app')

@section('conteudo')
    <div class="container">

        @include('layouts.partials.erros')

        <form action="{{ route('projetos.update', ['id' => $projeto->id]) }}"
              class="form-horizontal" method="post">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">@lang('paginas.projetos.edit.projeto')</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ $projeto->nome }}">
                </div>
            </div>

            <div class="form-group">
                <label for="descricao" class="control-label col-sm-2 col-md-2">@lang('paginas.projetos.edit.descricao')</label>

                <div class="col-sm-6 col-md-6">
                    <textarea name="descricao" id="descricao" cols="30" rows="10" class="form-control">{{ $projeto->descricao }}
                    </textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('projetos.index') }}" class="btn btn-default">@lang('paginas.voltar')</a> |
                    <button type="submit" class="btn btn-primary">@lang('paginas.alterar')</button>
                </div>
            </div>
        </form>
    </div>
@endsection