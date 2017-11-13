

<?php $__env->startSection('conteudo'); ?>
    <div class="container">
        <?php echo $__env->make('layouts.partials.erros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Contato</h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo e(route('home.salvar-contato')); ?>" method="post"
                      class="form-horizontal">
                    <?php echo e(csrf_field()); ?>


                    <!-- Assunto -->
                    <div class="form-group">
                        <label for="assunto" class="control-label col-sm-2 col-md-2">
                            Assunto:
                        </label>
                        <div class="col-sm-6 col-md-6">
                            <input type="text" name="assunto" id="assunto" class="form-control" value="<?php echo e(old('assunto')); ?>">
                        </div>
                    </div>

                    <?php if(auth()->guest()): ?>
                        <div class="form-group">
                            <label for="email" class="control-label col-sm-2 col-md-2">
                                Seu E-mail:
                            </label>
                            <div class="col-sm-6 col-md-6">
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email')); ?>">
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="email" id="email" value="<?php echo e(auth()->user()->email); ?>">
                    <?php endif; ?>

                    <!-- Tópico -->
                    <div class="form-group">
                        <label for="topico" class="control-label col-sm-2 col-md-2">
                            Tópico
                        </label>
                        <div class="col-sm-6 col-md-6">
                            <select name="topico" id="topico" class="form-control">
                                <option value="sugestao">Sugestão</option>
                                <option value="elogio">Elogio</option>
                                <option value="critica">Crítica</option>
                                <option value="erro">Relatar Erro</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>
                    </div>

                    <!-- Mensagem -->
                    <div class="form-group">
                        <label for="mensagem" class="control-label col-sm-2 col-md-2">
                            Mensagem:
                        </label>
                        <div class="col-sm-6 col-md-6">
                            <textarea name="mensagem" id="mensagem" cols="30" rows="10" class="form-control"><?php echo e(old('mensagem')); ?>

                            </textarea>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6 col-sm-offset-2 col-md-offset-2">
                            <?php if(auth()->guest()): ?>
                                <a href="<?php echo e(url('/')); ?>" class="btn btn-default">Voltar</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-default">Ir para Projetos</a>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>