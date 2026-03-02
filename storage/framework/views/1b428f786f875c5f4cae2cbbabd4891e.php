<?php $__env->startSection('menulocation', 'active'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Create Location</strong>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo e(route('location.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="form-row">

                    <div class="form-group col-12">
                        <label for="simple-select2">Department</label>
                        <select class="form-control select2" id="simple-select3" name="department">
                            <optgroup label="Select Department Type">
                                <option value="" selected disabled>Select Department</option>
                                <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item); ?>"><?php echo e($item); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <option value="other">Other</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-12" id="otherDepartmentInput" style="display: none;">
                        <label for="other_department">Specify Department</label>
                        <input type="text" class="form-control" id="other_department" name="other_department"
                            placeholder="Enter custom department">
                    </div>


                    <div class="form-group col-12">
                        <label for="simple-select2">Location</label>
                        <select class="form-control select2" id="simple-select2" name="location">
                            <optgroup label="Select Location Type">
                                <option value="" selected disabled>Select Type</option>
                                <?php $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item); ?>"><?php echo e($item); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <option value="other">Other</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-12" id="otherLocationInput" style="display: none;">
                        <label for="other_location">Specify Location</label>
                        <input type="text" class="form-control" id="other_location" name="other_location"
                            placeholder="Enter custom location">
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
            $('#simple-select2').on('change', function() {
                if ($(this).val() === 'other') {
                    $('#otherLocationInput').show();
                    $('#other_location').attr('required', true);
                } else {
                    $('#otherLocationInput').hide();
                    $('#other_location').attr('required', false);
                    $('#other_location').val(''); // Clear value
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

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/location/create.blade.php ENDPATH**/ ?>