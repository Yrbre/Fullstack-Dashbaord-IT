@extends('layouts.template')
@section('menuactivity_history', 'active')
@section('content')

    <div class="container-fluid">
        <div class="col-12">
            <h2 class="page-title">Activity History List</h2>
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
                                        <th>Do Somegthing</th>
                                        <th>Location</th>
                                        <th>Create at</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($activity_history as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->reference_type }} - {{ $item->reference_id }}</td>

                                            @if ($item->reference_type === 'TASK')
                                                <td>{{ $item->task->name ?? '-' }}</td>
                                            @elseif ($item->reference_type === 'ACTIVITY')
                                                <td>{{ $item->activity->name ?? '-' }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>{{ $item->task->enduser->department ?? '-' }} - {{ $item->location ?? '-' }}
                                            </td>
                                            <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') : '-' }}
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
