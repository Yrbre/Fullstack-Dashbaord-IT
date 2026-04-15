@extends('layouts.template')
@section('judul', 'Absen List')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="mb-4 d-flex justify-content-end">
                <a href="{{ route('absen.create') }}" class="btn btn-primary">Create New</a>
                {{-- <a href="#" id="export-data" class="btn btn-secondary">Export</a> --}}
            </div>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table Absen</h5>
                            <p class="card-text"></p>
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Absent Date</th>
                                        <th>Description</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absences as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->absent_at)->format('d-M-Y') }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>
                                                <div class="dropdown d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('absen.edit', $item->id) }}">Edit</a>
                                                        <a class="dropdown-item js-delete-task"
                                                            data-id="{{ $item->id }}"
                                                            data-name="{{ $item->user->name }}"
                                                            data-desc="{{ $item->description }}"
                                                            data-url="{{ route('absen.destroy', $item->id) }}"
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
            var desc = button.data('desc');
            var deleteUrl = button.data('url');

            Swal.fire({
                title: 'Confirm Delete',
                icon: 'warning',
                theme: 'dark',
                html: '<p>Are you sure you want to delete this Absence?</p>' +
                    '<div class="justify-content-center">' +
                    '<strong>Name :</strong> ' + taskName + '<br>' +
                    '<strong>Description :</strong> ' + desc +
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
    <script>
        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                theme: 'dark',
                text: '{{ session('warning') }}',
                showConfirmButton: true,
            });
        @endif
    </script>


@endsection
