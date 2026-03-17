<?php $__env->startSection('judul', 'Activity Personal List'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="col-12">
            <div class="mb-4 d-flex justify-content-end">
                <a href="<?php echo e(route('task_personal.create')); ?>" class="btn btn-primary">Create New</a>
            </div>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table Activity Personal</h5>
                            <p class="card-text"></p>
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Parent Activity</th>
                                        <th>Assign to</th>
                                        <th>Progress</th>
                                        <th>Schedule(S/E)</th>
                                        <th>Actual (S/E)</th>
                                        <th>On Timeline</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->id); ?></td>
                                            <td><?php echo e($item->name); ?></td>
                                            <td><?php echo e($item->relation_name ?? '-'); ?></td>
                                            <td><?php echo e($item->user->name ?? '-'); ?></td>
                                            <td><?php echo e($item->progress); ?>%</td>
                                            <td><?php echo e(\Carbon\Carbon::parse($item->schedule_start)->format('d-m-Y H:i')); ?>

                                                <br />
                                                <?php echo e(\Carbon\Carbon::parse($item->schedule_end)->format('d-m-Y H:i')); ?>

                                            </td>
                                            <td><?php echo e($item->actual_start ? \Carbon\Carbon::parse($item->actual_start)->format('d-m-Y H:i') : '-'); ?>

                                                <br />
                                                <?php echo e($item->actual_end ? \Carbon\Carbon::parse($item->actual_end)->format('d-m-Y H:i') : '-'); ?>

                                            </td>
                                            <td><?php echo e($item->diffTime ?? '-'); ?></td>
                                            <td>
                                                <?php if($item->status === 'COMPLETED'): ?>
                                                    <span class="badge badge-success"><?php echo e($item->status); ?></span>
                                                <?php elseif($item->status === 'ON DUTY'): ?>
                                                    <span class="badge badge-primary"><?php echo e($item->status); ?></span>
                                                <?php elseif($item->status === 'NEW'): ?>
                                                    <span class="badge badge-info"><?php echo e($item->status); ?></span>
                                                <?php elseif($item->status === 'CANCELED'): ?>
                                                    <span class="badge badge-warning"><?php echo e($item->status); ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary"><?php echo e($item->status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="dropdown d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('task_personal.edit', $item->id)); ?>">Edit</a>
                                                        <a class="dropdown-item" data-toggle="modal"
                                                            data-target="#deleteModal" data-id="<?php echo e($item->id); ?>"
                                                            data-name="<?php echo e($item->name); ?>"
                                                            data-status="<?php echo e($item->status); ?>"
                                                            data-url="<?php echo e(route('task_personal.destroy', $item->id)); ?>"
                                                            href="#">Remove</a>
                                                    </div>
                                                </div>
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
        // Handle delete modal
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var taskName = button.data('name');
            var statusName = button.data('status');
            var deleteUrl = button.data('url');

            // Update the modal's content
            var modal = $(this);
            modal.find('#taskName').text(taskName);
            modal.find('#statusName').text(statusName);
            modal.find('#deleteForm').attr('action', deleteUrl);
        });
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

<?php echo $__env->make('pages.task.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/task_personal/index.blade.php ENDPATH**/ ?>