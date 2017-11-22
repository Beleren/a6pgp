@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-6">
                <a href="{{ route('cenarios.create', ['projeto' => $projeto]) }}" class="btn btn-primary">Criar Cenário</a>
            </div>
        </div>
        <table class="table table-striped table-hover tablesorter">
            <thead>
                <tr>
                    <th>Cenário</th>
                    <th>Data de Criação</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cenarios as $cenario)
                    <tr>
                        <td>
                            <a href="{{ route('cenarios.show',
                                ['cenario' => $cenario->id, 'projeto' => $cenario->projeto->id]) }}">
                                {{ $cenario->nome }}
                            </a>
                        </td>
                        <td>{{ $cenario->created_at->format('d/m/Y') }}</td>
                        <td>{{ $cenario->descricao }}</td>
                        <td>
                            <a href="{{ route('cenarios.edit',
                                ['cenario' => $cenario->id, 'projeto' => $cenario->projeto->id ]) }}">
                                Editar
                            </a> |
                            <a href="{{ route('cenarios.confirm-delete',
                                ['cenario' => $cenario->id, 'projeto' => $cenario->projeto->id ]) }}">
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