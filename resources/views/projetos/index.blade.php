@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="secao-botao-voltar col-md-1 col-xs-2">
                <a href="{{ route('projetos.create') }}" class="btn btn-primary">@lang('paginas.projetos.index.botoes.criar')</a>
            </div>
        </div>
        <table class="table table-striped table-hover tablesorter">
            <thead>
                <tr>
                    <th>@lang('paginas.tabelas.projeto')</th>
                    <th>@lang('paginas.tabelas.autoria')</th>
                    <th>@lang('paginas.tabelas.criado-em')</th>
                    <th>@lang('paginas.tabelas.acoes')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projetos as $p)
                    <tr>
                        <td>
                            <a href="{{ route('projetos.show', ['id' => $p->id]) }}">
                                {{ $p->nome }}
                            </a>
                        </td>
                        <td>
                            @if ($p->pivot->proprietario)
                                Própria
                            @else
                                Compartilhado
                            @endif
                        </td>
                        <td>
                            @if(! app()->getLocale('en'))
                            {{ $p->created_at->format('d/m/Y') }}
                            @else
                            {{ $p->created_at->format('m/d/Y') }}
                            @endif
                        </td>
                        <td>
                            <a href="#" class="compartilhar">@lang('paginas.projetos.index.botoes.compartilhar')</a> |
                            <a href="{{ route('projetos.edit', ['id' => $p->id]) }}">@lang('paginas.projetos.index.botoes.editar')</a> |
                            <a href="{{ route('projetos.confirmDelete', ['id' => $p->id]) }}">@lang('paginas.projetos.index.botoes.excluir')</a>
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