<?php $__env->startSection('menuuser', 'active'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <div class="col-12">
            <h2 class="page-title">User List</h2>
            <div class="mb-4 d-flex justify-content-end">
                <a href="<?php echo e(route('user.create')); ?>" class="btn btn-primary">Create New User</a>
            </div>
            
            <form class="form-inline mr-auto searchform text-muted" action="<?php echo e(route('user.index')); ?>" method="GET">
                <input class="form-control mr-sm-2 bg-transparent border-1 pl-4 text-muted" type="search"
                    placeholder="Type something..." aria-label="Search" name="search"
                    value="<?php echo e($search['search'] ?? ''); ?>">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table User</h5>
                            <p class="card-text"></p>
                            <table class="table table-hover">
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
                                                        <a class="dropdown-item" data-toggle="modal"
                                                            data-target="#deleteModal" data-id="<?php echo e($item->id); ?>"
                                                            data-name="<?php echo e($item->name); ?>"
                                                            data-role="<?php echo e($item->role); ?>"
                                                            data-url="<?php echo e(route('user.destroy', $item->id)); ?>"
                                                            href="#">Remove</a>
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
            var userName = button.data('name');
            var roleName = button.data('role');
            var deleteUrl = button.data('url');

            // Update the modal's content
            var modal = $(this);
            modal.find('#userName').text(userName);
            modal.find('#roleName').text(roleName);
            modal.find('#deleteForm').attr('action', deleteUrl);
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

<?php echo $__env->make('pages.user.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/user/index.blade.php ENDPATH**/ ?>