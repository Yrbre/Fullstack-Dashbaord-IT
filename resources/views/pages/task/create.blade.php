@extends('layouts.template')
@section('menutask', 'active')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Create Task</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('task.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Task Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="simple-select2">Priority</label>
                        <select class="form-control select2 @error('priority') is-invalid @enderror" id="select-priority"
                            name="priority">
                            <optgroup label="Select Priority Type">
                                <option value="" selected disabled>Select Priority</option>
                                <option value="CRITICAL">CRITICAL</option>
                                <option value="HIGH">HIGH</option>
                                <option value="MEDIUM">MEDIUM</option>
                                <option value="LOW">LOW</option>
                            </optgroup>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="simple-select2">Category</label>
                        <select class="form-control select2 @error('category_id') is-invalid @enderror" id="select-category"
                            name="category_id">
                            <optgroup label="Select Category Type">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->type }} - {{ $item->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="simple-select2">Assign to</label>
                        <select class="form-control select2" id="select-assign" name="assign_to">
                            <optgroup label="Select User">
                                @foreach ($assignTo as $id => $name)
                                    <option value="{{ $id }}" @if (old('assign_to', Auth::user()->id) == $id) selected @endif>
                                        {{ $name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="simple-select2">Level</label>
                        <select class="form-control select2 @error('task_level') is-invalid @enderror" id="select-level"
                            name="task_level">
                            <optgroup label="Select Level Type">
                                <option value="" selected disabled>Select Level</option>
                                <option value="DEPARTMENT">DEPARTMENT</option>
                                <option value="PERSONAL">PERSONAL</option>
                            </optgroup>
                        </select>
                        @error('task_level')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="simple-select2">Department</label>
                        <select class="form-control select2" id="select-department" name="enduser_department">
                            <optgroup label="Select Department">
                                <option value="" selected disabled>Select Department</option>
                                @foreach ($department as $item)
                                    <option value="{{ $item->id }}">{{ $item->department }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        <label for="simple-select2">Personal</label>
                        <select class="form-control select2" id="select-personal" name="enduser_personal">
                            <optgroup label="Select Personal">
                                <option value="" selected disabled>Select Personal</option>
                                @foreach ($endUser as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>


                    <div class="form-group col-6">
                        <label for="simple-select2">Status</label>
                        <select class="form-control select2 @error('status')is-invalid @enderror" id="select-status"
                            name="status">
                            <optgroup label="Select Status Type">
                                <option value="" selected disabled>Select Status</option>
                                <option value="NEW">NEW</option>
                                <option value="ON DUTY">ON DUTY</option>
                                <option value="COMPLETED">COMPLETED</option>
                            </optgroup>
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="simple-select2">Location</label>
                        <select class="form-control select2 @error('location_id') is-invalid @enderror" id="select-location"
                            name="location_id">
                            <optgroup label="Select Location">
                                <option value="" selected disabled>Select Location</option>
                                @foreach ($location as $item)
                                    <option value="{{ $item->id }}" @if (old('location_id') == $item->id) selected @endif>
                                        {{ $item->department }} - {{ $item->location }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Schedule Start</label>
                        <input type="datetime-local" class="form-control @error('schedule_start') is-invalid @enderror"
                            name="schedule_start" value="{{ old('schedule_start', now()->format('Y-m-d H:i')) }}">
                        @error('schedule_start')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Schedule End</label>
                        <input type="datetime-local" class="form-control @error('schedule_end') is-invalid @enderror"
                            name="schedule_end" value="{{ old('schedule_end') }}">
                        @error('schedule_end')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Description</label>
                        <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                            value="{{ old('description') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS Department --}}
    <script>
        $(document).ready(function() {
            $('#select-department').closest('.form-group').hide();
            $('#select-department').prop('required', false);

            $('#select-level').on('change', function() {

                if ($(this).val() === 'DEPARTMENT') {

                    $('#select-department').closest('.form-group').show();
                    $('#select-department').prop('required', true);

                } else {

                    $('#select-department').closest('.form-group').hide();
                    $('#select-department')
                        .prop('required', false)
                        .val(null)
                        .trigger('change');
                }
            });
        });
    </script>
    {{-- JS PERSONAL --}}
    <script>
        $(document).ready(function() {
            $('#select-personal').closest('.form-group').hide();
            $('#select-personal').prop('required', false);

            $('#select-level').on('change', function() {

                if ($(this).val() === 'PERSONAL') {

                    $('#select-personal').closest('.form-group').show();
                    $('#select-personal').prop('required', true);

                } else {

                    $('#select-personal').closest('.form-group').hide();
                    $('#select-personal')
                        .prop('required', false)
                        .val(null)
                        .trigger('change');
                }
            });
        });
    </script>
    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: 0,
        });
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
        });
    </script>
@endsection
