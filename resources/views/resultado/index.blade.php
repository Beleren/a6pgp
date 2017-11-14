@extends('layouts.app')

@section('conteudo')
    <div class="container-fluid">
        {{$diagrama}}
    </div>
@endsection

@section('scripts')

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
        var x = {!! $diagrama !!};
        image = Viz("digraph g { node [shape=record];\n" +
            "\"A\" [label = \"{0 | 0} |{Escavaçãoooooooooo|2}| {2|2}\"]\"Fundação\" [label = \"{2 | 6 } | {Fundação|4}| {6|6}\"]\n" +
            "\"Parede\" [label = \"{6|6} | {Parede|10} | {16|16}\"]\n" +
            "\"Telhado\" [label = \"{16 |20 } | {Telhado | 6} | {22 | 26}\"]\n" +
            "\"Enc Exterior\" [label = \"{16 |16 } | {Enc Exterior | 4} | {20 | 20}\"]\n" +
            "\"Enc Interior\" [label = \"{20 | 20} | {Enc Interiorrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr | 5} | {25 |25 }\"]\n" +
            "\"Muros\" [label = \"{ 22 |26 } | {Muros | 7} | {25 |33 }\"]\n" +
            "\"Pintura Ext\" [label = \"{29 |33 } | {Pintura Ext | 9} | {38 |42 }\"]\n" +
            "\"Inst Elétrica\" [label = \"{16 |18 } | {Inst Elétrica | 7} | {23 |25 }\"]\n" +
            "\"Divisórias\" [label = \"{25 |25 } | {Divisórias | 8} | {33 |33 }\"]\n" +
            "\"Piso\" [label = \"{33 |34 } | {Piso | 4} | {37 |38 }\"]\n" +
            "\"Pintura Int\" [label = \"{33 |33 } | {Pintura Int | 5} | {38 | 38}\"]\n" +
            "\"Acabamento Ext\" [label = \"{38 |42 } | {Acabamento Ext | 2} | {40 |44 }\"]\n" +
            "\"Acabamento Int\" [label = \"{ 38 |38 } | {Acabamanto Int | 6} | {44 |44 }\"]\n" +

            "Inicio ->\"A\" [color=\"red\"]\n\"A\" ->\"Fundação\" [color=\"red\"]\n" +
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

        document.body.appendChild(x);
    </script>
@endsection