<?php $__env->startSection('judul', 'Activity Department Detail'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">

        <!-- ===== ROW ATAS (FULL 12 COL) ===== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-start">
                            <h2 class="title"><?php echo e($task->name); ?></h2>
                            <span class="badge badge-info ml-4"><?php echo e($task->status); ?></span>
                        </div>
                    </div>
                    <div class="card-body  border-bottom">
                        <div class="row mb-3">
                            <h6 class="subtitle col-6"> <i class="fe fe-user-check"> </i> Lead :
                                <?php echo e($task->user->name ?? '-'); ?></h6>
                            <h6 class="subtitle col-6"> <i class="fe fe-airplay"> </i> Client :
                                <?php echo e($task->enduser->department ?? '-'); ?></h6>
                        </div>
                        <div class="row mb-3">
                            <h6 class="subtitle col-6"> <i class="fe fe-calendar"> </i> Schedule :
                                <?php echo e($task->schedule_start ? \Carbon\Carbon::parse($task->schedule_start)->format('d M Y') : '-'); ?>

                                -
                                <?php echo e($task->schedule_end ? \Carbon\Carbon::parse($task->schedule_end)->format('d M Y') : '-'); ?>

                            </h6>
                            <h6 class="subtitle col-6"> <i class="fe fe-calendar"> </i> Actual :
                                <?php echo e($task->actual_start ? \Carbon\Carbon::parse($task->actual_start)->format('d M Y') : 'Null'); ?>

                                -
                                <?php echo e($task->actual_end ? \Carbon\Carbon::parse($task->actual_end)->format('d M Y') : 'Null'); ?>

                            </h6>
                        </div>
                        <div class="row mb-3">
                            <h6 class="subtitle col-6"> <i class="fe fe-hard-drive"> </i> Total Weight :
                                <?php echo e($weight[$task->id] ?? 0); ?>

                            </h6>
                        </div>
                    </div>
                    <div class="card-body">

                        <label>Description:</label>
                        <p><?php echo e($task->description); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== ROW BAWAH (4 COL + 8 COL) ===== -->
        <div class="row mt-4 g-4">

            <!-- Kolom Kiri: Member -->
            

            <!-- Kolom Kanan: Relation Task -->
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="title">Relation Activity</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Activity ID</td>
                                    <td>Activity Name</td>
                                    <td>Weight</td>
                                    <td>Assigned To</td>
                                    <td>Priority</td>
                                    <td>Progress</td>
                                    <td>Schedule Start/End</td>
                                    <td>Actual Start/End</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $relationTask; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->id); ?></td>
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($item->task_load ?? 0); ?></td>
                                        <td><?php echo e($item->user->name ?? '-'); ?></td>
                                        <td>
                                            <?php if($item->priority === 'CRITICAL'): ?>
                                                <span class="badge badge-danger"><?php echo e($item->priority); ?></span>
                                            <?php elseif($item->priority === 'HIGH'): ?>
                                                <span class="badge badge-warning"><?php echo e($item->priority); ?></span>
                                            <?php elseif($item->priority === 'MEDIUM'): ?>
                                                <span class="badge badge-info"><?php echo e($item->priority); ?></span>
                                            <?php elseif($item->priority === 'LOW'): ?>
                                                <span class="badge badge-secondary"><?php echo e($item->priority); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($item->progress); ?>%</td>
                                        <td><?php echo e($item->schedule_start ? \Carbon\Carbon::parse($item->schedule_start)->format('d M Y H:m:i') : '-'); ?>

                                            -
                                            <?php echo e($item->schedule_end ? \Carbon\Carbon::parse($item->schedule_end)->format('d M Y H:m:i') : '-'); ?>

                                        </td>
                                        <td><?php echo e($item->actual_start ? \Carbon\Carbon::parse($item->actual_start)->format('d M Y H:m:i') : 'Null'); ?>

                                            -
                                            <?php echo e($item->actual_end ? \Carbon\Carbon::parse($item->actual_end)->format('d M Y H:m:i') : 'Null'); ?>

                                        </td>
                                        <td><?php echo e($item->status); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('task_personal.edit', $item->id)); ?>"
                                                class="btn btn-sm btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- .col-md-8 -->

        </div> <!-- .row -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/task/show.blade.php ENDPATH**/ ?>