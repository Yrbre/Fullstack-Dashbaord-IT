<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo e(asset('dark/assets/images/LogoTifico.png')); ?>">
    <title>Dashboard IT</title>
    <!-- Simple bar CSS -->
    <?php echo $__env->make('layouts.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body class="vertical  dark  collapsed">

    <?php echo $__env->yieldContent('content'); ?>
    <main role="main" class="main-content">
        <?php echo $__env->make('layouts.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </main> <!-- main -->
    </div> <!-- .wrapper -->
</body>

</html>
<?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/layouts/idletemplate.blade.php ENDPATH**/ ?>