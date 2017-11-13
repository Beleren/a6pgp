<?php $__env->startSection('conteudo'); ?>
    <div class="container-fluid">
        <div class="col-sm-9 col-md-9">
            <form id="form-dependencias" action="<?php echo e(route('sequencias.store', ['projeto' => $projeto->id])); ?>"
                class="horizontal-form" method="post">

                <?php echo e(csrf_field()); ?>


                <div class="row">
                    <div class="secao-botao-voltar col-md-1 col-xs-2">
                        <a href="<?php echo e(route('atividades.index', ['projeto' => $projeto])); ?>" class="btn btn-default">Voltar</a>
                    </div>
                    <div class="dropdown col-md-1 col-xs-2">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Menu
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo e(route('atividades.index',$projeto->id)); ?>">Atividades</a></li>
                            <li><a href="<?php echo e(route('recursos.index',$projeto->id)); ?>">Recursos</a></li>
                            <li><a href="<?php echo e(route('cenarios.index',$projeto->id)); ?>">Cenários</a></li>
                        </ul>
                    </div>

                    <div class="col-md-2 col-xs-4">
                        <div class="col-md-4 col-xs-6">
                            <button id="btnSalvar" name="btnSalvar" type="button" class="btn btn-primary">
                                Salvar
                            </button>
                        </div>

                    </div>

                    <div class="secao-botao-voltar col-md-4 col-xs-5">
                        <a href="<?php echo e(route('resultado.index', ['projeto' => $projeto->id, 'cenario' => $cenario->id])); ?>" class="btn btn-default">Diagrama</a>
                    </div>

                </div>

                <div class="form-group">
                    <label for="cenario" class="control-label">Cenário:</label>
                    <div>
                        <select id="cenario" name="cenario" class="form-control">
                            <?php $__currentLoopData = $cenarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cenario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cenario->id); ?>"><?php echo e($cenario->nome); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover tablesorter col-sm-8 col-md-8">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Atividades Predecessoras</th>
                        <th>Recursos</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="col-sm-3 col-md-3"><?php echo e($atividade->nome); ?>

                                    <input type="hidden" id="sequencia-<?php echo e($atividade->id); ?>-dependecias"
                                        name="sequencias[<?php echo e($atividade->id); ?>][predecessoras]" value="">
                                    <input type="hidden" id="sequenciador-<?php echo e($atividade->id); ?>-recursos"
                                        name="sequencias[<?php echo e($atividade->id); ?>][recursos]" value="">
                                    <input type="hidden" id="detalhes-<?php echo e($atividade->id); ?>"
                                        name="sequencias[<?php echo e($atividade->id); ?>][detalhes]" value='{}'>
                                </td>
                                <td class="col-sm-5 col-md-5">
                                    <ul class="dependencias list-group">
                                        <?php $__empty_1 = true; $__currentLoopData = $sequencias->where('atividade_id', $atividade->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sequencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <li class="list-group-item atividades"
                                                data-atividade-id="<?php echo e($sequencia->atividadePredecessora['id']); ?>">
                                                <?php echo e($sequencia->atividadePredecessora['nome']); ?>

                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <span></span>
                                        <?php endif; ?>
                                    </ul>
                                </td>
                                <td class="col-sm-4 col-md-4">
                                    <ul class="dependencias-recursos list-group">
                                        <?php $__empty_1 = true; $__currentLoopData = $sequencias->where('atividade_id', $atividade->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sequencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <li class="list-group-item recursos"
                                                data-recurso-id="<?php echo e($sequencia->recurso['id']); ?>">
                                                <?php echo e($sequencia->recurso['nome']); ?>

                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <span></span>
                                        <?php endif; ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </form>
        </div>

        <?php echo $__env->make('layouts.partials.sequencia-gestao-recursos', [
            'atividades' => $atividades,
            'recursos' => $recursos,
        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('layouts.partials.sequencia-detalhes', [
            'projeto' => $projeto,
            'atividade' => $atividade,
        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('layouts.partials.detalhes-recursos', [
            'projeto' => $projeto,
            'atividade' => $atividade,
        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/jquery-ui.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/theme.bootstrap.css')); ?>">
    <style>
        ul.dependencias,
        ul.dependencias-recursos {
            display: block;
            width: 99.5%;
            height: 2em;
            margin: 0;
            padding: 0;
        }

        ul.dependencias li,
        ul.dependencias-recursos li {
            display: inline;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('js/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.tablesorter.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.tablesorter.widgets.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/widget-filter.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/validacao-sequencias.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>