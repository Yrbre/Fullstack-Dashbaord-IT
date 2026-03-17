<?php $__env->startSection('judul', 'DASHBOARD MONITORING'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="mx-auto">
            <div class="row">
                <div class="col-8">

                    <h2 class="page-title justify-content-center"><i class="fe fe-send" style="color:orange"></i>
                        Activity Ready To Take</h2>
                    <div class="">
                        <div class="card shadow">
                            <div class="card-body">
                                <p class="mb-0">Please take the activity that you will do, and make sure to complete
                                    it when you are done.</p>

                                <!-- Div dengan scroll untuk tabel -->
                                <div style="max-height:400px; overflow-y:auto;" data-simplebar>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Activity Name</th>
                                                <th>Schedule Start</th>
                                                <th>Schedule End</th>
                                                <th>Progres</th>
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
                                                    <td><?php echo e($item->progress); ?>%</td>
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

                                    <div style="max-height:400px; overflow-y:auto;"data-simplebar>
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
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary btn-take-activity"
                                                                data-id="<?php echo e($item->id); ?>"
                                                                data-name="<?php echo e($item->name); ?>"
                                                                data-location="<?php echo e($item->location); ?>"
                                                                data-url="<?php echo e(route('dashboard_operator.take', $item->id)); ?>">
                                                                Take
                                                            </button>
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
            <div class="row mx-auto my-4 justify-content-center" data-simplebar>
                <div class="col-12">
                    <h2 class="page-title"> <i class="fe fe-server" style="color:coral"></i> Activity Completed</h2>
                    <div class="card shadow">
                        <div class="card-body">
                            <div style="max-height:400px; overflow-y:auto;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td class="text-center">#</td>
                                            <td class="text-center">Activity Name</td>
                                            <td class="text-center">Progress</td>
                                            <td class="text-center">Status</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $taskCompleted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                                <td class="text-center"><?php echo e($task->name); ?></td>
                                                <td class="text-center"><?php echo e($task->progress); ?>%</td>
                                                <td class="text-center">
                                                    <span class="badge badge-success">Completed</span>
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

    <form id="takeForm" method="POST" style="display:none;">
        <?php echo csrf_field(); ?>
    </form>


    <script>
        function escapeHtml(text) {
            return $('<div>').text(text || '-').html();
        }

        $(document).on('click', '.btn-take-activity', function() {
            var button = $(this);
            var activityName = button.data('name');
            var activityLocation = button.data('location');
            var takeUrl = button.data('url');

            Swal.fire({
                icon: 'question',
                title: 'Confirm Take Activity',
                theme: 'dark',
                html: '<div class="text-center">' +
                    '<p class="mb-2">Are you sure you want to take this activity?</p>' +
                    '<p class="mb-1"><strong>Activity Name:</strong> &nbsp;' + escapeHtml(activityName) +
                    '</p>' +
                    '<p class="mb-0"><strong>Location:</strong> &nbsp;' + escapeHtml(activityLocation) +
                    '</p>' +
                    '</div>',
                showCancelButton: true,
                confirmButtonText: 'Yes, Take Activity',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2f7cf6',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#takeForm').attr('action', takeUrl).trigger('submit');
                }
            });
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

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/dashboard_operator/index.blade.php ENDPATH**/ ?>