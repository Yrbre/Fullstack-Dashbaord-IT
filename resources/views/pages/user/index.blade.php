@extends('layouts.template')
@section('menuuser', 'active')
@section('content')

    <div class="container-fluid">
        <div class="col-12">
            <h2 class="page-title">User List</h2>
            <div class="mb-4 d-flex justify-content-end">
                <a href="{{ route('user.create') }}" class="btn btn-primary">Create New User</a>
            </div>
            {{-- Search --}}
            <form class="form-inline mr-auto searchform text-muted" action="{{ route('user.index') }}" method="GET">
                <input class="form-control mr-sm-2 bg-transparent border-1 pl-4 text-muted" type="search"
                    placeholder="Type something..." aria-label="Search" name="search"
                    value="{{ $search['search'] ?? '' }}">
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table User</h5>
                            <p class="card-text"></p>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Create at</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->role }}</td>
                                            <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-' }}
                                            </td>
                                            <td>
                                                <div class="dropdown d-flex justify-content-center">
                                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item"
                                                            href="{{ route('user.edit', $item->id) }}">Edit</a>
                                                        <a class="dropdown-item" data-toggle="modal"
                                                            data-target="#deleteModal" data-id="{{ $item->id }}"
                                                            data-name="{{ $item->name }}"
                                                            data-role="{{ $item->role }}"
                                                            data-url="{{ route('user.destroy', $item->id) }}"
                                                            href="#">Remove</a>
                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @extends('pages.user.delete')
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
            var userName = button.data('name');
            var roleName = button.data('role');
            var deleteUrl = button.data('url');

            // Update the modal's content
            var modal = $(this);
            modal.find('#userName').text(userName);
            modal.find('#roleName').text(roleName);
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
