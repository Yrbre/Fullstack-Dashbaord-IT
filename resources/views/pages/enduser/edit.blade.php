@extends('layouts.template')
@section('menuenduser', 'active')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Edit End User</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('enduser.update', $endUser->id) }}">
                @csrf
                @method('PUT')
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Name End User</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $endUser->name ?? '') }}">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label for="simple-select2">Department</label>
                        <select class="form-control select2" id="simple-select3" name="department">
                            <optgroup label="Select Department Type">
                                <option value="" selected disabled>Select Department</option>
                                @foreach ($department as $item)
                                    <option value="{{ $item }}"@if (old('department', $item) == $endUser->department) selected @endif>
                                        {{ $item }}</option>
                                @endforeach
                                <option value="other">Other</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-12" id="otherDepartmentInput" style="display: none;">
                        <label for="other_department">Specify Department</label>
                        <input type="text" class="form-control" id="other_department" name="other_department"
                            placeholder="Enter custom department">
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
