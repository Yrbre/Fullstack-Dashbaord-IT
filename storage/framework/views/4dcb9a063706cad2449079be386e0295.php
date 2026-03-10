<?php $__env->startSection('judul', 'DASHBOARD MONITORING'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="mx-auto">
            <div class="row">
                <div class="col-8">
                    <h2>Task Ready To Take</h2>
                    <div class="">
                        <div class="card shadow">
                            <div class="card-body">
                                <p class="mb-0">Please take the task/activity that you will do, and make sure to complete
                                    it when you are done.</p>

                                <!-- Div dengan scroll untuk tabel -->
                                <div style="max-height: 300px; overflow-y: auto; margin-top: 20px;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Task Name</th>
                                                <th>Schedule Start</th>
                                                <th>Schedule End</th>
                                                <th>Location</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $__currentLoopData = $taskReady; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($item->name); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($item->schedule_start)->format('d M Y H:i')); ?>

                                                    </td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($item->schedule_end)->format('d M Y H:i')); ?>

                                                    </td>
                                                    <td><?php echo e($item->location->location ?? '-'); ?></td>
                                                    <td>
                                                        <a href="<?php echo e(route('active_task.index', $item->id)); ?>"
                                                            class="btn btn-sm btn-primary">Take</a>
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
                <div class="col-4">
                    <h2 class="page-title justify-content-center"> <i class="fe fe-list" style="color:aqua"> </i> ACTIVITY
                        LIST
                    </h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center">Activity</td>
                                                <td class="text-center">Location</td>
                                                <td class="text-center">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $activityList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="text-center"><?php echo e($item->name); ?></td>
                                                    <td class="text-center"><?php echo e($item->location); ?></td>
                                                    <td class="text-center">
                                                        <a class="btn btn-sm btn-primary" data-id="<?php echo e($item->id); ?>"
                                                            data-name="<?php echo e($item->name); ?>" href="#"
                                                            data-location="<?php echo e($item->location); ?>" data-toggle="modal"
                                                            data-target="#takeModal"
                                                            data-url="<?php echo e(route('dashboard_operator.take', $item->id)); ?>">
                                                            Take

                                                        </a>
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
        </div>


        <script>
            // Handle take modal
            $('#takeModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var activityName = button.data('name');
                var activityLocation = button.data('location');
                var takeUrl = button.data('url');


                // Update the modal's content
                var modal = $(this);
                modal.find('#activityName').text(activityName);
                modal.find('#activityLocation').text(activityLocation);
                modal.find('#takeForm').attr('action', takeUrl);
            });
        </script>
        <script>
            <?php if(session('success')): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    theme: 'dark',
                    text: '<?php echo e(session('success')); ?>',
                    timer: 2000,
                    showConfirmButton: false,
                });
            <?php endif; ?>
        </script>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('pages.dashboard_operator.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/dashboard_operator/index.blade.php ENDPATH**/ ?>