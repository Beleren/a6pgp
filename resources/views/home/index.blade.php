@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div id="area_grafico"></div>
        @include('layouts.partials.carousel')
        <div class="row" id="teste">
            <p>
                O projeto Besouro nasceu como um requerimento da matéria de Práticas de Gerenciamento de Projetos (A6PGP)
                para conclusão do curso de Tecnologia em Análise e Desenvolvimento de Sistemas (TADS) do
                Instituto Federal de São Paulo (IFSP).
            </p>
            <p>
                O objetivo deste projeto é disponibilizar uma aplicação que permita o planejamento de projetos utilizando
                a rede Program Evaluation and Review Technique (PERT) e o Critical Path Method (CPM). As funcionalidades
                disponíveis são:
            </p>
            <ul class="list-group">
                <li class="list-group-item">
                    Programação de atividades
                </li>
                <li class="list-group-item">
                    Construção da rede
                </li>
                <li class="list-group-item">
                    Cálculo de Caminho Crítico
                </li>
                <li class="list-group-item">
                    Importação e Exportação de Projeto em planilhas de Excel.
                </li>
                <li class="list-group-item">
                    Sistema disponível para diversas plataformas via web
                </li>
            </ul>
        </div>
    </div>
@endsection
