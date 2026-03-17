<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo e(asset('dark/assets/images/LogoTifico.png')); ?>">
    <title>Dashboard IT</title>
    <!-- Simple bar CSS -->
    <?php echo $__env->make('layouts.style', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body class="vertical  dark  collapsed" data-simplebar>

    <?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main role="main" class="main-content">
        <?php echo $__env->make('layouts.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </main> <!-- main -->
    </div> <!-- .wrapper -->

</body>
<script>
    $('#export-data').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Export Activity List",
            html: `
            <div class="d-flex justify-content-center">
                <div class="text-left">
                    <label for="swal-start-date" class="mb-1">Start Date</label>
                    <input type="date" id="swal-start-date" class="swal2-input" style="margin:.25em auto 1em;">
                    <div class="mt-2 p-2">
                    <label for="swal-end-date" class="mb-1">End Date</label>
                    <input type="date" id="swal-end-date" class="swal2-input" style="margin:.25em auto;">
                    </div>
                    <small style="display:block;opacity:.8;margin-top:.75em;">Kosongkan jika ingin export semua data.</small>
                </div>
            </div>
            `,
            theme: "dark",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Export",
            preConfirm: () => {
                const startDate = document.getElementById('swal-start-date').value;
                const endDate = document.getElementById('swal-end-date').value;

                if ((startDate && !endDate) || (!startDate && endDate)) {
                    Swal.showValidationMessage('Start Date dan End Date harus diisi keduanya.');
                    return false;
                }

                if (startDate && endDate && startDate > endDate) {
                    Swal.showValidationMessage('End Date tidak boleh lebih kecil dari Start Date.');
                    return false;
                }

                return {
                    startDate,
                    endDate
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Exporting!",
                    text: "Your data is being exported.",
                    icon: "success",
                    theme: "dark",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    const params = new URLSearchParams();
                    if (result.value?.startDate && result.value?.endDate) {
                        params.append('start_date', result.value.startDate);
                        params.append('end_date', result.value.endDate);
                    }

                    const queryString = params.toString();
                    window.location.href = queryString ?
                        `/export-task-department?${queryString}` :
                        '/export-task-department';
                });
            }
        });
    });
</script>

</html>
<?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/layouts/template.blade.php ENDPATH**/ ?>