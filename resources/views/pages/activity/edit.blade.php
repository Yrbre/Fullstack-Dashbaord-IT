@extends('layouts.template')
@section('menuactivity', 'active')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Edit Activity</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('activity.update', $activity->id) }}">
                @csrf
                @method('PUT')
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Name Activity</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $activity->name ?? '') }}">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="simple-select2">Location</label>
                        <select class="form-control select2" id="simple-select2" name="location">
                            <optgroup label="Select Activity Location">
                                @foreach ($location as $item)
                                    <option value="{{ $item }}"@if (old('location', $item) == $activity->location) selected @endif>
                                        {{ $item }}</option>
                                @endforeach
                                <option value="other">Other</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-12" id="otherLocationInput" style="display: none;">
                        <label for="other_location">Specify Location</label>
                        <input type="text" class="form-control" id="other_location" name="other_location"
                            placeholder="Enter custom location">
                    </div>
                    <div class="form-group col-12">
                        <label for="">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $activity->description) }}</textarea>
                    </div>
                    @error('description')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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
