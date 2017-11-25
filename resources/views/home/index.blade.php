@extends('layouts.app')
@section('styles')
    <style>
        .navbar{
            margin-bottom: 0px;
        }
    </style>
@endsection
@section('conteudo')
    @include('layouts.partials.carousel')
    <div class="container">
        <div class="row" id="teste">
            <p>
                @lang('paginas.home.como-nasceu')
            </p>
            <p>
                @lang('paginas.home.objetivo-projeto')
            </p>
            <ul class="list-group">
                <li class="list-group-item">
                    @lang('paginas.home.programacao-atividades')
                </li>
                <li class="list-group-item">
                    @lang('paginas.home.construcao-rede')
                </li>
                <li class="list-group-item">
                    @lang('paginas.home.caminho-critico')
                </li>
                <li class="list-group-item">
                    @lang('paginas.home.importacao-exportacao-excel')
                </li>
                <li class="list-group-item">
                    @lang('paginas.home.disponivel-via-web')
                </li>
            </ul>
        </div>
    </div>
@endsection
