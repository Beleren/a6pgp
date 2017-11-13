@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="secao-botao-voltar col-sm-1">
                <a href="{{ route('projetos.index') }}" class="btn btn-default">Voltar</a>
            </div>

            <div class="col-md-1 col-xs-1">
                <a href="{{ route('sequencias.index', [
                            'projeto' => $projeto->id,
                            'cenario' => $projeto->cenarios->first()
                        ]) }}"
                   class="btn btn-default">
                    Gerenciar Sequência
                </a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a class="btn btn-link btn-block" role="button"
                        data-toggle="collapse" href="#detalhes"
                        aria-expanded="false" aria-controls="detalhes"
                    >
                        {{ $projeto->nome }}
                    </a>
                </h3>
            </div>
            <div class="panel-body collapse" id="detalhes">
                <div class="col-sm-6  col-md-6">
                    <h4>Descrição</h4>
                    <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="6"
                      readonly="readonly">{{ $projeto->descricao }}
                    </textarea>
                </div>
            </div>
        </div>

        <!-- Atividades -->
        <div class="col-sm-4 col-md-4">
            <ul class="list-group">
                <li class="list-group-item active">
                    <strong>
                        <a href="{{ route('atividades.index', [
                            'projeto' => $projeto->id]) }}"
                            class="btn btn-link"
                            title="Clique aqui para visualizar mais atividades."
                            data-toggle="tooltip"
                            data-placement="top"
                        >
                            Atividades
                        </a>
                        <span class="badge">{{ $projeto->atividades->count() }}</span>
                    </strong>
                    <a class="btn btn-primary adicionar"
                        href="{{ route('atividades.create', [
                        'projeto' => $projeto->id]) }}"
                    >
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </li>
                @foreach($projeto->atividades as $atividade)
                    <li class="list-group-item">
                        <a href="{{ route('atividades.show', [
                            'projeto' => $projeto->id,
                            'atividade' => $atividade->id,
                        ]) }}" class="btn btn-link">
                            {{ $atividade->nome }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Recursos -->
        <div class="col-sm-4 col-md-4">
            <ul class="list-group">
                <li class="list-group-item active">
                    <strong>
                        <a href="{{ route('recursos.index', [
                            'projeto' => $projeto->id]) }}"
                            class="btn btn-link"
                            title="Clique aqui para visualizar mais recursos."
                            data-toggle="tooltip"
                            data-placement="top"
                        >
                            Recursos
                        </a>
                        <span class="badge">{{ $projeto->recursos->count() }}</span>
                    </strong>
                    <a class="btn btn-primary adicionar"
                        href="{{ route('recursos.create', [
                        'projeto' => $projeto->id]) }}">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </li>
                @foreach($projeto->recursos as $recurso)
                    <li class="list-group-item">
                        <a href="{{ route('recursos.edit', [
                            'projeto' => $projeto->id,
                        '   $recurso' => $recurso->id,
                            ]) }}" class="btn btn-link"
                        >
                            {{ $recurso->nome }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Cenários -->
        <div class="col-sm-4 col-md-4">
            <ul class="list-group">
                <li class="list-group-item active">
                    <strong>
                        <a href="{{ route('cenarios.index', [
                            'projeto' => $projeto->id]) }}"
                            class="btn btn-link"
                            title="Clique aqui para visualizar mais atividades."
                            data-toggle="tooltip"
                            data-placement="top"
                        >
                            Cenários
                        </a>
                        <span class="badge">{{ $projeto->cenarios->count() }}</span>
                    </strong>
                    <a class="btn btn-primary adicionar"
                        href="{{ route('cenarios.create', [
                        'projeto' => $projeto->id]) }}">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </li>
                @foreach($projeto->cenarios as $cenario)
                    <li class="list-group-item">
                        <a href="{{ route('cenarios.edit', [
                            'projeto' => $projeto->id,
                            'cenario' => $cenario->id,
                        ]) }}" class="btn btn-link">
                            {{ $cenario->nome }}
                        </a>
                    </li>
                @endforeach
            </ul>
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

            $('.list-group-item:not(.active) a')
                .parent()
                .click(function(event) {
                    window.location.href = $(this).find('a').attr('href');
                })
            ;
        })
    </script>
@endsection