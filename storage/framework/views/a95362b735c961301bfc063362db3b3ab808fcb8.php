

<?php $__env->startSection('conteudo'); ?>
    <div class="container">
        <?php echo $__env->make('layouts.partials.erros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <form action="<?php echo e(route('atividades.update', ['projeto' => $projeto->id, 'atividade' => $atividade->id])); ?>"
            class="form-horizontal" method="post">

            <?php echo e(method_field('PATCH')); ?>


            <?php echo e(csrf_field()); ?>


            <!-- Nome -->
            <div class="form-group">
                <label for="nome" class="control-label col-sm-2 col-md-2">Nome:</label>

                <div class="col-sm-6 col-md-6">
                    <input type="text" id="nome" name="nome" class="form-control"
                           value="<?php echo e($atividade->nome); ?>">
                </div>
            </div>

            <!-- Descrição -->
            <div class="form-group">
                <label for="descricao" class="control-label col-sm-2 col-md-2">Descrição:</label>
                <div class="col-sm-6 col-md-6">
                    <textarea name="descricao" id="descricao"
                        cols="30" rows="10" class="form-control"><?php echo e($atividade->descricao); ?>

                    </textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                    <a href="<?php echo e(route('atividades.index', ['id' => $projeto->id])); ?>"
                       class="btn btn-default">Voltar</a> |
                    <button type="submit" class="btn btn-primary">Alterar</button>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function() {
            $('#duracao').change(function() {
                if($(this).val() < 0) {
                    inserirNotificacaoErro($(this));
                } else {
                    removerNotificacaoErro($(this));
                }
            });

            $('#duracao').keyup(function() {
                if($(this).val() < 0) {
                    inserirNotificacaoErro($(this));
                } else {
                    removerNotificacaoErro($(this));
                }
            });

            function inserirNotificacaoErro(elem) {
                $(elem)
                    .attr('data-toggle', 'tooltip')
                    .attr('data-placement', 'top')
                    .attr('title', 'Duração não pode ser negativa!')
                    .parent()
                    .addClass('has-error')
                ;
            }

            function removerNotificacaoErro(elem) {
                $(elem)
                    .removeAttr('data-toggle')
                    .removeAttr('data-placement')
                    .removeAttr('title')
                    .parent()
                    .removeClass('has-error')
                ;
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>