<?php $__env->startSection('judul', 'User List'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="col-12">
            <div class="mb-4 d-flex justify-content-end">
                <a href="<?php echo e(route('user.create')); ?>" class="btn btn-primary">Create New</a>
            </div>

            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table User</h5>
                            <p class="card-text"></p>
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Create at</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->name); ?></td>
                                            <td><?php echo e($item->email); ?></td>
                                            <td><?php echo e($item->role); ?></td>
                                            <td><?php echo e($item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-'); ?>

                                            </td>
                                            <td>
                                                <div class="dropdown d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('user.edit', $item->id)); ?>">Edit</a>
                                                        <a class="dropdown-item js-delete-user"
                                                            data-id="<?php echo e($item->id); ?>" data-name="<?php echo e($item->name); ?>"
                                                            data-role="<?php echo e($item->role); ?>"
                                                            data-url="<?php echo e(route('user.destroy', $item->id)); ?>"
                                                            href="#">Remove</a>
                                                    </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <form method="POST" id="deleteForm">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <a class="btn btn-warning" href="<?php echo e(route('user.inactive')); ?>">List User
                            Inactive</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Handle delete modal
        $(document).on('click', '.js-delete-user', function(e) {
            e.preventDefault();
            var button = $(this);
            var name = button.data('name');
            var role = button.data('role');
            var url = button.data('url');

            Swal.fire({
                title: 'Confirm Delete',
                icon: 'warning',
                theme: 'dark',
                html: '<p>Are you sure you want to delete this User?</p>' +
                    '<div class="justify-content-center">' +
                    '<strong>User Name :</strong> ' + name + '<br>' +
                    '<strong>Role :</strong> ' + role +
                    '</div>',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#deleteForm');
                    form.attr('action', url);
                    form.submit();
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
        $('#dataTable-1').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [16, 32, 64, -1],
                [16, 32, 64, "All"]
            ]
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/user/index.blade.php ENDPATH**/ ?>