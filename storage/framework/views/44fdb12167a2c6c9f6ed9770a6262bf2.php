<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="mx-auto">
            <div class="d-flex justify-content-center items-center">
                <div class="col-12">
                    <h2 class="page-title justify-content-center"> <i class="fe fe-activity" style="color:aqua"> </i>ACTIVITY
                        NOW
                    </h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-body">
                                    <div>
                                        <form action="<?php echo e(route('dashboard_operator.complete', $activityHistory->id)); ?>"
                                            method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?> <div class="form-group">
                                                <label for="activitySelect">ACTIVITY</label>
                                                <input type="text" class="form-control mb-4" id="activitySelect"
                                                    placeholder="Enter idle activity" readonly
                                                    value="<?php if($activityHistory->reference_type == 'JOB'): ?> <?php echo e($activityHistory->activity->name); ?> <?php elseif($activityHistory->reference_type == 'ACTIVITY'): ?> <?php echo e($activityHistory->activity->name); ?> <?php else: ?> - <?php endif; ?>">
                                                <label for="activitySelect">Location</label>
                                                <input type="text" class="form-control mb-4" id="activitySelect"
                                                    placeholder="Enter idle activity" readonly
                                                    value="<?php echo e($activityHistory->location ?? '-'); ?>">
                                                <label for="activitySelect">Time Start</label>
                                                <input type="text" class="form-control mb-4" id="activitySelect"
                                                    placeholder="Enter idle activity" readonly
                                                    value="<?php echo e($activityHistory->start_time ?? '-'); ?>">
                                                <?php if($activityHistory->reference_type == 'JOB'): ?>
                                                    <label for="activitySelect">End User - Description</label>
                                                    <textarea name='description' type="text" class="form-control mb-4 uppercase" id="activitySelect"><?php echo e(old('description', $activityHistory->description) ?? '-'); ?></textarea>
                                                <?php elseif($activityHistory->reference_type == 'ACTIVITY' && $activityHistory->reference_id == 8): ?>
                                                    <label for="activitySelect">Description</label>
                                                    <textarea name='description' type="text" class="form-control mb-4 uppercase" id="activitySelect"><?php echo e(old('description', $activityHistory->description) ?? '-'); ?></textarea>
                                                <?php endif; ?>

                                                <label for="activitySelect">Duration :</label>
                                                <span class="live-duration" style="color:greenyellow"
                                                    data-start="<?php echo e(\Carbon\Carbon::parse($activityHistory->start_time)->toISOString()); ?>"></span>

                                                <div class="d-flex justify-content-end">
                                                    <a href="<?php echo e(route('dashboard_operator.index')); ?>"
                                                        class="btn btn-secondary mt-3 mr-2">
                                                        Back
                                                    </a>
                                                    <button type="submit" class="btn btn-success mt-3">
                                                        <i class="fe fe-log-out"></i> Back to IT Office
                                                    </button>
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
        <script>
            <?php if(session('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    theme: 'dark',
                    text: '<?php echo e(session('error')); ?>',
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

<?php echo $__env->make('layouts.idletemplate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/dashboard_operator/idle.blade.php ENDPATH**/ ?>