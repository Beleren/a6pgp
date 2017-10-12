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
                        <li><a href="{{ route('recursos.index',$projeto->id) }}">Recursos</a></li>
                        <li><a href="{{ route('cenarios.index',$projeto->id) }}">Cenários</a></li>
                    </ul>
                </div>

                <div class="col-md-5 col-xs-7">
                    <div class="col-md-4 col-xs-6">
                        <a href="{{ route('atividades.create', ['projeto' => $projeto->id]) }}"
                           class="btn btn-primary">
                            Criar Atividade
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
        <table class="table table-striped table-hover tablesorter">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Duração</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($atividades as $atividade)
                    <tr>
                        <td>
                            <a href="{{ route('atividades.show', [
                                'atividade' => $atividade->id,
                                'projeto' => $projeto->id]) }}">
                                {{ $atividade->nome }}
                            </a>
                        </td>
                        <td>{{ $atividade->duracao }}</td>
                        <td>{{ $atividade->descricao }}</td>
                        <td>
                            <a href="{{ route('atividades.edit', ['atividade' => $atividade->id, 'projeto' => $projeto->id ]) }}">Editar</a> |
                            <a href="{{ route('atividades.confirm-delete', ['atividade' => $atividade->id, 'projeto' => $projeto->id ]) }}">Excluir</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            Não há atividades cadastradas.
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
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