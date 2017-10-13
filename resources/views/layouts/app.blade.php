<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Sobre a Página -->
    <meta name="description" content="Ferramenta para planejamento de projetos utilizando o mapeamento da rede PERT/CPM.">
    <meta name="keywords" content="PERT, CPM, planejamento, projeto, project">
    <meta name="author" content="Projeto Besouro">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @section('styles')
    @show
</head>
<body>
    <div id="app">
        @include('layouts.partials.navegacao')
        @include('layouts.partials.mensagens')
        @yield('conteudo')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/viz.js') }}"></script>
    @section('scripts')
    @show
</body>
</html>
