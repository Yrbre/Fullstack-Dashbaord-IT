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

<body class="vertical  dark  collapsed" data-simplebar>

    <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main role="main" class="main-content">
        <?php echo $__env->make('layouts.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </main> <!-- main -->
    </div> <!-- .wrapper -->

</body>
<script>
    $('#export-data').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You Want Export Data Activity List!",
            icon: "warning",
            theme: "dark",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, export it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Exporting!",
                    text: "Your data is being exported.",
                    icon: "success",
                    theme: "dark",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "/export-task-department";
                });
            }
        });
    });
</script>

</html>
<?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/layouts/template.blade.php ENDPATH**/ ?>