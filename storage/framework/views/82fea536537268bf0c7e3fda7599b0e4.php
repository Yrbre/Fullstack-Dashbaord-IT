<?php $__env->startSection('judul', 'Task Department Detail'); ?>
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
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-header border-bottom">
                        <h2 class="title">Member Taken Relation Task</h2>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush my-n3">
                            <?php $__currentLoopData = $takenTask; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-2 col-md-1">
                                            <strong><?php echo e($loop->iteration); ?></strong>
                                        </div>
                                        <div class="col-3 col-md-2">
                                            <img src="<?php echo e($item->user->photo ? Storage::url($item->user->photo) : asset('dark/assets/avatars/face-2.jpg')); ?>"
                                                alt="..." class="rounded-circle" width="40">
                                        </div>
                                        <div class="col">
                                            <strong><?php echo e($item->user->name ?? '-'); ?></strong>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div> <!-- / .card-body -->
                </div> <!-- .card -->
            </div> <!-- .col-md-4 -->

            <!-- Kolom Kanan: Relation Task -->
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="title">Relation Task</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Task ID</td>
                                    <td>Task Name</td>
                                    <td>Assigned To</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $relationTask; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item->id); ?></td>
                                        <td><?php echo e($item->name); ?></td>
                                        <td><?php echo e($item->user->name ?? '-'); ?></td>
                                        <td><?php echo e($item->status); ?></td>
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