

<?php $__env->startSection('conteudo'); ?>
    <div class="container">
        <div class="panel panel-danger">
            <div class="panel-heading text-center">
                <h3 class="panel-title">Ação não Autorizada!</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-4 col-md-4 text-center">
                    <img src="<?php echo e(asset('img/denied.png')); ?>" alt="Insetos dançando" class="img-responsive">
                </div>
                <div class="col-sm-8 col-md-8">
                    <p class="lead">
                        Infelizmente não podemos realizar esta ação.
                    </p>
                    <p>
                        Você não está autorizado a executar esta ação.
                    </p>
                    <p>
                        Por favor, verifique novamente a ação que deseja fazer porque não é possível
                        realizá-la.
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
    <div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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

                window.location.href =
                "<?php echo e(request()->session('_previous')->get('_previous')['url'] or 'https://cod-besouro.herokuapp.com/projetos'); ?>"
                ;
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>