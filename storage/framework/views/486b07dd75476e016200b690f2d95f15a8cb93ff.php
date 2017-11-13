<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Sobre a Página -->
    <meta name="description" content="Ferramenta para planejamento de projetos utilizando o mapeamento da rede PERT/CPM.">
    <meta name="keywords" content="PERT, CPM, planejamento, projeto, project">
    <meta name="author" content="Projeto Besouro">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    <?php $__env->startSection('styles'); ?>
    <?php echo $__env->yieldSection(); ?>
</head>
<body>
    <div id="app">
        <?php echo $__env->make('layouts.partials.navegacao', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('layouts.partials.mensagens', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->yieldContent('conteudo'); ?>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <?php $__env->startSection('scripts'); ?>
    <?php echo $__env->yieldSection(); ?>
</body>
</html>
