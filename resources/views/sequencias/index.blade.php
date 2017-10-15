@extends('layouts.app')

@section('conteudo')
    <div class="container-fluid">
        <div class="col-sm-9 col-md-9">
            <form id="form-dependencias" action="{{ route('sequencias.store', ['projeto' => $projeto->id]) }}"
                class="horizontal-form" method="post">

                {{ csrf_field() }}

                <div class="row">
                    <div class="secao-botao-voltar col-md-1 col-xs-2">
                        <a href="{{ route('atividades.index', ['projeto' => $projeto]) }}" class="btn btn-default">Voltar</a>
                    </div>
                    <div class="dropdown col-md-1 col-xs-2">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Menu
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('atividades.index',$projeto->id) }}">Atividades</a></li>
                            <li><a href="{{ route('recursos.index',$projeto->id) }}">Recursos</a></li>
                            <li><a href="{{ route('cenarios.index',$projeto->id) }}">Cenários</a></li>
                        </ul>
                    </div>

                    <div class="col-md-5 col-xs-7">
                        <div class="col-md-4 col-xs-6">
                            <button id="btnSalvar" name="btnSalvar" type="button" class="btn btn-primary">
                                Salvar
                            </button>
                        </div>

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
            <span>o gerador de diagrama está demorando para gerar, há um atraso na abertura página</span>
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
    <script src="{{ asset('js/viz.js') }}"></script>
    <script>
        /*procedimento de codificação
            1-verificar projeto
            2-verificar cenário
            3-verificar atividades
            4-verificar sequencias de atividades
            5-atividades sem sequencias serão montadas primeiro
            6-atividades sem recursos serão consideradas milestones
            7-condição de parada: atividades que possuem predecessoras mas não são predecessoras de nenhuma
        */

        image = Viz("digraph g { node [shape=record];\n" +
            "\"Escavação\" [label = \"{0 | 0} |{Escavação|2}| {2|2}\"]\n" +
            "\"Fundação\" [label = \"{2 | 6 } | {Fundação|4}| {6|6}\"]\n" +
            "\"Parede\" [label = \"{6|6} | {Parede|10} | {16|16}\"]\n" +
            "\"Telhado\" [label = \"{16 |20 } | {Telhado | 6} | {22 | 26}\"]\n" +
            "\"Enc Exterior\" [label = \"{16 |16 } | {Enc Exterior | 4} | {20 | 20}\"]\n" +
            "\"Enc Interior\" [label = \"{20 | 20} | {Enc Interior | 5} | {25 |25 }\"]\n" +
            "\"Muros\" [label = \"{ 22 |26 } | {Muros | 7} | {25 |33 }\"]\n" +
            "\"Pintura Ext\" [label = \"{29 |33 } | {Pintura Ext | 9} | {38 |42 }\"]\n" +
            "\"Inst Elétrica\" [label = \"{16 |18 } | {Inst Elétrica | 7} | {23 |25 }\"]\n" +
            "\"Divisórias\" [label = \"{25 |25 } | {Divisórias | 8} | {33 |33 }\"]\n" +
            "\"Piso\" [label = \"{33 |34 } | {Piso | 4} | {37 |38 }\"]\n" +
            "\"Pintura Int\" [label = \"{33 |33 } | {Pintura Int | 5} | {38 | 38}\"]\n" +
            "\"Acabamento Ext\" [label = \"{38 |42 } | {Acabamento Ext | 2} | {40 |44 }\"]\n" +
            "\"Acabamento Int\" [label = \"{ 38 |38 } | {Acabamanto Int | 6} | {44 |44 }\"]\n" +
            "Inicio ->\"Escavação\" [color=\"red\"]\n" +
            "\"Escavação\" ->\"Fundação\" [color=\"red\"]\n" +
            "\"Fundação\" ->\"Parede\" [color = \"red\"]\n" +
            "\"Parede\" ->\"Telhado\"\n" +
            "\"Parede\" ->\"Enc Exterior\" [color=\"red\"]\n" +
            "\"Enc Exterior\" ->\"Enc Interior\"[color = \"red\"]\n" +
            "\"Telhado\" ->\"Muros\"\n" +
            "\"Enc Exterior\" ->\"Pintura Ext\"\n" +
            "\"Muros\" ->\"Pintura Ext\"\n" +
            "\"Parede\" ->\"Inst Elétrica\"\n" +
            "\"Enc Interior\" ->\"Divisórias\" [color=\"red\"]\n" +
            "\"Inst Elétrica\" ->\"Divisórias\"\n" +
            "\"Divisórias\" ->\"Piso\"\n" +
            "\"Divisórias\" ->\"Pintura Int\"[color=\"red\"]\n" +
            "\"Pintura Ext\" ->\"Acabamento Ext\"\n" +
            "\"Piso\" ->\"Acabamento Int\"\n" +
            "\"Pintura Int\" ->\"Acabamento Int\" [color=\"red\"]\n" +
            "\"Acabamento Int\" ->Fim [color=\"red\"]\n" +
            "\"Acabamento Ext\" ->Fim\n" +
            "struct3 [label=\" {PDI| UDI}\n" +
            "|{Atividade|Duração}|\n" +
            "{PDT|UDT}\"]; }", { format: "png-image-element" });
        //comentar se for realizar manutenção da página
        document.body.appendChild(image);
    </script>
@endsection