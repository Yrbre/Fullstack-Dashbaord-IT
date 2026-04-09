@extends('layouts.template')
@section('judul', 'Location Create')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Create Location</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('location.store') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="simple-select2">Building</label>
                        <input type="text" class="uppercase form-control @error('building') is-invalid @enderror"
                            id="simple-select2" name="building" placeholder="Enter building">
                    </div>
                    @error('building')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div class="form-group col-12">
                        <label for="simple-select2">Location</label>
                        <input type="text" class="uppercase form-control @error('location') is-invalid @enderror"
                            id="simple-select2" name="location" placeholder="Enter location">
                    </div>
                    @error('location')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

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
