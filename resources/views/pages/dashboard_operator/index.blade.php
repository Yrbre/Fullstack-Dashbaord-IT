@extends('layouts.template')
@section('judul', 'MY JOB ASSIGNMENT')
@section('content')
    <div class="container-fluid py-4">
        <div class="mx-auto">
            <div class="row">
                <div class="col-8">

                    <h4 class="page-title justify-content-center"><i class="fe fe-send" style="color:orange"></i>
                        JOB ASSIGNMENT</h4>
                    <div class="">
                        <div class="card shadow">
                            <div class="card-body">

                                <!-- Div dengan scroll untuk tabel -->
                                <div style="max-height:400px; overflow-y:auto;" data-simplebar>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Activity Name</th>
                                                <th>Schedule Start</th>
                                                <th>Schedule End</th>
                                                <th>Priority</th>
                                                <th>Progres</th>
                                                <th>Location</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($taskReady as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->schedule_start)->format('d M Y H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($item->schedule_end)->format('d M Y H:i') }}
                                                    </td>
                                                    <td>
                                                        @if ($item->priority === 'CRITICAL')
                                                            <span class="badge badge-danger">{{ $item->priority }}</span>
                                                        @elseif ($item->priority === 'HIGH')
                                                            <span class="badge badge-warning">{{ $item->priority }}</span>
                                                        @elseif ($item->priority === 'MEDIUM')
                                                            <span class="badge badge-info">{{ $item->priority }}</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{ $item->priority }}</span>
                                                        @endif
                                                    <td>{{ $item->progress }}%</td>
                                                    <td>{{ $item->location->location ?? '-' }}</td>
                                                    <td>
                                                        <a href="{{ route('active_task.index', $item->id) }}"
                                                            class="btn btn-sm btn-primary">Take</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 justify-content-center">
                    <div class="d-flex flex-column align-items-center text-center  h-100">
                        <!-- Icon dan Judul -->
                        <div class="mb-4">
                            <div class="activity-icon-wrapper rounded-circle mb-3">
                            </div>

                            <h4 class="page-title font-weight-bold mb-0"> <i class="fe fe-list text-primary"></i> PERSONAL
                                ACTIVITY
                            </h4>
                        </div>

                        <!-- Button -->
                        <button type="button" id="btnChooseActivity" class="btn btn-primary px-4 py-2 shadow-sm">
                            SELECT
                        </button>
                    </div>
                </div>
            </div>

            <div id="activityListTemplate" style="display: none;">
                <div style="max-height:400px; overflow-y:auto;" data-simplebar>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <td class="text-center">Activity</td>
                                <td class="text-center">Location</td>
                                <td class="text-center">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activityList as $item)
                                <tr>
                                    <td class="text-center">{{ $item->name }}</td>
                                    <td class="text-center">{{ $item->location }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary btn-take-activity"
                                            data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                            data-location="{{ $item->location }}"
                                            data-url="{{ route('dashboard_operator.take', $item->id) }}">
                                            Take
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-body">

                                    <div style="max-height:400px; overflow-y:auto;"data-simplebar>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td class="text-center">Activity</td>
                                                    <td class="text-center">Location</td>
                                                    <td class="text-center">Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($activityList as $item)
                                                    <tr>
                                                        <td class="text-center">{{ $item->name }}</td>
                                                        <td class="text-center">{{ $item->location }}</td>
                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary btn-take-activity"
                                                                data-id="{{ $item->id }}"
                                                                data-name="{{ $item->name }}"
                                                                data-location="{{ $item->location }}"
                                                                data-url="{{ route('dashboard_operator.take', $item->id) }}">
                                                                Take
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> --}}

        </div>
        <div class="row
                            my-4 justify-content-center" data-simplebar>
            <div class="col-12">
                <h2 class="page-title"> <i class="fe fe-server" style="color:coral"></i> Activity Completed
                </h2>
                <div class="card shadow">
                    <div class="card-body">
                        <div style="max-height:400px; overflow-y:auto;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-center">#</td>
                                        <td class="text-center">Activity Name</td>
                                        <td class="text-center">Progress</td>
                                        <td class="text-center">Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($taskCompleted as $task)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $task->name }}</td>
                                            <td class="text-center">{{ $task->progress }}%</td>
                                            <td class="text-center">
                                                <span class="badge badge-success">Completed</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <form id="takeForm" method="POST" style="display:none;">
        @csrf
    </form>


    <script>
        $(document).on('click', '#btnChooseActivity', function() {
            Swal.fire({
                title: 'Choose Activity',
                theme: 'dark',
                width: '900px',
                html: $('#activityListTemplate').html(),
                showConfirmButton: false,
                showCloseButton: true
            });
        });

        function escapeHtml(text) {
            return $('<div>').text(text || '-').html();
        }

        $(document).on('click', '.btn-take-activity', function() {
            var button = $(this);
            var activityName = button.data('name');
            var activityLocation = button.data('location');
            var takeUrl = button.data('url');

            Swal.fire({
                icon: 'question',
                title: 'Confirm Take Activity',
                theme: 'dark',
                html: '<div class="text-center">' +
                    '<p class="mb-2">Are you sure you want to take this activity?</p>' +
                    '<p class="mb-1"><strong>Activity Name:</strong> &nbsp;' + escapeHtml(activityName) +
                    '</p>' +
                    '<p class="mb-0"><strong>Location:</strong> &nbsp;' + escapeHtml(activityLocation) +
                    '</p>' +
                    '</div>',
                showCancelButton: true,
                confirmButtonText: 'Yes, Take Activity',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#2f7cf6',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#takeForm').attr('action', takeUrl).trigger('submit');
                }
            });
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
