@extends('layouts.app')

@section('conteudo')
    <div class="container-fluid">
        <div class="col-sm-9 col-md-9">
            <form id="form-dependencias" action="{{ route('sequencias.store', ['projeto' => $projeto->id]) }}"
                class="horizontal-form" method="post">

                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-8 col-xs-12">
                        <button id="btnSalvar" name="btnSalvar" type="button" class="btn btn-primary">
                            Salvar Cenário
                        </button>
                        &nbsp;
                        <button id="btnSalvarNovoCenario" name="btnSalvar" type="button" class="btn btn-success">
                            Salvar em Novo Cenário
                        </button>
                        &nbsp;
                        <a href="{{ route('resultado.index', ['projeto' => $projeto->id, 'cenario' => $cenario->id]) }}" class="btn btn-default">Diagrama</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cenario" class="control-label">Cenário:</label>
                    <div>
                        <select id="cenario" name="cenario" class="form-control">
                            @foreach($cenarios as $cenario)
                                <option value="{{ $cenario->id }}">{{ $cenario->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover tablesorter col-sm-8 col-md-8">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Atividades Predecessoras</th>
                        <th>Recursos</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($atividades as $atividade)
                            <tr>
                                <td class="col-sm-3 col-md-3">{{ $atividade->nome }}
                                    <input type="hidden" id="sequencia-{{ $atividade->id }}-dependecias"
                                        name="sequencias[{{ $atividade->id }}][predecessoras]" value="">
                                    <input type="hidden" id="sequenciador-{{ $atividade->id }}-recursos"
                                        name="sequencias[{{ $atividade->id }}][recursos]" value="">
                                    <input type="hidden" id="detalhes-{{ $atividade->id }}"
                                        name="sequencias[{{ $atividade->id }}][detalhes]" value='{}'>
                                </td>
                                <td class="col-sm-5 col-md-5">
                                    <ul class="dependencias list-group">
                                        @forelse($sequencias->where('atividade_id', $atividade->id) as $sequencia)
                                            <li class="list-group-item atividades"
                                                data-atividade-id="{{ $sequencia->atividadePredecessora['id'] }}">
                                                {{ $sequencia->atividadePredecessora['nome'] }}
                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </li>
                                        @empty
                                            <span></span>
                                        @endforelse
                                    </ul>
                                </td>
                                <td class="col-sm-4 col-md-4">
                                    <ul class="dependencias-recursos list-group">
                                        @forelse($sequencias->where('atividade_id', $atividade->id) as $sequencia)
                                            <li class="list-group-item recursos"
                                                data-recurso-id="{{ $sequencia->recurso['id'] }}">
                                                {{ $sequencia->recurso['nome'] }}
                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </li>
                                        @empty
                                            <span></span>
                                        @endforelse
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>

        @include('layouts.partials.sequencia-gestao-recursos', [
            'atividades' => $atividades,
            'recursos' => $recursos,
        ])

        @include('layouts.partials.sequencia-detalhes', [
            'projeto' => $projeto,
            'atividade' => $atividade,
        ])

        @include('layouts.partials.detalhes-recursos', [
            'projeto' => $projeto,
            'atividade' => $atividade,
        ])
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.bootstrap.css') }}">
    <style>
        ul.dependencias,
        ul.dependencias-recursos {
            display: block;
            width: 99.5%;
            height: 2em;
            margin: 0;
            padding: 0;
        }

        ul.dependencias li,
        ul.dependencias-recursos li {
            display: inline;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tablesorter.widgets.min.js') }}"></script>
    <script src="{{ asset('js/widget-filter.min.js') }}"></script>
    <script src="{{ asset('js/validacao-sequencias.js') }}"></script>
@endsection