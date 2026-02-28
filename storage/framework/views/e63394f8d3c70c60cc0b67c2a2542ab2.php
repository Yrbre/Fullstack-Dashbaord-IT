<?php $__env->startSection('menuactivity_history', 'active'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="col-12">
            <h2 class="page-title">Activity History List</h2>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table Activity History</h5>
                            <p class="card-text"></p>
                            <table class="table datatables table-hover" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Member</th>
                                        <th>Reference Type</th>
                                        <th>Do Somegthing</th>
                                        <th>Location</th>
                                        <th>Start Time</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $activity_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->user->name); ?></td>
                                            <td><?php echo e($item->reference_type); ?> - <?php echo e($item->reference_id); ?></td>

                                            <?php if($item->reference_type === 'TASK'): ?>
                                                <td><?php echo e($item->task->name ?? '-'); ?></td>
                                            <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                <td><?php echo e($item->activity->name ?? '-'); ?></td>
                                            <?php else: ?>
                                                <td>-</td>
                                            <?php endif; ?>
                                            <td><?php echo e($item->task->enduser->department ?? '-'); ?> - <?php echo e($item->location ?? '-'); ?>

                                            </td>
                                            <td><?php echo e($item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i') : '-'); ?>

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
    
    <script>
        $('#dataTable-1').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [16, 32, 64, -1],
                [16, 32, 64, "All"]
            ]
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/activity_history/index.blade.php ENDPATH**/ ?>