@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-6">
                <a href="{{ route('atividades.create', ['projeto' => $projeto->id]) }}"
                   class="btn btn-primary">
                    @lang('paginas.atividades.index.criar-atividade')
                </a>
            </div>
        </div>
        <table class="table table-striped table-hover tablesorter">
            <thead>
                <tr>
                    <th>@lang('paginas.tabelas.atividades')</th>
                    <th>@lang('paginas.tabelas.descricao')</th>
                    <th>@lang('paginas.tabelas.criado-em')</th>
                    <th>@lang('paginas.tabelas.acoes')</th>
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
                        <td>{{ $atividade->descricao }}</td>
                        <td>@if(app()->getLocale() !== 'en')
                            {{ $atividade->created_at->format('d/m/Y') }}
                            @else
                            {{ $atividade->created_at->format('m/d/Y') }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('atividades.edit', ['atividade' => $atividade->id, 'projeto' => $projeto->id ]) }}">@lang('paginas.tabelas.editar')</a> |
                            <a href="{{ route('atividades.confirm-delete', ['atividade' => $atividade->id, 'projeto' => $projeto->id ]) }}">@lang('paginas.tabelas.excluir')</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            @lang('paginas.atividades.index.sem-atividades')
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