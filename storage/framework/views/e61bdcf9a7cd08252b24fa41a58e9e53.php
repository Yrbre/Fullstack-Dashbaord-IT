<?php $__env->startSection('judul', 'Absen List'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="col-12">
            <div class="mb-4 d-flex justify-content-end">
                <a href="<?php echo e(route('absen.create')); ?>" class="btn btn-primary">Create New</a>
                
            </div>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table Absen</h5>
                            <p class="card-text"></p>
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Absent Date</th>
                                        <th>Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $absences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->user->name); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($item->absent_at)->format('d-M-Y')); ?></td>
                                            <td><?php echo e($item->description); ?></td>
                                            <td>
                                                <div class="dropdown d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('absen.edit', $item->id)); ?>">Edit</a>
                                                        <a class="dropdown-item js-delete-task"
                                                            data-id="<?php echo e($item->id); ?>"
                                                            data-name="<?php echo e($item->user->name); ?>"
                                                            data-desc="<?php echo e($item->description); ?>"
                                                            data-url="<?php echo e(route('absen.destroy', $item->id)); ?>"
                                                            href="#">Remove</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <form id="deleteForm" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.js-delete-task', function(e) {
            e.preventDefault();

            var button = $(this);
            var taskName = button.data('name');
            var desc = button.data('desc');
            var deleteUrl = button.data('url');

            Swal.fire({
                title: 'Confirm Delete',
                icon: 'warning',
                theme: 'dark',
                html: '<p>Are you sure you want to delete this Absence?</p>' +
                    '<div class="justify-content-center">' +
                    '<strong>Name :</strong> ' + taskName + '<br>' +
                    '<strong>Description :</strong> ' + desc +
                    '</div>' +
                    '<p class="mt-3 mb-0 text-muted">This action cannot be undone.</p>',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#deleteForm');
                    form.attr('action', deleteUrl);
                    form.trigger('submit');
                }
            });
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
    <script>
        <?php if(session('warning')): ?>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                theme: 'dark',
                text: '<?php echo e(session('warning')); ?>',
                showConfirmButton: true,
            });
        <?php endif; ?>
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/absen/index.blade.php ENDPATH**/ ?>