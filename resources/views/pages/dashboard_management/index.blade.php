@extends('layouts.template')
@section('content')
    <meta http-equiv="refresh" content="60">
    <h1>Monitoring Dashboard</h1>
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
                                            <td>Location</td>
                                            <td>Task/Activity</td>
                                            <td>Start Time</td>
                                            <td>Duration</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($standBy as $item)
                                            <tr>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->location }}</td>
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
                                            <td>Task/Activity</td>
                                            <td>Start Time</td>
                                            <td>Duration</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($outSide as $item)
                                            <tr>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->location }}</td>
                                                @if ($item->reference_type === 'ACTIVITY')
                                                    <td>{{ $item->activity->name }}</td>
                                                @elseif ($item->reference_type === 'TASK')
                                                    <td>{{ $item->task->name }}</td>
                                                @else
                                                    <td> - </td>
                                                @endif
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
        </div>
        <div class="row mx-auto my-4 justify-content-center">
            <div class="col-12">
                <h2 class="page-title"> <i class="fe fe-server" style="color:coral"></i> Task Progress</h2>
                <div class="card shadow">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Task Name</td>
                                    <td>Responsibility</td>
                                    <td>Client</td>
                                    <td>Progress</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($taskProgress as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->enduser->department ?? '-' }}</td>
                                        <td>{{ $item->progress }}%</td>
                                        <td>{{ $item->status }}</td>
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
@endsection
