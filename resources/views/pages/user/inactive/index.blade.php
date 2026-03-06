@extends('layouts.template')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <h2 class="page-title">User Inactive List</h2>
            <div class="row">
                <div class="col-12 my-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Table User Inactive</h5>
                            <p class="card-text"></p>
                            <table class="table datatables" id="dataTable-1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Deleted at</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->role }}</td>
                                            <td>{{ $item->deleted_at ? \Carbon\Carbon::parse($item->deleted_at)->format('d M Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('user.restore', $item->id) }}" method="POST"
                                                    class="restore-form" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        data-name="{{ $item->name }}">Restore</button>
                                                </form>
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

    <script>
        document.querySelectorAll('.restore-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var userName = form.querySelector('button').dataset.name;
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will restore user "' + userName + '"!',
                    icon: 'warning',
                    theme: 'dark',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restore it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
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
        $('#dataTable-1').DataTable({
            autoWidth: true,
            "lengthMenu": [
                [16, 32, 64, -1],
                [16, 32, 64, "All"]
            ]
        });
    </script>
@endsection
