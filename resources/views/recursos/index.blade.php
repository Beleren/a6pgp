@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-6">
                <a href="{{ route('recursos.create', ['projeto' => $projeto->id]) }}"
                   class="btn btn-primary">
                    @lang('paginas.recursos.index.criar-recurso')
                </a>
            </div>
        </div>
        <table class="table table-striped table-hover tablesorter">
            <thead>
            <tr>
                <th>@lang('paginas.tabelas.recurso')</th>
                <th>@lang('paginas.recursos.index.tipo-recurso')</th>
                <th>@lang('paginas.recursos.index.custo-unitario')</th>
                <th>@lang('paginas.recursos.index.custo-unico')</th>
                <th>@lang('paginas.tabelas.acoes')</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recursos as $recurso)
                <tr>
                    <td>
                        <a href="{{ route('recursos.show',
                            ['atividade' => $recurso->id, 'projeto' => $projeto->id]) }}">
                            {{ $recurso->nome }}
                        </a>
                    </td>
                    <td>{{ $recurso->tipoRecurso->nome }}</td>
                    <td>{{ $recurso->custo }}</td>
                    <td>TODO: Falta implementar</td>
                    <td>
                        <a href="{{ route('recursos.edit',
                            ['recursos' => $recurso->id, 'projeto' => $projeto->id ]) }}">
                            @lang('paginas.tabelas.editar')
                        </a> |
                        <a href="{{ route('recursos.confirm-delete',
                            ['recursos' => $recurso->id, 'projeto' => $projeto->id ]) }}">
                            @lang('paginas.tabelas.excluir')
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td>
                        @lang('paginas.recursos.index.sem-recursos')
                    </td>
                    <td></td>
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