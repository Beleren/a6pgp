@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="secao-botao-voltar">
            <a href="{{ route('projetos.show', ['projeto' => $projeto->id]) }}" class="btn btn-default">Voltar</a>
        </div>
        <div>
            <a href="{{ route('cenarios.create', ['projeto' => $projeto]) }}" class="btn btn-primary">Criar Cenário</a>
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
    <script src="{{ asset('js/widget-filter.min.js') }}"></script>
    <script>
        $(function() {
            $('tr:not(:has(th))').each(function(index, linha) {
                $(linha).on('click', function() {
                    window.location.href = $('tr').find('td a').attr('href');
                });
            });

            $('.tablesorter').tablesorter({
                widgets: ["filter"],
                widgetOptions : {
                    // filter_anyMatch replaced! Instead use the filter_external option
                    // Set to use a jQuery selector (or jQuery object) pointing to the
                    // external filter (column specific or any match)
                    filter_external : '.search',
                    // add a default type search to the first name column
                    filter_defaultFilter: { 1 : '~{query}' },
                    // include column filters
                    filter_columnFilters: true,
                    filter_placeholder: { search : 'Procurar ...' },
                    filter_saveFilters : true,
                    filter_reset: '.reset'
                }
            });
        });
    </script>
@endsection