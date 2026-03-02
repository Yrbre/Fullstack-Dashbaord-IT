@extends('layouts.template')
@section('content')
    <div class="container-fluid py-4">
        <div class="mx-auto">
            <div class="row">
                <div class="col-8">
                    <h2>Task Ready To Take</h2>
                    <div class="">
                        <div class="card shadow">
                            <div class="card-body">
                                <p class="mb-0">Please take the task/activity that you will do, and make sure to complete
                                    it when you are done.</p>

                                <!-- Div dengan scroll untuk tabel -->
                                <div style="max-height: 300px; overflow-y: auto; margin-top: 20px;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Task Name</th>
                                                <th>Schedule Start</th>
                                                <th>Schedule End</th>
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
                <div class="col-4">
                    <h2 class="page-title justify-content-center"> <i class="fe fe-list" style="color:aqua"> </i> ACTIVITY
                        LIST
                    </h2>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-body">
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
                                                        <a class="btn btn-sm btn-primary" data-id="{{ $item->id }}"
                                                            data-name="{{ $item->name }}" href="#"
                                                            data-location="{{ $item->location }}" data-toggle="modal"
                                                            data-target="#takeModal"
                                                            data-url="{{ route('dashboard_operator.take', $item->id) }}">
                                                            Take

                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @extends('pages.dashboard_operator.modal')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            // Handle take modal
            $('#takeModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var activityName = button.data('name');
                var activityLocation = button.data('location');
                var takeUrl = button.data('url');


                // Update the modal's content
                var modal = $(this);
                modal.find('#activityName').text(activityName);
                modal.find('#activityLocation').text(activityLocation);
                modal.find('#takeForm').attr('action', takeUrl);
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
