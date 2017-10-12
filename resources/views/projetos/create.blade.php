@extends('layouts.app')

@section('conteudo')
    <div class="container">

        @include('layouts.partials.erros')

        <form action="{{ route('projetos.store') }}"
              class="form-horizontal" method="post">

            {{ csrf_field() }}

            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">Nome:</label>
                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome') }}">
                </div>
            </div>

            <!-- Unidade de Tempo -->
            <div class="form-group">
                <label for="medida_tempo" class="control-label col-sm-2 col-md-2">Unidade de Tempo:</label>
                <div class="col-sm-6 col-md-6">
                    <select name="medida_tempo" id="medida_tempo" class="form-control">
                        <option value="hora">Hora</option>
                        <option value="dia">Dia</option>
                        <option value="semana">Semana</option>
                        <option value="quinzena">Quinzena</option>
                        <option value="mês">Mês</option>
                    </select>
                </div>
            </div>

            <!-- Descrição -->
            <div class="form-group">
                <label for="descricao" class="control-label col-sm-2 col-md-2">Descrição:</label>
                <div class="col-sm-6 col-md-6">
                    <textarea name="descricao" id="descricao"
                        cols="30" rows="10" class="form-control">{{ old('descricao') }}
                    </textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="{{ route('projetos.index') }}" class="btn btn-default">Voltar</a> |
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
            </div>
        </form>
    </div>
@endsection