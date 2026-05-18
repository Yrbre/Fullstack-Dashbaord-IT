@extends('layouts.template')
@section('judul', 'Routine Work List')
@section('content')

    <div class="container-fluid">
        <div class="col-12">
            <div class="mb-4 d-flex justify-content-end">
                <a href="{{ route('routine_works.create') }}" class="btn btn-primary">Create New</a>
            </div>

            @if (Auth()->user()->role != 'OPERATOR')
                <div class="row">
                    <div class="col-12 my-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Table Routine Work</h5>
                                <p class="card-text"></p>
                                <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Duration</th>
                                            <th>Description</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($allRoutineWorks as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name ?? '-' }}</td>
                                                <td>{{ $item->duration ?? '-' }} m</td>
                                                <td>{{ $item->description ?? '-' }}</td>
                                                <td>
                                                    <div class="dropdown d-flex justify-content-center">
                                                        <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item"
                                                                href="{{ route('routine_works.edit', $item->id) }}">Edit</a>
                                                            <a class="dropdown-item js-delete-routine-work"
                                                                data-id="{{ $item->id }}"
                                                                data-name="{{ $item->name }}"
                                                                data-location="{{ $item->location->location ?? '-' }}"
                                                                data-building ="{{ $item->location->building ?? '-' }}"
                                                                data-url="{{ route('routine_works.destroy', $item->id) }}"
                                                                href="#">Remove</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No routine works found.</td>
                                            </tr>
                                        @endforelse
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
            @endif

        </div>
    </div>
    <script>
        // Handle delete modal
        $(document).on('click', '.js-delete-routine-work', function(e) {
            e.preventDefault();
            var button = $(this);
            var name = button.data('name');
            var location = button.data('location');
            var building = button.data('building');
            var url = button.data('url');

            Swal.fire({
                title: 'Confirm Delete',
                icon: 'warning',
                theme: 'dark',
                html: '<p>Are you sure you want to delete this Routine Work?</p>' +
                    '<div class="justify-content-center">' +
                    '<strong>Name :</strong> ' + name + '<br>' +
                    '<strong>Location :</strong> ' + building + '-' + location +
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
        })
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
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                theme: 'dark',
                text: '{{ session('error') }}',
                timer: 2000,
                showConfirmButton: false,
            });
        @endif
    </script>
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
