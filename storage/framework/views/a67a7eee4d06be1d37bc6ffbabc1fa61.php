<?php $__env->startSection('judul', 'Task Department Edit'); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo e(route('task.update', $task->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Task Name</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                            value="<?php echo e(old('name', $task->name)); ?>">
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

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Priority</label>
                        <select class="form-control select2 <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="select-priority"
                            name="priority">
                            <optgroup label="Select Priority Type">
                                <option value="" selected disabled>Select Priority</option>
                                <option value="CRITICAL"
                                    <?php echo e(old('priority', $task->priority) == 'CRITICAL' ? 'selected' : ''); ?>>CRITICAL</option>
                                <option value="HIGH" <?php echo e(old('priority', $task->priority) == 'HIGH' ? 'selected' : ''); ?>>
                                    HIGH</option>
                                <option value="MEDIUM" <?php echo e(old('priority', $task->priority) == 'MEDIUM' ? 'selected' : ''); ?>>
                                    MEDIUM</option>
                                <option value="LOW" <?php echo e(old('priority', $task->priority) == 'LOW' ? 'selected' : ''); ?>>LOW
                                </option>
                            </optgroup>
                        </select>
                        <?php $__errorArgs = ['priority'];
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

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Category</label>
                        <select class="form-control select2 <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="select-category"
                            name="category_id">
                            <optgroup label="Select Category Type">
                                <option value="" selected disabled>Select Category</option>
                                <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"
                                        <?php echo e(old('category_id', $task->category_id) == $item->id ? 'selected' : ''); ?>>
                                        <?php echo e($item->type); ?> - <?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                        </select>
                        <?php $__errorArgs = ['category_id'];
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

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Assign to</label>
                        <select class="form-control select2" id="select-assign" name="assign_to">
                            <optgroup label="Select User">
                                <?php $__currentLoopData = $assignTo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>"
                                        <?php echo e(old('assign_to', $task->assign_to) == $id ? 'selected' : ''); ?>>
                                        <?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Level</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['task_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="task_level" value="<?php echo e(old('task_level', $task->task_level)); ?>" readonly>
                        <?php $__errorArgs = ['task_level'];
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

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Personal</label>
                        <input type="text" id="select-personal"
                            class="form-control <?php $__errorArgs = ['enduser_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="enduser_id"
                            value="<?php echo e(old('enduser_id', $task->enduser->name . ' - ' . $task->enduser->department)); ?>"
                            readonly>
                        <?php $__errorArgs = ['enduser_id'];
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

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Department</label>
                        <input type="text" id="select-department"
                            class="form-control <?php $__errorArgs = ['enduser_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="enduser_id"
                            value="<?php echo e(old('enduser_id', $task->enduser->department)); ?>" readonly>
                        <?php $__errorArgs = ['enduser_id'];
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


                    <div class="form-group col-md-6">
                        <label for="simple-select2">Status</label>
                        <select class="form-control select2 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="select-status"
                            name="status">
                            <optgroup label="Select Status Type">
                                <option value="" selected disabled>Select Status</option>
                                <?php if($task->status === 'ON DUTY'): ?>
                                    <option value="ON DUTY"
                                        <?php echo e(old('status', $task->status) == 'ON DUTY' ? 'selected' : ''); ?>>
                                        ON DUTY
                                    </option>
                                <?php endif; ?>
                                <option value="NEW" <?php echo e(old('status', $task->status) == 'NEW' ? 'selected' : ''); ?>>
                                    NEW
                                </option>
                                <option value="ON PROGRESS"
                                    <?php echo e(old('status', $task->status) == 'ON PROGRESS' ? 'selected' : ''); ?>>
                                    ON PROGRESS
                                </option>
                                <option value="ON HOLD" <?php echo e(old('status', $task->status) == 'ON HOLD' ? 'selected' : ''); ?>>
                                    ON HOLD
                                </option>
                                <option value="COMPLETED"
                                    <?php echo e(old('status', $task->status) == 'COMPLETED' ? 'selected' : ''); ?>>
                                    COMPLETED
                                </option>
                                <option value="CANCELLED"
                                    <?php echo e(old('status', $task->status) == 'CANCELLED' ? 'selected' : ''); ?>>
                                    CANCELLED
                                </option>
                            </optgroup>
                        </select>
                        <?php $__errorArgs = ['status'];
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

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Progress</label>
                        <select class="form-control select2 <?php $__errorArgs = ['progress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="select-progress"
                            name="progress">
                            <optgroup label="Select Progress">
                                <option value="" selected disabled>Select Progress</option>
                                <option value="0" <?php echo e(old('progress', $task->progress) == 0 ? 'selected' : ''); ?>>0%
                                </option>
                                <option value="10" <?php echo e(old('progress', $task->progress) == 10 ? 'selected' : ''); ?>>10%
                                </option>
                                <option value="25" <?php echo e(old('progress', $task->progress) == 25 ? 'selected' : ''); ?>>25%
                                </option>
                                <option value="50" <?php echo e(old('progress', $task->progress) == 50 ? 'selected' : ''); ?>>50%
                                </option>
                                <option value="75" <?php echo e(old('progress', $task->progress) == 75 ? 'selected' : ''); ?>>75%
                                </option>
                                <option value="100" <?php echo e(old('progress', $task->progress) == 100 ? 'selected' : ''); ?>>100%
                                </option>
                            </optgroup>
                        </select>
                    </div>

                    

                    <div class="form-group col-md-6">
                        <label for="">Schedule Start</label>
                        <input type="datetime-local" class="form-control <?php $__errorArgs = ['schedule_start'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="schedule_start" value="<?php echo e(old('schedule_start', $task->schedule_start)); ?>">
                        <?php $__errorArgs = ['schedule_start'];
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

                    <div class="form-group col-md-6">
                        <label for="">Schedule End</label>
                        <input type="datetime-local" class="form-control <?php $__errorArgs = ['schedule_end'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="schedule_end" value="<?php echo e(old('schedule_end', $task->schedule_end)); ?>">
                        <?php $__errorArgs = ['schedule_end'];
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
                        <label for="">Description</label>
                        <textarea type="text" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="description"
                            value="<?php echo e(old('description')); ?>"><?php echo e(old('description', $task->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
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
                </div>
                <div class="d-flex align-items-end justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var currentLevel = '<?php echo e($task->task_level); ?>';

            if (currentLevel === 'DEPARTMENT') {
                $('#select-personal').closest('.form-group').hide();
                $('#select-department').closest('.form-group').show();
            } else if (currentLevel === 'PERSONAL') {
                $('#select-department').closest('.form-group').hide();
                $('#select-personal').closest('.form-group').show();
            } else {
                $('#select-department').closest('.form-group').hide();
                $('#select-personal').closest('.form-group').hide();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var originalProgress = '<?php echo e($task->progress); ?>';
            $('#select-status').on('change', function() {
                var selectedStatus = $(this).val();
                if (selectedStatus === 'COMPLETED') {
                    $('#select-progress').val('100').trigger('change');
                } else if (selectedStatus === 'NEW') {
                    $('#select-progress').val('0').trigger('change');
                } else {
                    $('#select-progress').val(originalProgress).trigger('change');
                }
            });
        });
    </script>


    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: 0,
            width: '100%',
        });
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
            width: '100%',
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/task/edit.blade.php ENDPATH**/ ?>