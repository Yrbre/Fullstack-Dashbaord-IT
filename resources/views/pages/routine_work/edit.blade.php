@extends('layouts.template')
@section('judul', 'Routine Work Edit')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('routine_works.update', $routineWork->id) }}">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="">Name Routine Work</label>
                        <input type="text" class="uppercase form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name', $routineWork->name) }}"
                            placeholder="Enter name routine work">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="simple-select2">End User</label>
                        <select class="form-control select2 @error('enduser_id') is-invalid @enderror" id="select3"
                            name="enduser_id">
                            <optgroup label="Select End User">
                                <option value="" selected disabled>Select End User</option>
                                @foreach ($endusers as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('enduser_id', $routineWork->enduser_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} - {{ $item->department }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('enduser_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="simple-select2">Location</label>
                        <select class="form-control select2 @error('location_id') is-invalid @enderror" id="select2"
                            name="location_id">
                            <optgroup label="Select Location">
                                <option value="" selected disabled>Select Location</option>
                                @foreach ($locations as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('location_id', $routineWork->location_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->building }} - {{ $item->location }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Duration in minutes</label>
                        <input type="number" class="uppercase form-control @error('duration') is-invalid @enderror"
                            name="duration" value="{{ old('duration', $routineWork->duration) }}"
                            placeholder="Enter duration in minutes"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,15);">
                        @error('duration')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Description</label>
                        <textarea type="text" class="uppercase form-control @error('description') is-invalid @enderror" name="description"
                            placeholder="Enter description">{{ old('description', $routineWork->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
        });
        $('.select3').select2({
            theme: 'bootstrap4',
        });
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
        });
    </script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                theme: 'dark',
                text: '{{ session('error') }}',
                timer: 2000,
                showConfirmButton: false,
            });
        @endif
    </script>
@endsection
