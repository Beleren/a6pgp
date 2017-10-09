@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="secao-botao-voltar">
            <a href="{{ route('projetos.show', ['projeto' => $projeto->id]) }}" class="btn btn-default">Voltar</a>
        </div>
        <div>
            <a href="{{ route('atividades.create', ['projeto' => $projeto->id]) }}"
               class="btn btn-primary">
                Criar Atividade
            </a>
            |
            <a href="{{ route('sequencias.index', [
                'projeto' => $projeto->id,
                'cenario' => $projeto->cenarios->first()
            ]) }}"
                class="btn btn-default">
                Gerenciar Sequência
            </a>
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