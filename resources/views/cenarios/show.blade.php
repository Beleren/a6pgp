@extends('layouts.app')

@section('conteudo')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>{{ $cenario->nome }}</h3>
            </div>

            <div class="panel-body">
                <form action="{{ route('cenarios.update', ['projeto' => $cenario->projeto->id, 'cenario' => $cenario->id]) }}"
                    class="form-horizontal" method="post">

                    {{ method_field('PATCH') }}

                    {{ csrf_field() }}

                    <!-- Data de Criação -->
                    <div class="form-group">
                        <label for="data_criacao" class="control-label col-sm-2 col-md-2">@lang('paginas.cenarios.data-criacao')</label>

                        <div class="col-sm-6 col-md-6">
                            <input type="text" id="data_criacao" name="data_criacao"
                               class="form-control"
                               @if(app()->getLocale() !== 'en')
                               value="{{ $cenario->created_at->format('d/m/Y') }}"
                               @else
                               value="{{ $cenario->created_at->format('m/d/Y') }}"
                               @endif
                               readonly="readonly">
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="form-group">
                        <label for="descricao" class="control-label col-sm-2 col-md-2">@lang('paginas.descricao')</label>

                        <div class="col-sm-6 col-md-6">
                            <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="10"
                                readonly="readonly">{{ $cenario->descricao }}
                            </textarea>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                            <a href="{{ route('cenarios.index', ['id' => $cenario->projeto->id]) }}" class="btn btn-default">@lang('paginas.voltar')</a> |
                            <button type="submit" class="btn btn-primary" disabled="disabled">@lang('paginas.alterar')</button>
                            <div class="pull-right">
                                <a href="{{ route('sequencias.index', [
                                    'projeto' => $projeto, 'cenario' => $cenario->id
                                    ]) }}" class="btn btn-default">
                                    @lang('paginas.cenarios.visualizar-sequencias')
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('input[type=text], input[type=number], textarea').dblclick(function() {
                $(this)
                    .attr('readonly', false);
                $('button, button[type=submit], input[type=submit]')
                    .attr('disabled', false);
            });
        })
    </script>
@endsection