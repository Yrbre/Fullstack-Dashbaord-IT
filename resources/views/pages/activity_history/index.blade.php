@extends('layouts.template')
@section('judul', 'Activity History')
@section('content')

    @if (Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT', 'ADMIN']))
        <div class="container-fluid">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 my-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Table Activity History</h5>
                                <p class="card-text"></p>
                                <table class="table datatables table-hover" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Reference Type</th>
                                            <th>Activity</th>
                                            <th>Location</th>
                                            <th>Priority</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($activity_history as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                @if ($item->reference_type === 'TASK')
                                                    <td>ACTIVITY PERSONAL</td>
                                                @elseif ($item->reference_type === 'ACTIVITY')
                                                    <td>ACTIVITY</td>
                                                @endif
                                                @if ($item->reference_type === 'TASK')
                                                    <td>{{ $item->task->name ?? '-' }}</td>
                                                @elseif ($item->reference_type === 'ACTIVITY')
                                                    <td>{{ $item->activity->name ?? '-' }}</td>
                                                @else
                                                    <td>-</td>
                                                @endif

                                                <td>
                                                    {{ $item->location ?? '-' }}
                                                </td>
                                                <td>
                                                    @if ($item->reference_type === 'TASK')
                                                        @if ($item->task->priority === 'CRITICAL')
                                                            <span
                                                                class="badge badge-danger">{{ $item->task->priority }}</span>
                                                        @elseif ($item->task->priority === 'HIGH')
                                                            <span
                                                                class="badge badge-warning">{{ $item->task->priority }}</span>
                                                        @elseif ($item->task->priority === 'MEDIUM')
                                                            <span
                                                                class="badge badge-info">{{ $item->task->priority }}</span>
                                                        @elseif ($item->task->priority === 'LOW')
                                                            <span
                                                                class="badge badge-secondary">{{ $item->task->priority }}</span>
                                                        @endif
                                                    @elseif ($item->reference_type === 'ACTIVITY')
                                                        -
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i') : '-' }}
                                                </td>
                                                <td>{{ $item->end_time ? \Carbon\Carbon::parse($item->end_time)->format('d-m-Y H:i') : '-' }}
                                                </td>
                                                <td style="color: greenyellow">
                                                    {{ $item->duration ?? '-' }}
                                                </td>
                                                <td>{{ $item->status ?? '-' }}</td>

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
    @elseif (Auth::check() && in_array(Auth::user()->role, ['OPERATOR']))
        <div class="container-fluid">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 my-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Table Activity History</h5>
                                <p class="card-text"></p>
                                <table class="table datatables table-hover" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Reference Type</th>
                                            <th>Activity</th>
                                            <th>Location</th>
                                            <th>Priority</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($activityHistoryOp as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                @if ($item->reference_type === 'TASK')
                                                    <td>ACTIVITY PERSONAL</td>
                                                @elseif ($item->reference_type === 'ACTIVITY')
                                                    <td>ACTIVITY</td>
                                                @endif
                                                @if ($item->reference_type === 'TASK')
                                                    <td>{{ $item->task->name ?? '-' }}</td>
                                                @elseif ($item->reference_type === 'ACTIVITY')
                                                    <td>{{ $item->activity->name ?? '-' }}</td>
                                                @else
                                                    <td>-</td>
                                                @endif

                                                <td>
                                                    {{ $item->location ?? '-' }}
                                                </td>
                                                <td>
                                                    @if ($item->reference_type === 'TASK')
                                                        @if ($item->task->priority === 'CRITICAL')
                                                            <span
                                                                class="badge badge-danger">{{ $item->task->priority }}</span>
                                                        @elseif ($item->task->priority === 'HIGH')
                                                            <span
                                                                class="badge badge-warning">{{ $item->task->priority }}</span>
                                                        @elseif ($item->task->priority === 'MEDIUM')
                                                            <span
                                                                class="badge badge-info">{{ $item->task->priority }}</span>
                                                        @elseif ($item->task->priority === 'LOW')
                                                            <span
                                                                class="badge badge-secondary">{{ $item->task->priority }}</span>
                                                        @endif
                                                    @elseif ($item->reference_type === 'ACTIVITY')
                                                        -
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $item->start_time ? \Carbon\Carbon::parse($item->start_time)->format('d-m-Y H:i') : '-' }}
                                                </td>
                                                <td>{{ $item->end_time ? \Carbon\Carbon::parse($item->end_time)->format('d-m-Y H:i') : '-' }}
                                                </td>
                                                <td style="color: greenyellow">
                                                    {{ $item->duration ?? '-' }}
                                                </td>
                                                <td>{{ $item->status ?? '-' }}</td>

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
    @endif
    {{-- DataTableScript --}}
    <script>
        $('#dataTable-1').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [16, 32, 64, -1],
                [16, 32, 64, "All"]
            ]
        });
    </script>
@endsection
