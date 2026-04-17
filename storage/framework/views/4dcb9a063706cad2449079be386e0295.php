<?php $__env->startSection('judul', 'MY JOB ASSIGNMENT'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="mx-auto">
            <div class="row align-items-start">
                <div class="col-9">

                    <h4 class="page-title justify-content-center"><i class="fe fe-send" style="color:orange"></i>
                        JOB ASSIGNMENT</h4>
                    <div class="">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover datatables" id="dataTable-2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Activity Name</th>
                                                <th>Parent Job</th>
                                                <th>Deliver By</th>
                                                <th>Schedule Start</th>
                                                <th>Schedule End</th>
                                                <th>Priority</th>
                                                <th>Progres</th>
                                                <th>Status</th>
                                                <th>Location</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $__currentLoopData = $taskReady; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($item->schedule_start != now()->format('Y-m-d H:i') && $item->schedule_start > now()): ?>
                                                    <tr style="color:yellow">
                                                        <td><?php echo e($loop->iteration); ?></td>
                                                        <td><?php echo e($item->name); ?></td>
                                                        <td><?php echo e($item->parent->name ?? '-'); ?></td>
                                                        <td><?php echo e($item->deliveredUser?->name ?? ($item->delivered ?? '-')); ?>

                                                        </td>
                                                        <td><?php echo e(\Carbon\Carbon::parse($item->schedule_start)->format('d M Y H:i')); ?>

                                                        </td>
                                                        <td><?php echo e(\Carbon\Carbon::parse($item->schedule_end)->format('d M Y H:i')); ?>

                                                        </td>
                                                        <td>
                                                            <?php if($item->priority === 'CRITICAL'): ?>
                                                                <span
                                                                    class="badge badge-danger"><?php echo e($item->priority); ?></span>
                                                            <?php elseif($item->priority === 'HIGH'): ?>
                                                                <span
                                                                    class="badge badge-warning"><?php echo e($item->priority); ?></span>
                                                            <?php elseif($item->priority === 'MEDIUM'): ?>
                                                                <span class="badge badge-info"><?php echo e($item->priority); ?></span>
                                                            <?php else: ?>
                                                                <span
                                                                    class="badge badge-secondary"><?php echo e($item->priority); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo e($item->progress); ?>%</td>
                                                        <td>
                                                            <?php if($item->status === 'COMPLETED'): ?>
                                                                <span
                                                                    class="badge badge-success"><?php echo e($item->status); ?></span>
                                                            <?php elseif($item->status === 'ON DUTY'): ?>
                                                                <span
                                                                    class="badge badge-primary"><?php echo e($item->status); ?></span>
                                                            <?php elseif($item->status === 'NEW'): ?>
                                                                <span class="badge badge-info"><?php echo e($item->status); ?></span>
                                                            <?php elseif($item->status === 'CANCELED'): ?>
                                                                <span
                                                                    class="badge badge-warning"><?php echo e($item->status); ?></span>
                                                            <?php else: ?>
                                                                <span
                                                                    class="badge badge-secondary"><?php echo e($item->status); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo e($item->location->building ?? '-'); ?> -
                                                            <?php echo e($item->location->location ?? '-'); ?></td>
                                                        <td><?php echo e($item->description ?? ''); ?></td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary btn-take-task"
                                                                data-id="<?php echo e($item->id); ?>"
                                                                data-name="<?php echo e($item->name); ?>"
                                                                data-location="<?php echo e($item->location->building ?? '-'); ?> - <?php echo e($item->location->location ?? '-'); ?>"
                                                                data-url="<?php echo e(route('active_task.index', $item->id)); ?>">
                                                                Take
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php else: ?>
                                                    <tr>
                                                        <td><?php echo e($loop->iteration); ?></td>
                                                        <td><?php echo e($item->name); ?></td>
                                                        <td><?php echo e($item->parent->name ?? '-'); ?></td>
                                                        <td><?php echo e($item->deliveredUser?->name ?? ($item->delivered ?? '-')); ?>

                                                        </td>
                                                        <td><?php echo e(\Carbon\Carbon::parse($item->schedule_start)->format('d M Y H:i')); ?>

                                                        </td>
                                                        <td><?php echo e(\Carbon\Carbon::parse($item->schedule_end)->format('d M Y H:i')); ?>

                                                        </td>
                                                        <td>
                                                            <?php if($item->priority === 'CRITICAL'): ?>
                                                                <span
                                                                    class="badge badge-danger"><?php echo e($item->priority); ?></span>
                                                            <?php elseif($item->priority === 'HIGH'): ?>
                                                                <span
                                                                    class="badge badge-warning"><?php echo e($item->priority); ?></span>
                                                            <?php elseif($item->priority === 'MEDIUM'): ?>
                                                                <span class="badge badge-info"><?php echo e($item->priority); ?></span>
                                                            <?php else: ?>
                                                                <span
                                                                    class="badge badge-secondary"><?php echo e($item->priority); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo e($item->progress); ?>%</td>
                                                        <td>
                                                            <?php if($item->status === 'COMPLETED'): ?>
                                                                <span
                                                                    class="badge badge-success"><?php echo e($item->status); ?></span>
                                                            <?php elseif($item->status === 'ON DUTY'): ?>
                                                                <span
                                                                    class="badge badge-primary"><?php echo e($item->status); ?></span>
                                                            <?php elseif($item->status === 'NEW'): ?>
                                                                <span class="badge badge-info"><?php echo e($item->status); ?></span>
                                                            <?php elseif($item->status === 'CANCELED'): ?>
                                                                <span
                                                                    class="badge badge-warning"><?php echo e($item->status); ?></span>
                                                            <?php else: ?>
                                                                <span
                                                                    class="badge badge-secondary"><?php echo e($item->status); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo e($item->location->building ?? '-'); ?> -
                                                            <?php echo e($item->location->location ?? '-'); ?></td>
                                                        <td><?php echo e($item->description ?? ''); ?></td>
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary btn-take-task"
                                                                data-id="<?php echo e($item->id); ?>"
                                                                data-name="<?php echo e($item->name); ?>"
                                                                data-location="<?php echo e($item->location->location ?? '-'); ?>"
                                                                data-url="<?php echo e(route('active_task.index', $item->id)); ?>">
                                                                Take
                                                            </button>
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
                <div class="col-3 d-flex justify-content-center">
                    <div class="w-100" style="max-width: 390px;">
                        <div class="shadow border-0 h-100">
                            <div class="card-body p-3 p-xl-4">
                                <div class="d-flex flex-column" style="gap: 1rem;">
                                    <div class="rounded-lg p-3 text-center">
                                        <div class="activity-icon-wrapper rounded-circle mb-3 mx-auto"></div>

                                        <h4 class="page-title font-weight-bold mb-2">
                                            <i class="fe fe-list text-primary"></i> PERSONAL ACTIVITY
                                        </h4>
                                        <p class="text-muted mb-0 small">Pilih activity personal yang akan dikerjakan.</p>

                                        <button type="button" id="btnChooseActivity"
                                            class="btn btn-primary btn-block px-4 py-2 shadow-sm mt-3">
                                            SELECT
                                        </button>
                                    </div>

                                    <div class="rounded-lg p-3 text-center">
                                        <div class="activity-icon-wrapper rounded-circle mb-3 mx-auto"></div>

                                        <h4 class="page-title font-weight-bold mb-2">
                                            <i class="fe fe-alert-triangle text-warning"></i>
                                            <?php echo e($activityList->where('id', 9)->first()->name ?? '-'); ?>

                                        </h4>
                                        <p class="text-muted mb-0 small">Untuk pekerjaan dadakan yang langsung diambil.</p>

                                        <button type="button"
                                            class="btn btn-primary btn-block px-4 py-2 shadow-sm mt-3 btn-take-activity"
                                            data-id="9" data-name="ONSPOT JOB" data-location="-"
                                            data-url="<?php echo e(route('dashboard_operator.take', 9)); ?>">
                                            TAKE
                                        </button>
                                    </div>

                                    <?php if(!empty($activeSession) && in_array($activeSession->reference_type, ['TASK', 'JOB'])): ?>
                                        <div class="rounded-lg p-3 shadow-sm">
                                            <div class="text-center mb-3">
                                                <h4 class="page-title font-weight-bold mb-2 text-danger">
                                                    <i class="fe fe-activity" style="color: chartreuse"></i>
                                                    JOB IN PROGRESS
                                                </h4>
                                                <p class="text-muted mb-0 small">Satu job sedang aktif saat ini.</p>
                                            </div>

                                            <?php if($activeSession->reference_type === 'TASK'): ?>
                                                <h5 class="page-title font-weight-bold mb-3 text-center text-break">
                                                    <?php echo e($activeSession->task->name ?? '-'); ?>

                                                </h5>
                                                <div class="text-center">
                                                    <a href="<?php echo e(route('dashboard_operator.idle_task', $activeSession->reference_id)); ?>"
                                                        class="btn btn-sm btn-primary px-4 py-2">View</a>
                                                </div>
                                            <?php elseif($activeSession->reference_type === 'JOB'): ?>
                                                <h5 class="page-title font-weight-bold mb-3 text-center text-break">
                                                    <?php echo e($activeSession->activity->name ?? '-'); ?>

                                                </h5>
                                                <div class="text-center">
                                                    <a href="<?php echo e(route('dashboard_operator.idle', $activeSession->id)); ?>"
                                                        class="btn btn-sm btn-primary px-4 py-2">View</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(!empty($activeSession) && $activeSession->reference_type === 'ACTIVITY'): ?>
                                        <div class="rounded-lg p-3 shadow-sm">
                                            <div class="text-center mb-3">
                                                <h4 class="page-title font-weight-bold mb-2 text-danger">
                                                    <i class="fe fe-activity" style="color: chartreuse"></i>
                                                    ACTIVITY IN PROGRESS
                                                </h4>
                                                <p class="text-muted mb-0 small">Activity personal sedang berjalan.</p>
                                            </div>

                                            <h5 class="page-title font-weight-bold mb-3 text-center text-break">
                                                <?php echo e($activeSession->activity->name ?? '-'); ?>

                                            </h5>
                                            <div class="text-center">
                                                <a href="<?php echo e(route('dashboard_operator.idle', $activeSession->id)); ?>"
                                                    class="btn btn-sm btn-primary px-4 py-2">View</a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="activityListTemplate" style="display: none;">
                <div style="max-height:400px; overflow-y:auto;" data-simplebar>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <td class="text-center">Activity</td>
                                <td class="text-center">Location</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $activityList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->id === 9): ?>
                                    <?php continue; ?>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-center"><?php echo e($item->name); ?></td>
                                    <td class="text-center"><?php echo e($item->location); ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary btn-take-activity"
                                            data-id="<?php echo e($item->id); ?>" data-name="<?php echo e($item->name); ?>"
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

            <div id="showActivityTemplate" style="display: none;">
                <?php $__currentLoopData = $taskCompleted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div id="show-activity-<?php echo e($task->id); ?>" class="show-activity-item" style="display: none;">
                        <div style="max-height:400px; overflow-y:auto;" data-simplebar>
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <td class="text-center">ID</td>
                                        <td class="text-center">Name</td>
                                        <td class="text-center">Parent</td>
                                        <td class="text-center">Assign to</td>
                                        <td class="text-center">Priority</td>
                                        <td class="text-center">Schedule Start</td>
                                        <td class="text-center">Schedule End</td>
                                        <td class="text-center">Actual Start</td>
                                        <td class="text-center">Actual End</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?php echo e($task->id); ?></td>
                                        <td class="text-center"><?php echo e($task->name); ?></td>
                                        <td class="text-center"><?php echo e($task->parent->name ?? '-'); ?></td>
                                        <td class="text-center"><?php echo e($task->assignedTo->name ?? '-'); ?></td>
                                        <td class="text-center"><?php echo e($task->priority); ?></td>
                                        <td class="text-center"><?php echo e($task->schedule_start?->format('d-m-Y H:i') ?? '-'); ?>

                                        </td>
                                        <td class="text-center"><?php echo e($task->schedule_end?->format('d-m-Y H:i') ?? '-'); ?>

                                        </td>
                                        <td class="text-center"><?php echo e($task->actual_start?->format('d-m-Y H:i') ?? '-'); ?>

                                        </td>
                                        <td class="text-center"><?php echo e($task->actual_end?->format('d-m-Y H:i') ?? '-'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 my-4">
                    <h2 class="page-title"> <i class="fe fe-server" style="color:coral"></i> Activity Completed
                    </h2>
                    <div class="card shadow">
                        <div class="card-body">

                            <table class="table md:table-responsive datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <td class="text-center">#</td>
                                        <td class="text-center">Activity Name</td>
                                        <td class="text-center">Progress</td>
                                        <td class="text-center">Status</td>
                                        <td class="">Action</td>
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
                                            <td class=""><button type="button" data-id="<?php echo e($task->id); ?>"
                                                    data-template-id="show-activity-<?php echo e($task->id); ?>"
                                                    class="btn btn-primary px-4 py-2 shadow-sm btn-show-activity">
                                                    SHOW
                                                </button></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="takeForm" method="POST" style="display:none;">
            <?php echo csrf_field(); ?>
        </form>

        <script>
            $(document).on('click', '.btn-show-activity', function() {
                const templateId = $(this).data('template-id');
                const content = $('#' + templateId).html();

                Swal.fire({
                    title: 'Activity Details',
                    theme: 'dark',
                    width: '1500px',
                    html: content || '<p class="text-center mb-0">Detail activity tidak ditemukan.</p>',
                    showCloseButton: true,
                    showConfirmButton: false,
                });
            });
        </script>
        <script>
            $(document).on('click', '#btnChooseActivity', function() {
                Swal.fire({
                    title: 'Choose Activity',
                    theme: 'dark',
                    width: '900px',
                    html: $('#activityListTemplate').html(),
                    showConfirmButton: false,
                    showCloseButton: true
                });
            });

            function escapeHtml(text) {
                return $('<div>').text(text || '-').html();
            }

            $(document).on('click', '.btn-take-activity', function() {
                const button = $(this);

                const activityName = button.data('name');
                const activityLocation = button.data('location');
                const takeUrl = button.data('url');
                const activityId = Number(button.data('id'));
                let htmlContent = '';

                // Kondisi aktivitas dadakan (ID 9 wajib isi form)
                if (activityId === 9) {
                    Swal.fire({
                        icon: 'question',
                        title: 'INFORMATION ACTIVITY',
                        theme: 'dark',
                        html: `
                    <div class="text-start" style="max-width: 560px; margin: 0 auto;">
                        <div class="small text-muted mb-3">Lengkapi data berikut sebelum mengambil activity.</div>

                        <div class="d-flex align-items-start mb-3" style="gap: 12px;">
                            <label for="swal-enduser" class="form-label mb-0 pt-2" style="min-width: 120px;">End User</label>
                            <div style="flex: 1;">
                                <select class="swal2-select select2" id="swal-enduser" name="enduser_personal" style="margin: 0; width: 100%;">
                                    <optgroup label="Select End User">
                                        <option value="" selected disabled>Select User</option>
                                            <?php $__currentLoopData = $endUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->name); ?>" <?php if(old('enduser_personal') == $item->name): ?> selected <?php endif; ?>>
                                                    <?php echo e($item->name ?? '-'); ?> - <?php echo e($item->department ?? '-'); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-3" style="gap: 12px;">
                            <label for="swal-location" class="form-label mb-0 pt-2" style="min-width: 120px;">Location</label>
                            <div style="flex: 1;">
                                <select class="swal2-select select2" id="swal-location" name="location" style="margin: 0; width: 100%;">
                                    <optgroup label="Select Location">
                                        <option value="" selected disabled>Select Location</option>
                                            <?php $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->building); ?> - <?php echo e($item->location); ?>" <?php if(old('location') == $item->building . ' - ' . $item->location): ?> selected <?php endif; ?>>
                                                    <?php echo e($item->building ?? '-'); ?> - <?php echo e($item->location ?? '-'); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-0" style="gap: 12px;">
                            <label for="swal-trouble" class="form-label mb-0 pt-2" style="min-width: 120px;">Trouble</label>
                            <div style="flex: 1;">
                                <textarea class="uppercase swal2-textarea" id="swal-trouble" style="margin: 0; width: 100%; min-height: 110px;" placeholder="Masukkan Trouble"></textarea>
                            </div>
                        </div>
                    </div>
        `,
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Take Activity',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#2f7cf6',
                        cancelButtonColor: '#6c757d',
                        didOpen: () => {
                            $('#swal-enduser').select2({
                                theme: 'bootstrap4',
                                width: '100%',
                                dropdownParent: $('.swal2-popup'),
                                placeholder: 'Select User',
                                allowClear: true
                            });
                            $('#swal-location').select2({
                                theme: 'bootstrap4',
                                width: '100%',
                                dropdownParent: $('.swal2-popup'),
                                placeholder: 'Select Location',
                                allowClear: true
                            });
                        },

                        // VALIDASI sebelum submit
                        preConfirm: () => {
                            const endUser = $('#swal-enduser').val();
                            const location = $('#swal-location').val();
                            const trouble = $('#swal-trouble').val();

                            if (!endUser || !location || !trouble) {
                                Swal.showValidationMessage('Semua field wajib diisi');
                                return false;
                            }

                            return {
                                endUser,
                                location,
                                trouble
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            // inject ke form sebelum submit
                            $('#takeForm').attr('action', takeUrl);
                            $('#takeForm input[name="end_user"], #takeForm input[name="location"], #takeForm input[name="trouble"]')
                                .remove();

                            // pastikan input hidden ada
                            $('#takeForm').append(`
        <input type="hidden" name="end_user" value="${escapeHtml(result.value.endUser)}">
        <input type="hidden" name="location" value="${escapeHtml(result.value.location)}">
        <input type="hidden" name="trouble" value="${escapeHtml(result.value.trouble)}">
        `);

                            $('#takeForm').trigger('submit');
                        }
                    });

                    return; // IMPORTANT: stop eksekusi Swal bawah
                }

                if (activityId === 8) {
                    Swal.fire({
                        icon: 'question',
                        title: 'INFORMATION ACTIVITY',
                        theme: 'dark',
                        html: `
                    <div class="text-start" style="max-width: 560px; margin: 0 auto;">
                        <div class="small text-muted mb-3">Lengkapi data berikut sebelum mengambil activity.</div>
                        <div class="d-flex align-items-start mb-0" style="gap: 12px;">
                            <label for="swal-trouble" class="form-label mb-0 pt-2" style="min-width: 120px;">Keterangan</label>
                            <div style="flex: 1;">
                                <textarea class="uppercase swal2-textarea" id="swal-trouble" style="margin: 0; width: 100%; min-height: 110px;" placeholder="Masukkan Keterangan"></textarea>
                            </div>
                        </div>
                    </div>
        `,
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Take Activity',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#2f7cf6',
                        cancelButtonColor: '#6c757d',
                        // VALIDASI sebelum submit
                        preConfirm: () => {
                            const trouble = $('#swal-trouble').val();

                            if (!trouble) {
                                Swal.showValidationMessage('Semua field wajib diisi');
                                return false;
                            }

                            return {
                                trouble
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            // inject ke form sebelum submit
                            $('#takeForm').attr('action', takeUrl);
                            $('#takeForm input[name="trouble"]')
                                .remove();
                            // pastikan input hidden ada
                            $('#takeForm').append(`
        <input type="hidden" name="trouble" value="${escapeHtml(result.value.trouble)}">
        `);

                            $('#takeForm').trigger('submit');
                        }
                    });

                    return; // IMPORTANT: stop eksekusi Swal bawah
                }


                // Selain ID 8 dan 9, hanya konfirmasi biasa
                htmlContent = `
            <div class="text-center">
                <p class="mb-2">Are you sure you want to take this activity?</p>
                <p class="mb-1">
                    <strong>Activity Name:</strong>
                    ${escapeHtml(activityName)}
                </p>
                <p class="mb-0">
                    <strong>Location:</strong>
                    ${escapeHtml(activityLocation)}
                </p>
            </div>
        `;

                Swal.fire({
                    icon: 'question',
                    title: 'Confirm Take Activity',
                    theme: 'dark',
                    html: htmlContent,
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
            $(document).on('click', '.btn-take-task', function() {
                var button = $(this);
                var jobName = button.data('name');
                var jobLocation = button.data('location');
                var takeUrl = button.data('url');

                Swal.fire({
                    icon: 'question',
                    title: 'Confirm Take Job',
                    theme: 'dark',
                    html: '<div class="text-center">' +
                        '<p class="mb-2">Are you sure you want to take this Job?</p>' +
                        '<p class="mb-1"><strong>Job Name:</strong> &nbsp;' + escapeHtml(jobName) +
                        '</p>' +
                        '<p class="mb-0"><strong>Location:</strong> &nbsp;' + escapeHtml(jobLocation) +
                        '</p>' +
                        '</div>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Take Job',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#2f7cf6',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = takeUrl;
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
        <script>
            <?php if(session('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    theme: 'dark',
                    text: '<?php echo e(session('error')); ?>',
                    timer: 2000,
                    showConfirmButton: false,
                });
            <?php endif; ?>
        </script>
        
        <script>
            $('#dataTable-1').DataTable({
                autoWidth: true,
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ]
            });
        </script>
        <script>
            $('#dataTable-2').DataTable({
                autoWidth: true,
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ]
            });
        </script>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/dashboard_operator/index.blade.php ENDPATH**/ ?>