@extends('layouts.template')
@section('judul', 'List Activity User - ' . $user->name)
@section('content')
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
            <table class="table datatables table-hover" id="dataTable-1">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Activity Name</th>
                        <th>End User</th>
                        <th>Location</th>
                        <th>Progress</th>
                        <th>Scheduled Start/End</th>
                        <th>Actual Start/End</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taskList as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->enduser->name ?? $item->enduser->department }}</td>
                            <td>{{ $item->location->department }} - {{ $item->location->location }}</td>
                            <td>{{ $item->progress }}%</td>
                            <td>{{ \Carbon\Carbon::parse($item->schedule_start)->format('d-m-Y H:i') }} <br>
                                {{ \Carbon\Carbon::parse($item->schedule_end)->format('d-m-Y H:i') }}</td>
                            <td>{{ $item->actual_start ? \Carbon\Carbon::parse($item->actual_start)->format('d-m-Y H:i') : '-' }}
                                <br>
                                {{ $item->actual_end ? \Carbon\Carbon::parse($item->actual_end)->format('d-m-Y H:i') : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        var dataTable;

        $(document).ready(function() {
            dataTable = $('#dataTable-1').DataTable({
                autoWidth: true,
                order: [],
                "lengthMenu": [
                    [16, 32, 64, -1],
                    [16, 32, 64, "All"]
                ]
            });
        });

        var filterUrl = "{{ route('activity_history.list.filter', $user->id) }}";

        function fetchAndRender(params) {
            $.ajax({
                url: filterUrl,
                data: params,
                type: 'GET',
                success: function(data) {
                    dataTable.clear();
                    data.forEach(function(item) {
                        dataTable.row.add([
                            item.activity_name,
                            item.location,
                            item.reference_type,
                            item.start_time,
                            item.end_time
                        ]);
                    });
                    dataTable.draw();
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        theme: 'dark',
                        text: 'Failed to fetch data.',
                    });
                }
            });
        }

        // Quick filter buttons
        $('.filter-btn').on('click', function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            $('#startDate').val('');
            $('#endDate').val('');

            var filter = $(this).data('filter');
            if (filter === 'all') {
                fetchAndRender({});
            } else {
                fetchAndRender({
                    filter: filter
                });
            }
        });

        // Custom date range
        $('#btnCustomDate').on('click', function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            if (!startDate || !endDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    theme: 'dark',
                    text: 'Please select both start and end date.',
                });
                return;
            }

            if (startDate > endDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    theme: 'dark',
                    text: 'Start date cannot be after end date.',
                });
                return;
            }

            $('.filter-btn').removeClass('active');
            fetchAndRender({
                start_date: startDate,
                end_date: endDate
            });
        });
    </script>
@endsection
