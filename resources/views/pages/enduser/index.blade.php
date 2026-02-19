@extends('layouts.template')
@section('menuenduser', 'active')
@section('content')

    <div class="container-fluid">
        <div class="col-12">
            <h2 class="page-title">End User List</h2>
            <div class="mb-4 d-flex justify-content-end">
                <a href="{{ route('enduser.create') }}" class="btn btn-primary">Create New End User</a>
            </div>
            {{-- Search --}}
            <form class="form-inline mr-auto searchform text-muted" action="{{ route('enduser.index') }}" method="GET">
                <input class="form-control mr-sm-2 bg-transparent border-1 pl-4 text-muted" type="search"
                    placeholder="Type something..." aria-label="Search" name="search"
                    value="{{ $search['search'] ?? '' }}">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table End User</h5>
                            <p class="card-text"></p>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Create at</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($endUser as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->department }}</td>
                                            <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-' }}
                                            </td>
                                            <td>
                                                <div class="dropdown d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('enduser.edit', $item->id) }}">Edit</a>
                                                        <a class="dropdown-item" data-toggle="modal"
                                                            data-target="#deleteModal" data-id="{{ $item->id }}"
                                                            data-name="{{ $item->name }}"
                                                            data-department="{{ $item->department }}"
                                                            data-url="{{ route('enduser.destroy', $item->id) }}"
                                                            href="#">Remove</a>
                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @extends('pages.enduser.delete')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Handle delete modal
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var endUserName = button.data('name');
            var departmentName = button.data('department');
            var deleteUrl = button.data('url');

            // Update the modal's content
            var modal = $(this);
            modal.find('#endUserName').text(endUserName);
            modal.find('#departmentName').text(departmentName);
            modal.find('#deleteForm').attr('action', deleteUrl);
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
