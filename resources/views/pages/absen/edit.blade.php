@extends('layouts.template')
@section('judul', 'Absen edit')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Update Absence</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('absen.update', $absen->id) }}">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="simple-select2">Nama</label>
                        <select class="form-control @error('user_id') is-invalid @enderror" id="simple-select2"
                            name="user_id">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $absen->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('user_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div class="form-group col-12">
                        <label for="simple-select2">Absent Date</label>
                        <input type="date" class="form-control @error('absent_at') is-invalid @enderror" name="absent_at"
                            value="{{ old('absent_at', $absen->absent_at ? \Carbon\Carbon::parse($absen->absent_at)->format('Y-m-d') : '') }}"
                            placeholder="Enter absent date">
                    </div>
                    @error('absent_at')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div class="form-group col-12">
                        <label for="simple-select2">Reason</label>
                        <textarea class="uppercase form-control @error('description') is-invalid @enderror" name="description"
                            placeholder="Enter reason">{{ old('description', $absen->description) }}</textarea>
                    </div>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#simple-select3').on('change', function() {
                if ($(this).val() === 'other') {
                    $('#otherDepartmentInput').show();
                    $('#other_department').attr('required', true);
                } else {
                    $('#otherDepartmentInput').hide();
                    $('#other_department').attr('required', false);
                    $('#other_department').val(''); // Clear value
                }
            });
            $('#simple-select2').on('change', function() {
                if ($(this).val() === 'other') {
                    $('#otherLocationInput').show();
                    $('#other_location').attr('required', true);
                } else {
                    $('#otherLocationInput').hide();
                    $('#other_location').attr('required', false);
                    $('#other_location').val(''); // Clear value
                }
            });
        });
    </script>

    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
        });
    </script>
@endsection
