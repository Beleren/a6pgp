@extends('layouts.app')

@section('conteudo')
    <div class="container">
        @include('layouts.partials.erros')

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Contato</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('home.salvar-contato') }}" method="post"
                      class="form-horizontal">
                    {{ csrf_field() }}

                    <!-- Assunto -->
                    <div class="form-group">
                        <label for="assunto" class="control-label col-sm-2 col-md-2">
                            Assunto:
                        </label>
                        <div class="col-sm-6 col-md-6">
                            <input type="text" name="assunto" id="assunto" class="form-control" value="{{ old('assunto') }}">
                        </div>
                    </div>

                    @if (auth()->guest())
                        <div class="form-group">
                            <label for="email" class="control-label col-sm-2 col-md-2">
                                Seu E-mail:
                            </label>
                            <div class="col-sm-6 col-md-6">
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="email" id="email" value="{{ auth()->user()->email }}">
                    @endif

                    <!-- Tópico -->
                    <div class="form-group">
                        <label for="topico" class="control-label col-sm-2 col-md-2">
                            Tópico
                        </label>
                        <div class="col-sm-6 col-md-6">
                            <select name="topico" id="topico" class="form-control">
                                <option value="sugestao">Sugestão</option>
                                <option value="elogio">Elogio</option>
                                <option value="critica">Crítica</option>
                                <option value="erro">Relatar Erro</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                    </div>

                    <!-- Mensagem -->
                    <div class="form-group">
                        <label for="mensagem" class="control-label col-sm-2 col-md-2">
                            Mensagem:
                        </label>
                        <div class="col-sm-6 col-md-6">
                            <textarea name="mensagem" id="mensagem" cols="30" rows="10" class="form-control">{{ old('mensagem') }}
                            </textarea>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                            @if(auth()->guest())
                                <a href="{{ url('/') }}" class="btn btn-default">Voltar</a>
                            @else
                                <a href="{{ route('home') }}" class="btn btn-default">Ir para Projetos</a>
                            @endif
                            <button type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection