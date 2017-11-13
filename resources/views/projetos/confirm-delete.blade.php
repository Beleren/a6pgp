@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="col-sm-offset-2 col-md-offset-2">
            <p>Você deseja excluir permanentemente o projeto abaixo?</p>
        </div>

        <form action="{{ route('projetos.destroy', ['id' => $projeto->id]) }}"
              class="form-horizontal" method="post">

            {{ method_field('DELETE') }}

            {{ csrf_field() }}

            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">Projeto:</label>

                <div class="col-sm-6 col-md-6">
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ $projeto->nome }}" readonly="readonly">
                </div>
            </div>

            <div class="form-group">
                <label for="descricao" class="control-label col-sm-2 col-md-2">Descrição:</label>

                <div class="col-sm-6 col-md-6">
                    <textarea name="descricao" id="descricao" cols="30" rows="10" class="form-control" readonly="readonly">{{ $projeto->descricao }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('projetos.index') }}" class="btn btn-default">Voltar</a> |
                    <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
                </div>
            </div>
        </form>
    </div>
@endsection