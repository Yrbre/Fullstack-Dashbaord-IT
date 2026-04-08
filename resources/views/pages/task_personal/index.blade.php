@extends('layouts.template')
@section('judul', 'Job Assignment List')
@section('content')

    <div class="container-fluid">
        <div class="col-12">
            <div class="mb-4 d-flex justify-content-end">
                <a href="{{ route('task_personal.create') }}" class="btn btn-primary">Create New</a>
            </div>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table Job Assignment</h5>
                            <p class="card-text"></p>
                            <table class="table datatables" id="dataTable-1">
                                @if (Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT', 'ADMIN']))
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Parent Activity</th>
                                            <th>Weight</th>
                                            <th>Deliver By</th>
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

                                        @foreach ($ManagementTask as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->relation_name ?? '-' }}</td>
                                                <td>{{ $item->task_load ?? '-' }}%</td>
                                                <td>{{ $item->deliveredUser?->name ?? ($item->delivered ?? '-') }}</td>
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
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="{{ route('task_personal.edit', $item->id) }}">Edit</a>
                                                            <a class="dropdown-item js-delete-task" data-toggle="modal"
                                                                data-target="#deleteModal" data-id="{{ $item->id }}"
                                                                data-name="{{ $item->name }}"
                                                                data-status="{{ $item->status }}"
                                                                data-url="{{ route('task_personal.destroy', $item->id) }}"
                                                                href="#">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                @endif
                                @if (Auth::check() && in_array(Auth::user()->role, ['OPERATOR']))
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Parent Activity</th>
                                            <th>Weight</th>
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
                                            @if ($item->schedule_start != now()->format('Y-m-d H:i') && $item->schedule_start > now())
                                                <tr style="color:yellow">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->relation_name ?? '-' }}</td>
                                                    <td>{{ $item->task_load ?? '-' }}%</td>
                                                    <td>{{ $item->user->name ?? '-' }}</td>
                                                    <td>
                                                        @if ($item->priority === 'CRITICAL')
                                                            <span class="badge badge-danger">{{ $item->priority }}</span>
                                                        @elseif ($item->priority === 'HIGH')
                                                            <span class="badge badge-warning">{{ $item->priority }}</span>
                                                        @elseif ($item->priority === 'MEDIUM')
                                                            <span class="badge badge-info">{{ $item->priority }}</span>
                                                        @elseif ($item->priority === 'LOW')
                                                            <span
                                                                class="badge badge-secondary">{{ $item->priority }}</span>
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
                                                            <button class="btn btn-sm btn-info dropdown-toggle"
                                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('task_personal.edit', $item->id) }}">Edit</a>
                                                                <a class="dropdown-item js-delete-task" data-toggle="modal"
                                                                    data-target="#deleteModal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-name="{{ $item->name }}"
                                                                    data-status="{{ $item->status }}"
                                                                    data-url="{{ route('task_personal.destroy', $item->id) }}"
                                                                    href="#">Remove</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->relation_name ?? '-' }}</td>
                                                    <td>{{ $item->task_load ?? '-' }}%</td>
                                                    <td>{{ $item->user->name ?? '-' }}</td>
                                                    <td>
                                                        @if ($item->priority === 'CRITICAL')
                                                            <span class="badge badge-danger">{{ $item->priority }}</span>
                                                        @elseif ($item->priority === 'HIGH')
                                                            <span class="badge badge-warning">{{ $item->priority }}</span>
                                                        @elseif ($item->priority === 'MEDIUM')
                                                            <span class="badge badge-info">{{ $item->priority }}</span>
                                                        @elseif ($item->priority === 'LOW')
                                                            <span
                                                                class="badge badge-secondary">{{ $item->priority }}</span>
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
                                                            <button class="btn btn-sm btn-info dropdown-toggle"
                                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a class="dropdown-item"
                                                                    href="{{ route('task_personal.edit', $item->id) }}">Edit</a>
                                                                <a class="dropdown-item js-delete-task" data-toggle="modal"
                                                                    data-target="#deleteModal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-name="{{ $item->name }}"
                                                                    data-status="{{ $item->status }}"
                                                                    data-url="{{ route('task_personal.destroy', $item->id) }}"
                                                                    href="#">Remove</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                @endif
                                </tbody>
                            </table>
                            <form method="POST" id="deleteForm">
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
        // Handle delete modal
        $(document).on('click', '.js-delete-task', function(e) {
            e.preventDefault();
            var button = $(this);
            var name = button.data('name');
            var status = button.data('status');
            var url = button.data('url');

            Swal.fire({
                title: 'Confirm Delete',
                icon: 'warning',
                theme: 'dark',
                html: '<p>Are you sure you want to delete this Activity?</p>' +
                    '<div class="justify-content-center">' +
                    '<strong>Activity Name :</strong> ' + name + '<br>' +
                    '<strong>Status :</strong> ' + status +
                    '</div>',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#deleteForm');
                    form.attr('action', url);
                    form.submit();
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
