<?php $__env->startSection('judul', 'End User Create'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo e(route('enduser.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Name End User</label>
                        <input type="text" class="uppercase form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="name" value="<?php echo e(old('name')); ?>">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group col-12">
                        <label for="simple-select2">Department</label>
                        <select class="form-control select2" id="simple-select3" name="department">
                            <optgroup label="Select Department Type">
                                <option value="" selected disabled>Select Department</option>
                                <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item); ?>"><?php echo e($item); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-12" id="otherDepartmentInput" style="display: none;">
                        <label for="other_department">Specify Department</label>
                        <input type="text" class="uppercase form-control" id="other_department" name="other_department"
                            placeholder="Enter custom department" pattern="^\S+$"
                            oninput="this.value = this.value.replace(/\s+/g, '')" value="<?php echo e(old('other_department')); ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#simple-select3').on('change', function() {
                if ($(this).val() === 'other') {
                    $('#otherDepartmentInput').show();
                    $('#other_department').attr('required', true);
                } else {
                    $('#otherDepartmentInput').hide();
                    $('#other_department').attr('required', false);
                    $('#other_department').val(''); // Clear value
                }
            });
        });
    </script>

    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/enduser/create.blade.php ENDPATH**/ ?>