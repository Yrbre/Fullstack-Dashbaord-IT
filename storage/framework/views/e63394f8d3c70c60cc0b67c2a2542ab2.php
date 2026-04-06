<?php $__env->startSection('judul', 'Activity History'); ?>
<?php $__env->startSection('content'); ?>

    <?php if(Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT', 'ADMIN'])): ?>
        <div class="container-fluid">
            <div class="col-12">
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
                                            <th>Activity</th>
                                            <th>Location</th>
                                            <th>Priority</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $__currentLoopData = $activity_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e($item->user->name); ?></td>
                                                <?php if($item->reference_type === 'TASK'): ?>
                                                    <td>ACTIVITY PERSONAL</td>
                                                <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                    <td>ACTIVITY</td>
                                                <?php endif; ?>
                                                <?php if($item->reference_type === 'TASK'): ?>
                                                    <td><?php echo e($item->task->name ?? 'Job Deleted'); ?></td>
                                                <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                    <td><?php echo e($item->activity->name ?? 'Activity Deleted'); ?></td>
                                                <?php else: ?>
                                                    <td>-</td>
                                                <?php endif; ?>

                                                <td>
                                                    <?php echo e($item->location ?? '-'); ?>

                                                </td>
                                                <td>
                                                    <?php if($item->reference_type === 'TASK'): ?>
                                                        <?php if(!$item->task): ?>
                                                            <span class="badge badge-secondary">Job Deleted</span>
                                                        <?php elseif($item->task?->priority === 'CRITICAL'): ?>
                                                            <span
                                                                class="badge badge-danger"><?php echo e($item->task?->priority); ?></span>
                                                        <?php elseif($item->task?->priority === 'HIGH'): ?>
                                                            <span
                                                                class="badge badge-warning"><?php echo e($item->task?->priority); ?></span>
                                                        <?php elseif($item->task?->priority === 'MEDIUM'): ?>
                                                            <span
                                                                class="badge badge-info"><?php echo e($item->task?->priority); ?></span>
                                                        <?php elseif($item->task?->priority === 'LOW'): ?>
                                                            <span
                                                                class="badge badge-secondary"><?php echo e($item->task?->priority); ?></span>
                                                        <?php elseif($item->task?->priority === null): ?>
                                                            <span class="badge badge-secondary">-</span>
                                                        <?php endif; ?>
                                                    <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                        -
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i') : '-'); ?>

                                                </td>
                                                <td><?php echo e($item->end_time ? \Carbon\Carbon::parse($item->end_time)->format('d-m-Y H:i') : '-'); ?>

                                                </td>
                                                <td style="color: greenyellow">
                                                    <?php echo e($item->duration ?? '-'); ?>

                                                </td>
                                                <td><?php echo e($item->status ?? '-'); ?></td>

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
    <?php elseif(Auth::check() && in_array(Auth::user()->role, ['OPERATOR'])): ?>
        <div class="container-fluid">
            <div class="col-12">
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
                                            <th>Activity</th>
                                            <th>Location</th>
                                            <th>Priority</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $__currentLoopData = $activityHistoryOp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e($item->user->name); ?></td>
                                                <?php if($item->reference_type === 'TASK'): ?>
                                                    <td>ACTIVITY PERSONAL</td>
                                                <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                    <td>ACTIVITY</td>
                                                <?php endif; ?>
                                                <?php if($item->reference_type === 'TASK'): ?>
                                                    <td><?php echo e($item->task->name ?? '-'); ?></td>
                                                <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                    <td><?php echo e($item->activity->name ?? '-'); ?></td>
                                                <?php else: ?>
                                                    <td>-</td>
                                                <?php endif; ?>

                                                <td>
                                                    <?php echo e($item->location ?? '-'); ?>

                                                </td>
                                                <td>
                                                    <?php if($item->reference_type === 'TASK'): ?>
                                                        <?php if($item->task->priority === 'CRITICAL'): ?>
                                                            <span
                                                                class="badge badge-danger"><?php echo e($item->task->priority); ?></span>
                                                        <?php elseif($item->task->priority === 'HIGH'): ?>
                                                            <span
                                                                class="badge badge-warning"><?php echo e($item->task->priority); ?></span>
                                                        <?php elseif($item->task->priority === 'MEDIUM'): ?>
                                                            <span
                                                                class="badge badge-info"><?php echo e($item->task->priority); ?></span>
                                                        <?php elseif($item->task->priority === 'LOW'): ?>
                                                            <span
                                                                class="badge badge-secondary"><?php echo e($item->task->priority); ?></span>
                                                        <?php endif; ?>
                                                    <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                        -
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i') : '-'); ?>

                                                </td>
                                                <td><?php echo e($item->end_time ? \Carbon\Carbon::parse($item->end_time)->format('d-m-Y H:i') : '-'); ?>

                                                </td>
                                                <td style="color: greenyellow">
                                                    <?php echo e($item->duration ?? '-'); ?>

                                                </td>
                                                <td><?php echo e($item->status ?? '-'); ?></td>

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
    <?php endif; ?>
    
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