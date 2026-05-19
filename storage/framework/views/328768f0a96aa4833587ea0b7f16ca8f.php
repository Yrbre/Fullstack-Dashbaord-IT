<?php $__env->startSection('judul', 'List Activity User - ' . $user->name); ?>
<?php $__env->startSection('content'); ?>
    <div class="card mb-4">
        <div class="card-body py-2 px-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h6 class="mb-0">Filter Period</h6>
                </div>
                <div class="col d-flex align-items-center justify-content-end" style="gap: 8px;">
                    <label class="small mb-0">Start Date</label>
                    <input type="date" id="startDate" class="form-control form-control-sm" style="width: auto;">
                    <label class="small mb-0">End Date</label>
                    <input type="date" id="endDate" class="form-control form-control-sm" style="width: auto;">
                    <button class="btn btn-info btn-sm" id="btnCustomDate">Apply</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover" id="activityTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference Type</th>
                        <th>Activity</th>
                        <th>Location</th>
                        <th>Priority</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Destroy dulu jika sudah ada instance sebelumnya
            if ($.fn.DataTable.isDataTable('#activityTable')) {
                $('#activityTable').DataTable().destroy();
            }

            var dataTable = $('#activityTable').DataTable({
                autoWidth: true,
                order: [],
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ]
            });

            var filterUrl = "<?php echo e(route('activity_history.list.filter', $user->id)); ?>";

            function fetchAndRender(params) {
                $.ajax({
                    url: filterUrl,
                    data: params,
                    type: 'GET',
                    beforeSend: function() {
                        $('#btnCustomDate').prop('disabled', true).text('Loading...');
                    },
                    success: function(data) {
                        dataTable.clear();

                        if (data.length === 0) {
                            dataTable.draw();
                            return;
                        }

                        $.each(data, function(index, item) {
                            // Kolom Priority
                            var priorityBadge = '-';
                            if (item.reference_type === 'TASK') {
                                if (!item.priority) {
                                    priorityBadge =
                                        '<span class="badge badge-secondary">-</span>';
                                } else if (item.priority === 'CRITICAL') {
                                    priorityBadge =
                                        '<span class="badge badge-danger">CRITICAL</span>';
                                } else if (item.priority === 'HIGH') {
                                    priorityBadge =
                                        '<span class="badge badge-warning">HIGH</span>';
                                } else if (item.priority === 'MEDIUM') {
                                    priorityBadge =
                                        '<span class="badge badge-info">MEDIUM</span>';
                                } else if (item.priority === 'LOW') {
                                    priorityBadge =
                                        '<span class="badge badge-secondary">LOW</span>';
                                }
                            }

                            // Kolom Reference Type label
                            var refTypeLabel = '-';
                            if (item.reference_type === 'TASK') {
                                refTypeLabel = 'JOB';
                            } else if (item.reference_type === 'ACTIVITY') {
                                refTypeLabel = 'ACTIVITY PERSONAL';
                            }

                            dataTable.row.add([
                                index + 1, // #
                                refTypeLabel, // Reference Type
                                item.activity_name, // Activity
                                item.location ?? '-', // Location
                                priorityBadge, // Priority
                                item.start_time, // Start Time
                                item.end_time, // End Time
                                '<span style="color: greenyellow">' + (item.duration ??
                                    '-') + '</span>', // Duration
                                item.description ?? '-', // Description
                                item.status ?? '-' // Status
                            ]);
                        });

                        dataTable.draw();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            theme: 'dark',
                            text: 'Failed to fetch data. ' + (xhr.responseJSON?.message ?? ''),
                        });
                    },
                    complete: function() {
                        $('#btnCustomDate').prop('disabled', false).text('Apply');
                    }
                });
            }

            // Load data awal
            fetchAndRender({});

            // Custom Date Range
            $('#btnCustomDate').on('click', function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                if (!startDate || !endDate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        theme: 'dark',
                        text: 'Please select both start and end date.'
                    });
                    return;
                }

                if (startDate > endDate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        theme: 'dark',
                        text: 'Start date cannot be after end date.'
                    });
                    return;
                }

                $('.filter-btn').removeClass('active');
                fetchAndRender({
                    start_date: startDate,
                    end_date: endDate
                });
            });

        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard-it\resources\views/pages/activity_history/showListActivityUser.blade.php ENDPATH**/ ?>