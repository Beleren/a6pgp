

<?php $__env->startSection('conteudo'); ?>
    <div class="container">
            <div class="row">
                <div class="secao-botao-voltar col-md-1 col-xs-2">
                    <a href="<?php echo e(route('projetos.show', ['projeto' => $projeto->id])); ?>" class="btn btn-default">Voltar</a>
                </div>
                <div class="dropdown col-md-1 col-xs-2">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Menu
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo e(route('cenarios.index',$projeto->id)); ?>">Cenários</a></li>
                        <li><a href="<?php echo e(route('recursos.index',$projeto->id)); ?>">Recursos</a></li>
                    </ul>
                </div>

                <div class="col-md-5 col-xs-7">
                    <div class="col-md-4 col-xs-6">
                        <a href="<?php echo e(route('atividades.create', ['projeto' => $projeto->id])); ?>"
                           class="btn btn-primary">
                            Criar Atividade
                        </a>
                    </div>
                    <div class="col-md-1 col-xs-1">

                        <a href="<?php echo e(route('sequencias.index', [
                            'projeto' => $projeto->id,
                            'cenario' => $projeto->cenarios->first()
                        ])); ?>"
                           class="btn btn-default">
                            Gerenciar Sequência
                        </a>
                    </div>

                </div>

            </div>
        <table class="table table-striped table-hover tablesorter">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <a href="<?php echo e(route('atividades.show', [
                                'atividade' => $atividade->id,
                                'projeto' => $projeto->id])); ?>">
                                <?php echo e($atividade->nome); ?>

                            </a>
                        </td>
                        <td><?php echo e($atividade->descricao); ?></td>
                        <td><?php echo e($atividade->created_at->format('d/m/Y')); ?></td>
                        <td>
                            <a href="<?php echo e(route('atividades.edit', ['atividade' => $atividade->id, 'projeto' => $projeto->id ])); ?>">Editar</a> |
                            <a href="<?php echo e(route('atividades.confirm-delete', ['atividade' => $atividade->id, 'projeto' => $projeto->id ])); ?>">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td>
                            Não há atividades cadastradas.
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/theme.bootstrap.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/jquery.tablesorter.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.tablesorter.widgets.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/widget-filter.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/app.tablesorter.config.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>