

<?php $__env->startSection('conteudo'); ?>
    <div class="container">
        <?php echo $__env->make('layouts.partials.erros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><?php echo e($atividade->nome); ?></h3>
            </div>

            <div class="panel-body">
                <form action="<?php echo e(route('atividades.update', [
                    'projeto' => $projeto->id, 'atividade' => $atividade->id])); ?>"
                    class="form-horizontal" method="post">

                    <?php echo e(method_field('PATCH')); ?>


                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="nome" id="nome" value="<?php echo e($atividade->nome); ?>">

                    <!-- Descrição -->
                    <div class="form-group">
                        <label for="descricao" class="control-label col-sm-2 col-md-2">Descrição:</label>

                        <div class="col-sm-6 col-md-6">
                            <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="10"
                                      readonly="readonly"><?php echo e($atividade->descricao); ?>

                            </textarea>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-md-offset-2 col-sm-6 col-md-6">
                            <a href="<?php echo e(route('atividades.index', ['id' => $projeto->id])); ?>"
                               class="btn btn-default">Voltar</a> |
                            <button type="submit" class="btn btn-primary" disabled="disabled">Alterar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function () {
            $('input[type=text], input[type=number], textarea').dblclick(function() {
                $(this)
                    .attr('readonly', false);
                $('button, bytton[type=submit], input[type=submit]')
                    .attr('disabled', false);
            });

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