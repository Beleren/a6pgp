@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="panel panel-danger">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Sessão expirada!</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-4 col-md-4 text-center">
                    <img src="{{ asset('img/time-left.png') }}" alt="Imagem de tempo esgotado." class="img-responsive">
                </div>
                <div class="col-sm-8 col-md-8">
                    <p class="lead">
                        Sessão expirada devido a inatividade.
                    </p>
                    <p>
                        Sua sessão expirou porque não houve interação com a página por vários minutos seguidos.
                    </p>
                    <p>
                        Este é um mecanismo para evitar acesso de pessoas não autorizadas à sua conta. Dessa forma,
                        refoçarmos a sua segurança preservando as suas credenciais.
                    </p>
                    <p>
                        Para visualizar a página solicitada, por favor, entre com suas credenciais na página de login.
                    </p>
                    <p>
                        Você será redirecionado para a página inicial em breve.
                    </p>
                    <div class="progress">
                        <div
                                id="contador"
                                class="progress-bar"
                                role="progressbar"
                                aria-valuenow="80"
                                aria-valuemin="0"
                                aria-valuemax="100"
                                style="width: 100%"
                        >
                            100%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            var segundos = 5;

            function atualizarContador() {
                var progresso = 100 * segundos / 5;

                $('#contador')
                    .attr('aria-valuenow', progresso)
                    .text(Math.floor(progresso) + '%')
                    .attr('style', 'width:' + progresso + '%');

                segundos = segundos - 0.1;

                if (segundos <= 0) pararContador();
            }

            var fInterval = setInterval(atualizarContador, 100);

            function pararContador() {
                clearInterval(fInterval);
                window.location.href = "https://cod-besouro.herokuapp.com/login";
            }
        });
    </script>
@endsection