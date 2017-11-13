

<?php $__env->startSection('conteudo'); ?>
    <div class="container">
        <div class="row">
            <div class="secao-botao-voltar col-md-1 col-xs-2">
                <a href="<?php echo e(route('projetos.create')); ?>" class="btn btn-primary">Criar Projeto</a>
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
                <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projeto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('projetos.show', ['id' => $projeto->id])); ?>">
                                <?php echo e($projeto->nome); ?>

                            </a>
                        </td>
                        <td>
                            <?php if($projeto->pivot->proprietario): ?>
                                Própria
                            <?php else: ?>
                                Compartilhado
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo e($projeto->created_at->format('d/m/Y')); ?>

                        </td>
                        <td>
                            <a href="#" class="compartilhar">Compartilhar</a> |
                            <a href="<?php echo e(route('projetos.edit', ['id' => $projeto->id])); ?>">Editar</a> |
                            <a href="<?php echo e(route('projetos.confirmDelete', ['id' => $projeto->id])); ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <?php echo $__env->make('layouts.partials.compartilhar-projetos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/theme.bootstrap.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/jquery.tablesorter.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.tablesorter.widgets.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/widget-filter.min.js')); ?>"></script>
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
    <script src="<?php echo e(asset('js/app.tablesorter.config.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>