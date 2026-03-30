@extends('layouts.template')
@section('judul', 'Activity Department Detail')
@section('content')
    <div class="container-fluid py-4">

        <!-- ===== ROW ATAS (FULL 12 COL) ===== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-start">
                            <h2 class="title">{{ $task->name }}</h2>
                            <span class="badge badge-info ml-4">{{ $task->status }}</span>
                        </div>
                    </div>
                    <div class="card-body  border-bottom">
                        <div class="row mb-3">
                            <h6 class="subtitle col-6"> <i class="fe fe-user-check"> </i> Lead :
                                {{ $task->user->name ?? '-' }}</h6>
                            <h6 class="subtitle col-6"> <i class="fe fe-airplay"> </i> Client :
                                {{ $task->enduser->department ?? '-' }}</h6>
                        </div>
                        <div class="row mb-3">
                            <h6 class="subtitle col-6"> <i class="fe fe-calendar"> </i> Schedule :
                                {{ $task->schedule_start ? \Carbon\Carbon::parse($task->schedule_start)->format('d M Y') : '-' }}
                                -
                                {{ $task->schedule_end ? \Carbon\Carbon::parse($task->schedule_end)->format('d M Y') : '-' }}
                            </h6>
                            <h6 class="subtitle col-6"> <i class="fe fe-calendar"> </i> Actual :
                                {{ $task->actual_start ? \Carbon\Carbon::parse($task->actual_start)->format('d M Y') : 'Null' }}
                                -
                                {{ $task->actual_end ? \Carbon\Carbon::parse($task->actual_end)->format('d M Y') : 'Null' }}
                            </h6>
                        </div>
                        <div class="row mb-3">
                            <h6 class="subtitle col-6"> <i class="fe fe-hard-drive"> </i> Total Weight :
                                {{ $weight[$task->id] ?? 0 }}
                            </h6>
                        </div>
                    </div>
                    <div class="card-body">

                        <label>Description:</label>
                        <p>{{ $task->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== ROW BAWAH (4 COL + 8 COL) ===== -->
        <div class="row mt-4 g-4">

            <!-- Kolom Kiri: Member -->
            {{-- <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-header border-bottom">
                        <h2 class="title">Member Taken Relation Task</h2>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush my-n3">
                            @foreach ($takenTask as $item)
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-2 col-md-1">
                                            <strong>{{ $loop->iteration }}</strong>
                                        </div>
                                        <div class="col-3 col-md-2">
                                            <img src="{{ $item->user->photo ? Storage::url($item->user->photo) : asset('dark/assets/avatars/face-2.jpg') }}"
                                                alt="..." class="rounded-circle" width="40">
                                        </div>
                                        <div class="col">
                                            <strong>{{ $item->user->name ?? '-' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>  --}}

            <!-- Kolom Kanan: Relation Task -->
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="title">Relation Activity</h2>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Activity ID</td>
                                    <td>Activity Name</td>
                                    <td>Weight</td>
                                    <td>Assigned To</td>
                                    <td>Priority</td>
                                    <td>Progress</td>
                                    <td>Schedule Start/End</td>
                                    <td>Actual Start/End</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($relationTask as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->task_load ?? 0 }}</td>
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
                                        <td>{{ $item->schedule_start ? \Carbon\Carbon::parse($item->schedule_start)->format('d M Y H:m:i') : '-' }}
                                            -
                                            {{ $item->schedule_end ? \Carbon\Carbon::parse($item->schedule_end)->format('d M Y H:m:i') : '-' }}
                                        </td>
                                        <td>{{ $item->actual_start ? \Carbon\Carbon::parse($item->actual_start)->format('d M Y H:m:i') : 'Null' }}
                                            -
                                            {{ $item->actual_end ? \Carbon\Carbon::parse($item->actual_end)->format('d M Y H:m:i') : 'Null' }}
                                        </td>
                                        <td>{{ $item->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- .col-md-8 -->

        </div> <!-- .row -->
    </div>
@endsection
