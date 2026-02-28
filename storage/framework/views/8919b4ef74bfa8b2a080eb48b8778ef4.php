<?php $__env->startSection('content'); ?>
    <meta http-equiv="refresh" content="60">
    <h1>Monitoring Dashboard</h1>
    <div class="container-fluid py-4">
        <div class="row mx-auto justify-content-center">
            <div class="col-6">
                <h2 class="page-title"> <i class="fe fe-home" style="color:aqua"> </i> IT Office</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Member Name</td>
                                            <td>Location</td>
                                            <td>Task/Activity</td>
                                            <td>Start Time</td>
                                            <td>Duration</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $standBy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item->user->name); ?></td>
                                                <td><?php echo e($item->location); ?></td>
                                                <td><?php echo e($item->activity->name); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i')); ?></td>
                                                <td style="color:greenyellow">
                                                    <span class="live-duration"
                                                        data-start="<?php echo e(\Carbon\Carbon::parse($item->start_time)->toISOString()); ?>"></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <h2 class="page-title"> <i class="fe fe-radio" style="color:chartreuse"></i> Outside</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Member Name</td>
                                            <td>Location</td>
                                            <td>Task/Activity</td>
                                            <td>Start Time</td>
                                            <td>Duration</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $outSide; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item->user->name); ?></td>
                                                <td><?php echo e($item->location); ?></td>
                                                <?php if($item->reference_type === 'ACTIVITY'): ?>
                                                    <td><?php echo e($item->activity->name); ?></td>
                                                <?php elseif($item->reference_type === 'TASK'): ?>
                                                    <td><?php echo e($item->task->name); ?></td>
                                                <?php else: ?>
                                                    <td> - </td>
                                                <?php endif; ?>
                                                <td><?php echo e(\Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i')); ?></td>
                                                <td style="color:greenyellow">
                                                    <span class="live-duration"
                                                        data-start="<?php echo e(\Carbon\Carbon::parse($item->start_time)->toISOString()); ?>"></span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-auto my-4 justify-content-center">
            <div class="col-12">
                <h2 class="page-title"> <i class="fe fe-server" style="color:coral"></i> Task Progress</h2>
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Task Name</td>
                                    <td>Responsibility</td>
                                    <td>Client</td>
                                    <td>Progress</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $__currentLoopData = $taskProgress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($item->user->name); ?></td>
                                        <td><?php echo e($item->enduser->department ?? '-'); ?></td>
                                        <td><?php echo e($item->progress); ?>%</td>
                                        <td><?php echo e($item->status); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script>
        function formatDuration(seconds) {
            const abs = Math.abs(seconds);
            const isFuture = seconds < 0;
            const days = Math.floor(abs / 86400);
            const hours = Math.floor((abs % 86400) / 3600);
            const minutes = Math.floor((abs % 3600) / 60);


            let parts = [];
            if (days > 0) parts.push(days + 'd');
            if (hours > 0) parts.push(hours + 'h');
            if (minutes > 0) parts.push(minutes + 'm');


            return (isFuture ? 'in ' : '') + parts.join(' ') + (isFuture ? '' : ' ago');
        }

        function updateDurations() {
            document.querySelectorAll('.live-duration').forEach(function(el) {
                const start = new Date(el.dataset.start);
                const now = new Date();
                const diffSeconds = (now - start) / 1000;
                el.textContent = formatDuration(diffSeconds);
            });
        }

        updateDurations();
        setInterval(updateDurations, 1000);
    </script>
    <script>
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/dashboard_management/index.blade.php ENDPATH**/ ?>