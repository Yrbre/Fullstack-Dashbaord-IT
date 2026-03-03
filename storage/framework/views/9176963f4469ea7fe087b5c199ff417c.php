<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="mx-auto">
            <div class="d-flex justify-content-center items-center">
                <div class="col-12">
                    <h2 class="page-title justify-content-center"> <i class="fe fe-activity" style="color:aqua"> </i>TASK
                        NOW
                    </h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div>
                                        <div class="form-group">
                                            <form method="POST"
                                                action="<?php echo e(route('dashboard_operator.update_task', $task->id)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <label for="activitySelect">TASK ACTIVE</label>
                                                <input type="text" class="form-control mb-4" id="activitySelect"
                                                    placeholder="Enter idle activity" readonly
                                                    value="<?php echo e($task->name ?? '-'); ?>">


                                                <label for="activitySelect">Category</label>
                                                <input type="text" class="form-control mb-4" id="activitySelect"
                                                    placeholder="Enter idle activity" readonly
                                                    value="<?php echo e($task->category->type ?? '-'); ?> - <?php echo e($task->category->name ?? '-'); ?>">


                                                <label for="simple-select2">Status</label>
                                                <select class="form-control select2 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="select-status" name="status">
                                                    <optgroup label="Select Status Type">
                                                        <option value="ON DUTY"
                                                            <?php echo e(old('status', $task->status) == 'ON DUTY' ? 'selected' : ''); ?>>
                                                            ON DUTY
                                                        </option>
                                                        <option value="COMPLETED"
                                                            <?php echo e(old('status', $task->status) == 'COMPLETED' ? 'selected' : ''); ?>>
                                                            COMPLETED
                                                        </option>
                                                        <option value="ON HOLD"
                                                            <?php echo e(old('status', $task->status) == 'ON HOLD' ? 'selected' : ''); ?>>
                                                            ON HOLD
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

                                                <label for="simple-select2" class="mt-4">Progress</label>
                                                <select
                                                    class="form-control mb-4 select2 <?php $__errorArgs = ['progress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="select-progress" name="progress">
                                                    <optgroup label="Select Progress">
                                                        <option value="" selected disabled>Select Progress</option>
                                                        <option value="0"
                                                            <?php echo e(old('progress', $task->progress) == 0 ? 'selected' : ''); ?>>
                                                            0%
                                                        </option>
                                                        <option value="10"
                                                            <?php echo e(old('progress', $task->progress) == 10 ? 'selected' : ''); ?>>
                                                            10%
                                                        </option>
                                                        <option value="25"
                                                            <?php echo e(old('progress', $task->progress) == 25 ? 'selected' : ''); ?>>
                                                            25%
                                                        </option>
                                                        <option value="50"
                                                            <?php echo e(old('progress', $task->progress) == 50 ? 'selected' : ''); ?>>
                                                            50%
                                                        </option>
                                                        <option value="75"
                                                            <?php echo e(old('progress', $task->progress) == 75 ? 'selected' : ''); ?>>
                                                            75%
                                                        </option>
                                                        <option value="100"
                                                            <?php echo e(old('progress', $task->progress) == 100 ? 'selected' : ''); ?>>
                                                            100%
                                                        </option>
                                                    </optgroup>
                                                </select>


                                                <label for="description">Description</label>
                                                <textarea class="form-control mb-4 <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="description" id="description"
                                                    rows="3" placeholder="Enter description here..."><?php echo e(old('description', $task->description)); ?></textarea>


                                                <label for="activitySelect">Time Start</label>
                                                <input type="text" class="form-control mb-4" id="activitySelect"
                                                    placeholder="Enter idle activity" readonly
                                                    value="<?php echo e($task->actual_start ?? '-'); ?>">
                                                <label for="activitySelect">Duration :</label>
                                                <span class="live-duration" style="color:greenyellow"
                                                    data-start="<?php echo e(\Carbon\Carbon::parse($task->actual_start)->toISOString()); ?>"></span>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mt-4">Update Task</button>
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $__env->startPush('scripts'); ?>
        <script>
            <?php if(session('warning')): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    theme: 'dark',
                    text: '<?php echo e(session('warning')); ?>',
                    timer: 2000,
                    showConfirmButton: false,
                });
            <?php endif; ?>
        </script>
    <?php $__env->stopPush(); ?>



    <script>
        function formatDuration(seconds) {
            const abs = Math.abs(seconds);
            const isFuture = seconds < 0;
            const days = Math.floor(abs / 86400);
            const hours = Math.floor((abs % 86400) / 3600);
            const minutes = Math.floor((abs % 3600) / 60);


            let parts = [];
            if (days > 0) parts.push(days + 'd');
            if (hours > 0) parts.push(hours + 'h');
            if (minutes > 0) parts.push(minutes + 'm');


            return (isFuture ? 'in ' : '') + parts.join(' ') + (isFuture ? '' : ' ago');
        }

        function updateDurations() {
            document.querySelectorAll('.live-duration').forEach(function(el) {
                const start = new Date(el.dataset.start);
                const now = new Date();
                const diffSeconds = (now - start) / 1000;
                el.textContent = formatDuration(diffSeconds);
            });
        }

        updateDurations();
        setInterval(updateDurations, 1000);

        // Blokir tombol back browser
        history.pushState(null, null, location.href);
        window.addEventListener('popstate', function() {
            history.pushState(null, null, location.href);
        });

        // Blokir keyboard shortcut Alt+Left (back)
        document.addEventListener('keydown', function(e) {
            if ((e.altKey && e.key === 'ArrowLeft') || e.key === 'BrowserBack') {
                e.preventDefault();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.idletemplate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/dashboard_operator/idle_task.blade.php ENDPATH**/ ?>