@extends('layouts.template')
@section('menuenduserdepartment', 'active')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Edit End User Department</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('enduser_department.update', $department->id) }}">
                @csrf
                @method('PUT')
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Department</label>
                        <input type="text" class="form-control @error('department') is-invalid @enderror"
                            name="department" value="{{ old('department', $department->department ?? '') }}">
                        @error('department')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
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
