@extends('layouts.template')
@section('judul', 'Activity Department List')
@section('content')

    <div class="container-fluid">
        <div class="col-12">
            <div class="mb-4 d-flex justify-content-end">
                <a href="{{ route('task.create') }}" class="btn btn-primary">Create New</a>
                {{-- <a href="#" id="export-data" class="btn btn-secondary">Export</a> --}}
            </div>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table Activity Department</h5>
                            <p class="card-text"></p>
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Assign to</th>
                                        <th>Priority</th>
                                        <th>Progress</th>
                                        <th>Schedule(S/E)</th>
                                        <th>Actual (S/E)</th>
                                        <th>On Timeline</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->task_level }}</td>
                                            <td>{{ $item->user->name ?? '-' }}</td>
                                            <td>
                                                @if ($item->priority === 'CRITICAL')
                                                    <span class="badge badge-danger">{{ $item->priority }}</span>
                                                @elseif ($item->priority === 'HIGH')
                                                    <span class="badge badge-warning">{{ $item->priority }}</span>
                                                @elseif ($item->priority === 'MEDIUM')
                                                    <span class="badge badge-info">{{ $item->priority }}</span>
                                                @elseif ($item->priority === 'LOW')
                                                    <span class="badge badge-secondary">{{ $item->priority }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $item->progress }}%</td>
                                            <td>{{ \Carbon\Carbon::parse($item->schedule_start)->format('d-m-Y H:i') }}
                                                <br />
                                                {{ \Carbon\Carbon::parse($item->schedule_end)->format('d-m-Y H:i') }}
                                            </td>
                                            <td>{{ $item->actual_start ? \Carbon\Carbon::parse($item->actual_start)->format('d-m-Y H:i') : '-' }}
                                                <br />
                                                {{ $item->actual_end ? \Carbon\Carbon::parse($item->actual_end)->format('d-m-Y H:i') : '-' }}
                                            </td>
                                            <td>{{ $item->diffTime ?? '-' }}</td>
                                            <td>
                                                @if ($item->status === 'COMPLETED')
                                                    <span class="badge badge-success">{{ $item->status }}</span>
                                                @elseif ($item->status === 'ON DUTY')
                                                    <span class="badge badge-primary">{{ $item->status }}</span>
                                                @elseif ($item->status === 'NEW')
                                                    <span class="badge badge-info">{{ $item->status }}</span>
                                                @elseif ($item->status === 'CANCELED')
                                                    <span class="badge badge-warning">{{ $item->status }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $item->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('task.show', $item->id) }}">View</a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('task.edit', $item->id) }}">Edit</a>
                                                        <a class="dropdown-item js-delete-task"
                                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                            data-status="{{ $item->status }}"
                                                            data-url="{{ route('task.destroy', $item->id) }}"
                                                            href="#">Remove</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <form id="deleteForm" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('click', '.js-delete-task', function(e) {
            e.preventDefault();

            var button = $(this);
            var taskName = button.data('name');
            var statusName = button.data('status');
            var deleteUrl = button.data('url');

            Swal.fire({
                title: 'Confirm Delete',
                icon: 'warning',
                theme: 'dark',
                html: '<p>Are you sure you want to delete this Activity?</p>' +
                    '<div class="justify-content-center">' +
                    '<strong>Activity Name :</strong> ' + taskName + '<br>' +
                    '<strong>Status :</strong> ' + statusName +
                    '</div>' +
                    '<p class="mt-3 mb-0 text-muted">This action cannot be undone.</p>',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#deleteForm');
                    form.attr('action', deleteUrl);
                    form.trigger('submit');
                }
            });
        });
    </script>
    <script>
        $('#dataTable-1').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [16, 32, 64, -1],
                [16, 32, 64, "All"]
            ]
        });
    </script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                theme: 'dark',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false,
            });
        @endif
    </script>


@endsection
