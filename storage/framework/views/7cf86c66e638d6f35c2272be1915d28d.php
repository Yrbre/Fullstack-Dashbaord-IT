<?php $__env->startSection('menucategory', 'active'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Edit Category</strong>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo e(route('category.update', $category->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Name Category</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                            value="<?php echo e(old('name', $category->name ?? '')); ?>">
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
                        <label for="simple-select2">Type</label>
                        <select class="form-control select2" id="simple-select2" name="type">
                            <optgroup label="Select Category Type">
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item); ?>"<?php if(old('type', $item) == $category->type): ?> selected <?php endif; ?>>
                                        <?php echo e($item); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <option value="other">Other</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-12" id="otherTypeInput" style="display: none;">
                        <label for="other_type">Specify Type</label>
                        <input type="text" class="form-control" id="other_type" name="other_type"
                            placeholder="Enter custom type">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#simple-select2').on('change', function() {
                if ($(this).val() === 'other') {
                    $('#otherTypeInput').show();
                    $('#other_type').attr('required', true);
                } else {
                    $('#otherTypeInput').hide();
                    $('#other_type').attr('required', false);
                    $('#other_type').val(''); // Clear value
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

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/category/edit.blade.php ENDPATH**/ ?>