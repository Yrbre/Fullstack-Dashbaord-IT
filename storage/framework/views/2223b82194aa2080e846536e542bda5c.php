<?php $__env->startSection('judul', 'Create Job Assignment'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card shadow mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo e(route('task_personal.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Job Name</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                            value="<?php echo e(old('name')); ?>">
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

                    <div class="form-group col-6">
                        <label for="simple-select2">Parent Activity</label>
                        <select class="form-control select2 <?php $__errorArgs = ['relation_task'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="select-relation-task" name="relation_task">
                            <optgroup label="Select Relation Activity">
                                <option value="" selected>Without Relation</option>
                                <?php $__currentLoopData = $task; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if(old('relation_task') == $item->id): ?> selected <?php endif; ?>>
                                        Name: <?php echo e($item->name); ?> | S/E:
                                        <?php echo e($item->schedule_start->format('m-d-Y h:i A') ?? '-'); ?>

                                        /
                                        <?php echo e($item->schedule_end ? $item->schedule_end->format('m-d-Y h:i A') : '-'); ?> |
                                        Total Weight: <?php echo e($weight[$item->id] ?? 0); ?>%
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                        </select>
                        <?php $__errorArgs = ['relation_task'];
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


                    <div class="form-group col-6">
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
                                <option value="CRITICAL" <?php if(old('priority') == 'CRITICAL'): ?> selected <?php endif; ?>>CRITICAL</option>
                                <option value="HIGH" <?php if(old('priority') == 'HIGH'): ?> selected <?php endif; ?>>HIGH</option>
                                <option value="MEDIUM" <?php if(old('priority') == 'MEDIUM'): ?> selected <?php endif; ?>>MEDIUM</option>
                                <option value="LOW" <?php if(old('priority') == 'LOW'): ?> selected <?php endif; ?>>LOW</option>
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

                    <div class="form-group col-6">
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
                                    <option value="<?php echo e($item->id); ?>" <?php if(old('category_id') == $item->id): ?> selected <?php endif; ?>>
                                        <?php echo e($item->name); ?></option>
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

                    <div class="form-group col-6">
                        <label for="simple-select2">Responsibility</label>
                        <select class="form-control select2" id="select2" name="assign_to">
                            <optgroup label="Select User">
                                <?php $__currentLoopData = $assignTo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php if(old('assign_to', Auth::user()->id) == $id): ?> selected <?php endif; ?>>
                                        <?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="simple-select2">Member</label>
                        <select class="form-control select2-multi <?php $__errorArgs = ['member'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="multi-select2"
                            name="member[]" multiple>
                            <optgroup label="Select User">
                                <?php $__currentLoopData = $assignTo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>"
                                        <?php echo e(in_array($id, old('member', [])) ? 'selected' : ''); ?>>
                                        <?php echo e($name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </optgroup>
                        </select>
                        <?php $__errorArgs = ['member'];
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

                    <div class="form-group col-6">
                        <label for="simple-select2">Level</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['task_level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            value="PERSONAL" readonly id="select-level" name="task_level">
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


                    <div class="form-group col-6">
                        <label for="simple-select2">End User / Dept PIC</label>
                        <select class="form-control select2" id="select-personal" name="enduser_personal">
                            <optgroup label="Select Personal">
                                <option value="" selected disabled>Select User</option>
                                <?php $__currentLoopData = $endUser; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if(old('enduser_personal') == $item->id): ?> selected <?php endif; ?>>
                                        <?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <option value="OTHER" <?php if(old('enduser_personal') == 'OTHER'): ?> selected <?php endif; ?>>OTHER</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-6" id="otherPersonalInput" style="display: none;">
                        <label for="other_personal">Specify User</label>
                        <input type="text" class="form-control" id="other_personal" name="other_personal"
                            placeholder="Enter custom personal" value="<?php echo e(old('other_personal')); ?>">
                    </div>
                    <div class="form-group col-6" id="otherPersonalDepartmentInput" style="display: none;">
                        <label for="other_personal_department">Specify Department</label>
                        <input type="text" class="form-control" id="other_personal_department"
                            name="other_personal_department" placeholder="Enter custom department"
                            value="<?php echo e(old('other_personal_department')); ?>">
                    </div>

                    <input type="hidden" name="status" value="NEW">
                    

                    <div class="form-group col-6">
                        <label for="simple-select2">Location</label>
                        <select class="form-control select2 <?php $__errorArgs = ['location_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="select-location" name="location_id">
                            <optgroup label="Select Location">
                                <option value="" selected disabled>Select Location</option>
                                <?php $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"
                                        <?php if(old('location_id') == $item->id): ?> selected <?php endif; ?>>
                                        <?php echo e($item->location); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <option value="OTHER" <?php if(old('location_id') == 'OTHER'): ?> selected <?php endif; ?>>OTHER</option>
                            </optgroup>
                        </select>
                        <?php $__errorArgs = ['location_id'];
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

                    <div class="form-group col-6" id="otherDepartmentLocationInput" style="display: none;">
                        <label for="other_department_location">Specify Department Location</label>
                        <input type="text" class="form-control" id="other_department_location"
                            name="other_department_location" placeholder="Enter custom department location"
                            value="<?php echo e(old('other_department_location')); ?>">
                    </div>

                    <div class="form-group col-6" id="otherLocationInput" style="display: none;">
                        <label for="other_location">Specify Location</label>
                        <input type="text" class="form-control" id="other_location" name="other_location"
                            placeholder="Enter custom location" value="<?php echo e(old('other_location')); ?>">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Activity Weight</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['task_load'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="task_load" value="<?php echo e(old('task_load', 100)); ?>"
                            oninput="this.value = this.value.replace(/[^0-9]/g,'');if(this.value > 100) this.value = 100;">
                        <?php $__errorArgs = ['task_load'];
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
                        <label for="">Schedule Start</label>
                        <input type="datetime-local" class="form-control <?php $__errorArgs = ['schedule_start'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="schedule_start" value="<?php echo e(old('schedule_start', now()->format('Y-m-d H:i'))); ?>">
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
                            name="schedule_end" value="<?php echo e(old('schedule_end')); ?>">
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

                    <div class="form-group col-md-12">
                        <label for="">Description</label>
                        <textarea type="text" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="description"
                            value="<?php echo e(old('description')); ?>"><?php echo e(old('description')); ?></textarea>
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

            function toggleLevel() {
                const level = $('#select-level').val();

                // DEPARTMENT
                if (level === 'DEPARTMENT') {
                    $('#select-department').closest('.form-group').show();
                    $('#select-department').prop('required', true);
                } else {
                    $('#select-department')
                        .closest('.form-group').hide();
                    $('#select-department')
                        .prop('required', false)
                        .val(null)
                        .trigger('change');
                }

                // PERSONAL
                if (level === 'PERSONAL') {
                    $('#select-personal').closest('.form-group').show();
                    $('#select-personal').prop('required', true);
                } else {
                    $('#select-personal')
                        .closest('.form-group').hide();
                    $('#select-personal')
                        .prop('required', false)
                        .val(null)
                        .trigger('change');
                }
            }

            function toggleDepartmentOther() {
                if ($('#select-department').val() === 'OTHER') {
                    $('#otherDepartmentInput').show();
                    $('#other_department').prop('required', true);
                } else {
                    $('#otherDepartmentInput').hide();
                    $('#other_department')
                        .prop('required', false)
                        .val('');
                }
            }

            function togglePersonalOther() {
                if ($('#select-personal').val() === 'OTHER') {
                    $('#otherPersonalInput').show();
                    $('#other_personal').prop('required', true);

                    $('#otherPersonalDepartmentInput').show();
                    $('#other_personal_department').prop('required', true);
                } else {
                    $('#otherPersonalInput').hide();
                    $('#other_personal')
                        .prop('required', false)
                        .val('');

                    $('#otherPersonalDepartmentInput').hide();
                    $('#other_personal_department')
                        .prop('required', false)
                        .val('');
                }
            }

            function toggleLocationOther() {
                if ($('#select-location').val() === 'OTHER') {
                    $('#otherLocationInput').show();
                    $('#other_location').prop('required', true);

                    $('#otherDepartmentLocationInput').show();
                    $('#other_department_location').prop('required', true);
                } else {
                    $('#otherLocationInput').hide();
                    $('#other_location')
                        .prop('required', false)
                        .val('');

                    $('#otherDepartmentLocationInput').hide();
                    $('#other_department_location')
                        .prop('required', false)
                        .val('');
                }
            }

            // ===== Event Binding =====
            $('#select-level').on('change', toggleLevel);
            $('#select-department').on('change', toggleDepartmentOther);
            $('#select-personal').on('change', togglePersonalOther);
            $('#select-location').on('change', toggleLocationOther);

            // ===== Initial Load State (IMPORTANT) =====
            toggleLevel();
            toggleDepartmentOther();
            togglePersonalOther();
            toggleLocationOther();

            console.log('Initial load: Level = ' + $('#select-level').val());
            console.log('Initial load: Department = ' + $('#select-department').val());
            console.log('Initial load: Personal = ' + $('#select-personal').val());
            console.log('Initial load: Location = ' + $('#select-location').val());

        });
    </script>
    <script>
        function fetchParentSchedule(taskId) {
            if (!taskId) {
                $('#schedule_start_parent').val('');
                $('#schedule_end_parent').val('');
                $('#wrapper_schedule_start_parent').hide();
                $('#wrapper_schedule_end_parent').hide();
                return;
            }

            fetch('/task/' + taskId)
                .then(response => response.json())
                .then(data => {
                    $('#schedule_start_parent').val(data.schedule_start ?? '-');
                    $('#schedule_end_parent').val(data.schedule_end ?? '-');
                    $('#wrapper_schedule_start_parent').show();
                    $('#wrapper_schedule_end_parent').show();
                })
                .catch(error => {

                    console.error(error);
                });
        }

        // Saat user mengubah pilihan relation task
        $('#select-relation-task').on('change', function() {
            fetchParentSchedule($(this).val());
        });

        // Saat page load (misal redirect back karena validasi gagal)
        $(document).ready(function() {
            let initialTaskId = $('#select-relation-task').val();
            if (initialTaskId) {
                fetchParentSchedule(initialTaskId);
            }
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

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/task_personal/create.blade.php ENDPATH**/ ?>