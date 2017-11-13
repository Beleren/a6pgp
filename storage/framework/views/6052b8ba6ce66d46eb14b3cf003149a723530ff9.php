<?php if(Session::has('success')): ?>
    <div class="container">
        <div class="alert alert-success alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <?php echo e(Session::get('success')); ?>

        </div>
    </div>
<?php elseif(Session::has('info')): ?>
    <div class="container">
        <div class="alert alert-info alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <?php echo e(Session::get('info')); ?>

        </div>
    </div>
<?php elseif(Session::has('warning')): ?>
    <div class="container">
        <div class="alert alert-warning alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <?php echo e(Session::get('warning')); ?>

        </div>
    </div>
<?php elseif(Session::has('danger')): ?>
    <div class="container">
        <div class="alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            <?php echo e(Session::get('danger')); ?>

        </div>
    </div>
<?php else: ?>
<?php endif; ?>