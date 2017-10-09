@extends('layouts.app')

@section('conteudo')
    <div class="container">
        <div class="panel panel-danger">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Acesso não Autorizado!</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-4 col-md-4 text-center">
                    <img src="{{ asset('img/denied.png') }}" alt="Insetos dançando" class="img-responsive">
                </div>
                <div class="col-sm-8 col-md-8">
                    <p class="lead">
                        Isto é embaraçoso! Parece que algo deu errado.
                    </p>
                    <p>
                        Você não está autorizado a acessar esta página.
                    </p>
                    <p>
                        Por favor, verifique a página digitada novamente ou suas credenciais de acesso.
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
                window.location.href = "https://cod-besouro.herokuapp.com/";
            }
        });
    </script>
@endsection