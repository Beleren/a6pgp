

<?php $__env->startSection('conteudo'); ?>
    <div class="container">
        <div class="row">
            <div class="secao-botao-voltar col-sm-1">
                <a href="<?php echo e(route('projetos.index')); ?>" class="btn btn-default">Voltar</a>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a class="btn btn-link btn-block" role="button"
                        data-toggle="collapse" href="#detalhes"
                        aria-expanded="false" aria-controls="detalhes"
                    >
                        <?php echo e($projeto->nome); ?>

                    </a>
                </h3>
            </div>
            <div class="panel-body collapse" id="detalhes">
                <div class="col-sm-6  col-md-6">
                    <h4>Descrição</h4>
                    <textarea name="descricao" id="descricao" class="form-control" cols="30" rows="6"
                      readonly="readonly"><?php echo e($projeto->descricao); ?>

                    </textarea>
                </div>
            </div>
        </div>

        <!-- Atividades -->
        <div class="col-sm-4 col-md-4">
            <ul class="list-group">
                <li class="list-group-item active">
                    <strong>
                        <a href="<?php echo e(route('atividades.index', [
                            'projeto' => $projeto->id])); ?>"
                            class="btn btn-link"
                            title="Clique aqui para visualizar mais atividades."
                            data-toggle="tooltip"
                            data-placement="top"
                        >
                            Atividades
                        </a>
                        <span class="badge"><?php echo e($projeto->atividades->count()); ?></span>
                    </strong>
                    <a class="btn btn-primary adicionar"
                        href="<?php echo e(route('atividades.create', [
                        'projeto' => $projeto->id])); ?>"
                    >
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </li>
                <?php $__currentLoopData = $projeto->atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item">
                        <a href="<?php echo e(route('atividades.show', [
                            'projeto' => $projeto->id,
                            'atividade' => $atividade->id,
                        ])); ?>" class="btn btn-link">
                            <?php echo e($atividade->nome); ?>

                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <!-- Recursos -->
        <div class="col-sm-4 col-md-4">
            <ul class="list-group">
                <li class="list-group-item active">
                    <strong>
                        <a href="<?php echo e(route('recursos.index', [
                            'projeto' => $projeto->id])); ?>"
                            class="btn btn-link"
                            title="Clique aqui para visualizar mais recursos."
                            data-toggle="tooltip"
                            data-placement="top"
                        >
                            Recursos
                        </a>
                        <span class="badge"><?php echo e($projeto->recursos->count()); ?></span>
                    </strong>
                    <a class="btn btn-primary adicionar"
                        href="<?php echo e(route('recursos.create', [
                        'projeto' => $projeto->id])); ?>">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </li>
                <?php $__currentLoopData = $projeto->recursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item">
                        <a href="<?php echo e(route('recursos.edit', [
                            'projeto' => $projeto->id,
                        '   $recurso' => $recurso->id,
                            ])); ?>" class="btn btn-link"
                        >
                            <?php echo e($recurso->nome); ?>

                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <!-- Cenários -->
        <div class="col-sm-4 col-md-4">
            <ul class="list-group">
                <li class="list-group-item active">
                    <strong>
                        <a href="<?php echo e(route('cenarios.index', [
                            'projeto' => $projeto->id])); ?>"
                            class="btn btn-link"
                            title="Clique aqui para visualizar mais atividades."
                            data-toggle="tooltip"
                            data-placement="top"
                        >
                            Cenários
                        </a>
                        <span class="badge"><?php echo e($projeto->cenarios->count()); ?></span>
                    </strong>
                    <a class="btn btn-primary adicionar"
                        href="<?php echo e(route('cenarios.create', [
                        'projeto' => $projeto->id])); ?>">
                        <span class="glyphicon glyphicon-plus"></span>
                    </a>
                </li>
                <?php $__currentLoopData = $projeto->cenarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cenario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item">
                        <a href="<?php echo e(route('cenarios.edit', [
                            'projeto' => $projeto->id,
                            'cenario' => $cenario->id,
                        ])); ?>" class="btn btn-link">
                            <?php echo e($cenario->nome); ?>

                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
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

            $('.list-group-item:not(.active) a')
                .parent()
                .click(function(event) {
                    window.location.href = $(this).find('a').attr('href');
                })
            ;
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>