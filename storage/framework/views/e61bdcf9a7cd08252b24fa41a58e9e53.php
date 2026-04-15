<?php $__env->startSection('judul', 'Absen List'); ?>
<?php $__env->startSection('content'); ?>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Absent At</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $absences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $absence): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($absence->user->name); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($absence->absent_at)->format('d-m-Y')); ?></td>
                    <td><?php echo e($absence->description); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/absen/index.blade.php ENDPATH**/ ?>