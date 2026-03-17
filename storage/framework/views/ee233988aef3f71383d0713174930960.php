<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <p>Job Assignment: <?php echo e($data->name); ?></p>
    <p>Priority: <?php echo e($data->priority); ?></p>
    <p>Schedule (Start/End): <?php echo e(\Carbon\Carbon::parse($data->schedule_start)->format('d M Y H:i')); ?> -
        <?php echo e(\Carbon\Carbon::parse($data->schedule_end)->format('d M Y H:i')); ?></p>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/mails/create.blade.php ENDPATH**/ ?>