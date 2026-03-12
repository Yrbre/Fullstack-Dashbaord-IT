@extends('layouts.idletemplate')

@section('content')
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
                                        <div class="form-group">
                                            <label for="activitySelect">ACTIVITY</label>
                                            <input type="text" class="form-control mb-4" id="activitySelect"
                                                placeholder="Enter idle activity" readonly
                                                value="@if ($activityHistory->reference_type == 'TASK') {{ $activityHistory->task->name }} @elseif ($activityHistory->reference_type == 'ACTIVITY') {{ $activityHistory->activity->name }} @else - @endif">
                                            <label for="activitySelect">Location</label>
                                            <input type="text" class="form-control mb-4" id="activitySelect"
                                                placeholder="Enter idle activity" readonly
                                                value="{{ $activityHistory->location ?? '-' }}">
                                            <label for="activitySelect">Time Start</label>
                                            <input type="text" class="form-control mb-4" id="activitySelect"
                                                placeholder="Enter idle activity" readonly
                                                value="{{ $activityHistory->start_time ?? '-' }}">
                                            <label for="activitySelect">Duration :</label>
                                            <span class="live-duration" style="color:greenyellow"
                                                data-start="{{ \Carbon\Carbon::parse($activityHistory->start_time)->toISOString() }}"></span>

                                            <div class="d-flex justify-content-end">
                                                @if ($activityHistory->reference_type === 'ACTIVITY')
                                                    <form
                                                        action="{{ route('dashboard_operator.complete', $activityHistory->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success mt-3">
                                                            <i class="fe fe-log-out"></i> Back to IT Office
                                                        </button>
                                                    </form>
                                                @elseif ($activityHistory->reference_type === 'TASK')
                                                @endif

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
        @push('scripts')
            <script>
                @if (session('warning'))
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        theme: 'dark',
                        text: '{{ session('warning') }}',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                @endif
            </script>
        @endpush



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
    @endsection
