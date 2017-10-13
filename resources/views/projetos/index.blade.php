@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="secao-botao-voltar col-md-1 col-xs-2">
                <a href="{{ route('projetos.create') }}" class="btn btn-primary">Criar Projeto</a>
            </div>
        </div>
        <table class="table table-striped table-hover tablesorter">
            <thead>
                <tr>
                    <th>Projeto</th>
                    <th>Autoria</th>
                    <th>Criado em</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($projetos as $projeto)
                    <tr>
                        <td>
                            <a href="{{ route('projetos.show', ['id' => $projeto->id]) }}">
                                {{ $projeto->nome }}
                            </a>
                        </td>
                        <td>
                            @if ($projeto->pivot->proprietario)
                                Própria
                            @else
                                Compartilhado
                            @endif
                        </td>
                        <td>
                            {{ $projeto->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <a href="#" class="compartilhar">Compartilhar</a> |
                            <a href="{{ route('projetos.edit', ['id' => $projeto->id]) }}">Editar</a> |
                            <a href="{{ route('projetos.confirmDelete', ['id' => $projeto->id]) }}">Excluir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('layouts.partials.compartilhar-projetos')
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/theme.bootstrap.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/jquery.tablesorter.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tablesorter.widgets.min.js') }}"></script>
    <script src="{{ asset('js/widget-filter.min.js') }}"></script>
    <script>
        $(function() {
            var url;
            var indice;

            $('.compartilhar').click(function(event) {
                event.stopPropagation();

                mostrarCompartilharProjeto($(this));
            });

            $('#botao-compartilhar').click(function(event) {
                event.preventDefault();

                obterUsuarios($('#projeto-usuarios').val())
            });

            function mostrarCompartilharProjeto(botao) {
                url = botao.parent().parent().find('td a').eq(0).attr('href');
                indice = parseInt(url.substr(url.lastIndexOf('/') + 1, url.length));

                var projeto = botao
                    .parent()
                    .parent()
                    .find('td a')
                    .eq(0)
                    .text()
                    .trim()
                ;

                $('#compartilhar-projeto')
                    .modal('show')
                    .find('.modal-body form div.well')
                    .text(projeto)
                ;
            }

            function obterUsuarios(usuarios, event) {
                $('form')
                    .attr('action', '/projetos/' + indice + '/compartilhar')
                    .submit();
            }

            $('#compartilhar-projeto').on('shown.bs.modal', function () {
                $('#projeto-usuarios').focus();
            })
        });
    </script>
    <script src="{{ asset('js/app.tablesorter.config.js') }}"></script>
@endsection