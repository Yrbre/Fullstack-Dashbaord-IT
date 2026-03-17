@extends('layouts.template')
@section('judul', 'DEPARTMENT ACTIVITY MONITORING')
@section('content')
    <style>
        .link-black {
            color: inherit !important;
            text-decoration: none !important;
        }
    </style>
    <meta http-equiv="refresh" content="60">
    <div class="container-fluid py-4">
        <div class="row mx-auto justify-content-center">
            <div class="col-6">
                <h2 class="page-title"> <i class="fe fe-home" style="color:aqua"> </i> IT Office</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Member Name</td>
                                            <td>Activity</td>
                                            <td>Start Time</td>
                                            <td>Duration</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($standBy as $item)
                                            <tr>
                                                <td><a class="link-black"
                                                        href="{{ route('activity_history.list', $item->user->id) }}">{{ $item->user->name }}</a>
                                                </td>
                                                <td>{{ $item->activity->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i') }}</td>
                                                <td style="color:greenyellow">
                                                    <span class="live-duration"
                                                        data-start="{{ \Carbon\Carbon::parse($item->start_time)->toISOString() }}"></span>
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

            <div class="col-6">
                <h2 class="page-title"> <i class="fe fe-radio" style="color:chartreuse"></i> Outside</h2>
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Member Name</td>
                                            <td>Location</td>
                                            <td>Activity</td>
                                            <td>Start Time</td>
                                            <td>Duration</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($outSide as $item)
                                            <tr>
                                                <td><a class="link-black"
                                                        href="{{ route('activity_history.list', $item->user->id) }}">{{ $item->user->name }}</a>
                                                </td>
                                                <td>{{ $item->location }}</td>
                                                @if ($item->reference_type === 'ACTIVITY')
                                                    <td>{{ $item->activity->name }}</td>
                                                @elseif ($item->reference_type === 'TASK')
                                                    <td>{{ $item->task->name }}</td>
                                                @else
                                                    <td> - </td>
                                                @endif
                                                <td>{{ \Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i') }}
                                                </td>
                                                <td style="color:greenyellow">
                                                    <span class="live-duration"
                                                        data-start="{{ \Carbon\Carbon::parse($item->start_time)->toISOString() }}"></span>
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
        <div class="row mx-auto my-4 justify-content-center">
            <div class="col-12">
                <h2 class="page-title"> <i class="fe fe-server" style="color:coral"></i> Activity Progress</h2>
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Activity Name</td>
                                    <td>Responsibility</td>
                                    <td>Client</td>
                                    <td>Progress</td>
                                    <td>Status</td>
                                    <td class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($taskProgress as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->enduser->department ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 position-relative" style="height: 20px;">
                                                    <div class="progress-bar {{ $item->progress_color }}"
                                                        role="progressbar" style="width: {{ $item->progress }}%;"
                                                        aria-valuenow="{{ $item->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                    <span class="position-absolute w-100 text-center fw-bold"
                                                        style="top: 0; left: 0; line-height: 20px; font-size: 12px; color: #fff; text-shadow: 0 0 3px rgba(0,0,0,0.7);">
                                                        {{ $item->progress }}%
                                                    </span>
                                                </div>
                                                <small class="ms-2 text-muted">{{ $item->progress_label }}</small>
                                            </div>
                                        </td>
                                        <td>{{ $item->status }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('task.show', $item->id) }}"
                                                class="btn btn-sm btn-primary">View</a>
                                            @if ((int) $item->progress === 100)
                                                <form action="{{ route('task.complete', $item->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirmComplete(event)">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success">Completed</button>
                                                </form>
                                            @endif
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
    </script>
    <script>
        setTimeout(function() {
            location.reload();
        }, 30000);
    </script>
    <script>
        function confirmComplete(event) {
            event.preventDefault();
            const form = event.target;
            Swal.fire({
                icon: 'question',
                title: 'Mark as Completed?',
                text: 'Are you sure you want to mark this Activity as completed?',
                theme: 'dark',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Yes, Complete',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }
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
