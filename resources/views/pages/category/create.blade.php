@extends('layouts.template')
@section('menucategory', 'active')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Create Category</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('category.store') }}">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Name Category</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="form-group col-12">
                        <label for="simple-select2">Type</label>
                        <select class="form-control select2" id="simple-select2" name="type">
                            <optgroup label="Select Category Type">
                                <option value="" selected disabled>Select Type</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                                <option value="other">Other</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-12" id="otherTypeInput" style="display: none;">
                        <label for="other_type">Specify Type</label>
                        <input type="text" class="form-control" id="other_type" name="other_type"
                            placeholder="Enter custom type">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#simple-select2').on('change', function() {
                if ($(this).val() === 'other') {
                    $('#otherTypeInput').show();
                    $('#other_type').attr('required', true);
                } else {
                    $('#otherTypeInput').hide();
                    $('#other_type').attr('required', false);
                    $('#other_type').val(''); // Clear value
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
