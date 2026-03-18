@extends('layouts.template')
@section('judul', 'End User Department Create')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('enduser_department.store') }}">
                @csrf
                <div class="form-row">

                    <div class="form-group col-12">
                        <label for="simple-select2">Department</label>
                        <input type="text" class="form-control @error('department') is-invalid @enderror"
                            id="simple-select2" name="department" placeholder="Enter department name"
                            value="{{ old('department') }}">
                        @error('department')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
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
