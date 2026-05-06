<?php $__env->startSection('judul', 'DEPARTMENT ACTIVITY MONITORING'); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .link-black {
            color: inherit !important;
            text-decoration: none !important;
        }

        .dashboard-table {
            min-width: 640px;
        }


        @media (max-width: 767.98px) {
            .page-title {
                font-size: 1.1rem;
            }

            .dashboard-card-body {
                padding: 0.75rem;
            }

            .progress-label-mobile {
                display: none;
            }
        }
    </style>
    
    <div class="container-fluid py-4">
        <div class="custom-control custom-checkbox d-flex justify-content-end">
            <input type="checkbox" class="custom-control-input" id="autoRefresh" checked>
            <label class="custom-control-label" for="autoRefresh">Auto Refresh</label>
            <span id="countdownDisplay" class="text-muted small ms-2"></span>
        </div>
        <div class="row mx-auto justify-content-center g-3">
            <div class="col-12 col-xl-6">
                <h2 class="page-title"> <i class="fe fe-home" style="color:aqua"> </i> IT Office</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body dashboard-card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover dashboard-table">
                                        <thead>
                                            <tr>
                                                <td>Member Name</td>
                                                <td>Activity</td>
                                                <td>Start Time</td>
                                                <td>Duration</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $standBy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(
                                                    $item->reference_type === 'ACTIVITY' &&
                                                        (int) optional($item->activity)->id === 1 &&
                                                        \Carbon\Carbon::parse($item->start_time)->diffInMinutes(now()) > 5): ?>
                                                    <tr style="color: yellow">
                                                        <td><a class="link-black"
                                                                href="<?php echo e(route('activity_history.list', $item->user->id)); ?>"><?php echo e($item->user->name); ?></a>
                                                        </td>
                                                        <?php if($item->reference_type === 'ACTIVITY'): ?>
                                                            <td><?php echo e($item->activity->name); ?></td>
                                                        <?php elseif($item->reference_type === 'TASK'): ?>
                                                            <td><?php echo e($item->task->name); ?></td>
                                                        <?php elseif($item->reference_type === 'JOB'): ?>
                                                            <td> <?php echo e($item->description ?? 'No description available'); ?>

                                                            </td>
                                                        <?php else: ?>
                                                            <td> - </td>
                                                        <?php endif; ?>
                                                        <td><?php echo e(\Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i')); ?>

                                                        </td>
                                                        <td style="color:greenyellow">
                                                            <span class="live-duration"
                                                                data-start="<?php echo e(\Carbon\Carbon::parse($item->start_time)->toISOString()); ?>"></span>
                                                        </td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr>
                                                        <td><a class="link-black"
                                                                href="<?php echo e(route('activity_history.list', $item->user->id)); ?>"><?php echo e($item->user->name); ?></a>
                                                        </td>
                                                        <?php if($item->reference_type === 'ACTIVITY'): ?>
                                                            <td><?php echo e($item->activity->name); ?></td>
                                                        <?php elseif($item->reference_type === 'TASK'): ?>
                                                            <td><?php echo e($item->task->name); ?></td>
                                                        <?php elseif($item->reference_type === 'JOB'): ?>
                                                            <td> <?php echo e($item->description ?? 'No description available'); ?>

                                                            </td>
                                                        <?php else: ?>
                                                            <td> - </td>
                                                        <?php endif; ?>
                                                        <td><?php echo e(\Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i')); ?>

                                                        </td>
                                                        <td style="color:greenyellow">
                                                            <span class="live-duration"
                                                                data-start="<?php echo e(\Carbon\Carbon::parse($item->start_time)->toISOString()); ?>"></span>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <h2 class="page-title"> <i class="fe fe-radio" style="color:chartreuse"></i> Outside</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body dashboard-card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover dashboard-table mb-0">
                                        <thead>
                                            <tr>
                                                <td>Member Name</td>
                                                <td>Location</td>
                                                <td>Activity</td>
                                                <td>Start Time</td>
                                                <td>Duration</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $outSide; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(in_array($item->reference_id, ['9', '8'])): ?>
                                                    <tr class="text-warning">
                                                        <td><a class="link-black"
                                                                href="<?php echo e(route('activity_history.list', $item->user->id)); ?>"><?php echo e($item->user->name); ?></a>
                                                        </td>
                                                        <td><?php echo e($item->location); ?></td>
                                                        <?php if(in_array($item->reference_id, ['9', '8'])): ?>
                                                            <td><?php echo e($item->description ?? '-'); ?></td>
                                                        <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                            <td><?php echo e($item->activity->name); ?></td>
                                                        <?php elseif($item->reference_type === 'TASK'): ?>
                                                            <td><?php echo e($item->task->name); ?></td>
                                                        <?php else: ?>
                                                            <td> - </td>
                                                        <?php endif; ?>
                                                        <td><?php echo e(\Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i')); ?>

                                                        </td>
                                                        <td style="color:greenyellow">
                                                            <span class="live-duration"
                                                                data-start="<?php echo e(\Carbon\Carbon::parse($item->start_time)->toISOString()); ?>"></span>
                                                        </td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr>
                                                        <td><a class="link-black"
                                                                href="<?php echo e(route('activity_history.list', $item->user->id)); ?>"><?php echo e($item->user->name); ?></a>
                                                        </td>
                                                        <td><?php echo e($item->location); ?></td>
                                                        <?php if(in_array($item->reference_id, ['9', '8'])): ?>
                                                            <td><?php echo e($item->description ?? '-'); ?></td>
                                                        <?php elseif($item->reference_type === 'ACTIVITY'): ?>
                                                            <td><?php echo e($item->activity->name); ?></td>
                                                        <?php elseif($item->reference_type === 'TASK'): ?>
                                                            <td><?php echo e($item->task->name); ?></td>
                                                        <?php else: ?>
                                                            <td> - </td>
                                                        <?php endif; ?>
                                                        <td><?php echo e(\Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i')); ?>

                                                        </td>
                                                        <td style="color:greenyellow">
                                                            <span class="live-duration"
                                                                data-start="<?php echo e(\Carbon\Carbon::parse($item->start_time)->toISOString()); ?>"></span>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
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
        <div class="row mx-auto my-4 justify-content-end">
            <div class="col-6">
                <h2 class="page-title"> <i class="fe fe-phone-off" style="color:rgb(255, 0, 0)"></i> Absent Today</h2>
                <div class="card shadow">
                    <div class="card-body dashboard-card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Name</td>
                                        <td>Date</td>
                                        <td>Description</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $absences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td class="text-danger"><?php echo e($item->user->name); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($item->absent_at)->format('d M Y')); ?></td>
                                            <td class="text-danger"><?php echo e($item->description ?? '-'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No absences today.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-auto my-4 justify-content-center">
            <div class="col-12">
                <h2 class="page-title"> <i class="fe fe-server" style="color:coral"></i> Activity Progress</h2>
                <div class="card shadow">
                    <div class="card-body dashboard-card-body">
                        <div class="table-responsive">
                            <table class="table table-hover datatables" id="dataTable-activity-progress">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Activity Name</td>
                                        <td>Responsibility</td>
                                        <td>Category</td>
                                        <td>Client</td>
                                        <td>Priority</td>
                                        <td class="text-center">Progress</td>
                                        <td class="text-center">Status</td>
                                        <td class="text-center">Action</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $taskProgress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->name); ?></td>
                                            <td><?php echo e($item->user->name); ?></td>
                                            <td><?php echo e($item->category->name ?? '-'); ?></td>
                                            <td><?php echo e($item->enduser->department ?? '-'); ?></td>
                                            <?php if($item->priority === 'CRITICAL'): ?>
                                                <td><span class="badge badge-danger"><?php echo e($item->priority); ?></span></td>
                                            <?php elseif($item->priority === 'HIGH'): ?>
                                                <td><span class="badge badge-warning"><?php echo e($item->priority); ?></span></td>
                                            <?php elseif($item->priority === 'MEDIUM'): ?>
                                                <td><span class="badge badge-info"><?php echo e($item->priority); ?></span></td>
                                            <?php elseif($item->priority === 'LOW'): ?>
                                                <td><span class="badge badge-secondary"><?php echo e($item->priority); ?></span></td>
                                            <?php endif; ?>
                                            <td>
                                                <?php if(($weight[$item->id] ?? 0) > 100): ?>
                                                    <h6 class="text-center text-danger">
                                                        Activity Weight Overload <span
                                                            class="badge badge-danger"><?php echo e($weight[$item->id] ?? 0); ?>%</span>
                                                    </h6>
                                                <?php elseif(($weight[$item->id] ?? 0) <= 100): ?>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress flex-grow-1 position-relative"
                                                            style="height: 20px;">
                                                            <div class="progress-bar <?php echo e($item->progress_color); ?>"
                                                                role="progressbar" style="width: <?php echo e($item->progress); ?>%;"
                                                                aria-valuenow="<?php echo e($item->progress); ?>" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                            <span class="position-absolute w-100 text-center fw-bold"
                                                                style="top: 0; left: 0; line-height: 20px; font-size: 12px; color: #fff; text-shadow: 0 0 3px rgba(0,0,0,0.7);">
                                                                <?php echo e($item->progress); ?>%
                                                            </span>
                                                        </div>
                                                        <small
                                                            class="ms-2 text-muted progress-label-mobile"><?php echo e($item->progress_label); ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center"><?php echo e($item->status); ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="<?php echo e(route('task.show', $item->id)); ?>"
                                                    class="btn btn-sm btn-primary">View</a>
                                                <?php if((int) $item->progress === 100): ?>
                                                    <form action="<?php echo e(route('task.complete', $item->id)); ?>" method="POST"
                                                        class="d-inline-block mt-1 mt-sm-0"
                                                        onsubmit="return confirmComplete(event)">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success">Completed?</button>
                                                    </form>
                                                <?php endif; ?>
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

        <div class="row mx-auto my-4 justify-content-center">
            <div class="col-12">
                <h2 class="page-title"> <i class="fe fe-check-square" style="color:rgb(95, 255, 95)"></i> Activity
                    Completed
                </h2>
                <div class="card shadow">
                    <div class="card-body dashboard-card-body">
                        <div class="table-responsive">
                            <table class="table table-hover datatables" id="dataTable-activity-completed">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td>Activity Name</td>
                                        <td>Responsibility</td>
                                        <td>Category</td>
                                        <td>Client</td>
                                        <td>Priority</td>
                                        <td class="text-center">Progress</td>
                                        <td class="text-center">Status</td>
                                        <td class="text-center">Action</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $taskCompleted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->name); ?></td>
                                            <td><?php echo e($item->user->name); ?></td>
                                            <td><?php echo e($item->category->name ?? '-'); ?></td>
                                            <td><?php echo e($item->enduser->department ?? '-'); ?></td>
                                            <?php if($item->priority === 'CRITICAL'): ?>
                                                <td><span class="badge badge-danger"><?php echo e($item->priority); ?></span></td>
                                            <?php elseif($item->priority === 'HIGH'): ?>
                                                <td><span class="badge badge-warning"><?php echo e($item->priority); ?></span></td>
                                            <?php elseif($item->priority === 'MEDIUM'): ?>
                                                <td><span class="badge badge-info"><?php echo e($item->priority); ?></span></td>
                                            <?php elseif($item->priority === 'LOW'): ?>
                                                <td><span class="badge badge-secondary"><?php echo e($item->priority); ?></span></td>
                                            <?php endif; ?>
                                            <td>
                                                <?php if(($weight[$item->id] ?? 0) > 100): ?>
                                                    <h6 class="text-center text-danger">
                                                        Activity Weight Overload <span
                                                            class="badge badge-danger"><?php echo e($weight[$item->id] ?? 0); ?>%</span>
                                                    </h6>
                                                <?php elseif(($weight[$item->id] ?? 0) <= 100): ?>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress flex-grow-1 position-relative"
                                                            style="height: 20px;">
                                                            <div class="progress-bar <?php echo e($item->progress_color); ?>"
                                                                role="progressbar" style="width: <?php echo e($item->progress); ?>%;"
                                                                aria-valuenow="<?php echo e($item->progress); ?>" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                            <span class="position-absolute w-100 text-center fw-bold"
                                                                style="top: 0; left: 0; line-height: 20px; font-size: 12px; color: #fff; text-shadow: 0 0 3px rgba(0,0,0,0.7);">
                                                                <?php echo e($item->progress); ?>%
                                                            </span>
                                                        </div>
                                                        <small
                                                            class="ms-2 text-muted progress-label-mobile"><?php echo e($item->progress_label); ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center"><?php echo e($item->status); ?></td>
                                            <td class="text-center text-nowrap">
                                                <a href="<?php echo e(route('task.show', $item->id)); ?>"
                                                    class="btn btn-sm btn-primary">View</a>
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
    <script>
        function confirmComplete(event) {
            event.preventDefault();
            const form = event.target;
            Swal.fire({
                icon: 'question',
                title: 'Mark as Completed?',
                text: 'Are you sure you want to mark this Activity as completed?',
                theme: 'dark',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Yes, Complete',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }
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
    <script>
        $('#dataTable-activity-progress').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"]
            ],
            order: [0, 'asc'],
        });
    </script>
    <script>
        $('#dataTable-activity-completed').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "All"]
            ],
            order: [0, 'asc'],
        });
    </script>

    <script>
        const toggle = document.getElementById('autoRefresh');
        const countdownDisplay = document.getElementById('countdownDisplay');
        let refreshTimer = null;
        let countdownTimer = null;
        let seconds = 30;

        function startCountdown() {
            seconds = 30;
            countdownDisplay.textContent = '(' + seconds + 's)';

            countdownTimer = setInterval(() => {
                seconds--;
                countdownDisplay.textContent = '(' + seconds + 's)';

                if (seconds <= 0) {
                    seconds = 30;
                }
            }, 1000);
        }

        function stopCountdown() {
            clearInterval(countdownTimer);
            countdownTimer = null;
            countdownDisplay.textContent = '';
        }

        function startRefresh() {
            refreshTimer = setInterval(() => {
                window.location.reload();
            }, 30000);
            startCountdown();
        }

        function stopRefresh() {
            clearInterval(refreshTimer);
            refreshTimer = null;
            stopCountdown();
        }

        // Langsung jalankan saat halaman load
        startRefresh();

        toggle.addEventListener('change', () => {
            if (toggle.checked) {
                startRefresh();
            } else {
                stopRefresh();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/dashboard_management/index.blade.php ENDPATH**/ ?>