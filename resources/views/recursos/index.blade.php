@extends('layouts.app')

@section('conteudo')
    <div class="container">

        <div class="row">
            <div class="secao-botao-voltar col-md-1 col-xs-2">
                <a href="{{ route('projetos.show', ['projeto' => $projeto->id]) }}" class="btn btn-default">Voltar</a>
            </div>
            <div class="dropdown col-md-1 col-xs-2">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Menu
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('atividades.index',$projeto->id) }}">Atividades</a></li>
                    <li><a href="{{ route('cenarios.index',$projeto->id) }}">Cenários</a></li>
                </ul>
            </div>

            <div class="col-md-5 col-xs-7">
                <div class="col-md-4 col-xs-6">
                    <a href="{{ route('recursos.create', ['projeto' => $projeto->id]) }}"
                       class="btn btn-primary">
                        Criar Recurso
                    </a>
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

        </div>

        <div>

        </div>
        <table class="table table-striped table-hover tablesorter">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Tipo de Recurso</th>
                <th>Custo Unitário</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($recursos as $recurso)
                <tr>
                    <td>
                        <a href="{{ route('recursos.show',
                            ['atividade' => $recurso->id, 'projeto' => $projeto->id]) }}">
                            {{ $recurso->nome }}
                        </a>
                    </td>
                    <td>{{ $recurso->tipoRecurso->nome }}</td>
                    <td>{{ $recurso->custo }}</td>
                    <td>
                        <a href="{{ route('recursos.edit',
                            ['recursos' => $recurso->id, 'projeto' => $projeto->id ]) }}">
                            Editar
                        </a> |
                        <a href="{{ route('recursos.confirm-delete',
                            ['recursos' => $recurso->id, 'projeto' => $projeto->id ]) }}">
                            Excluir
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/theme.bootstrap.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tablesorter.widgets.min.js') }}"></script>
    <script src="{{ asset('js/widget-filter.min.js') }}"></script>
    <script src="{{ asset('js/app.tablesorter.config.js') }}"></script>
@endsection