@extends('layouts.template')
@section('judul', 'Task Department Edit')
@section('content')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('task.update', $task->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Task Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $task->name) }}">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Priority</label>
                        <select class="form-control select2 @error('priority') is-invalid @enderror" id="select-priority"
                            name="priority">
                            <optgroup label="Select Priority Type">
                                <option value="" selected disabled>Select Priority</option>
                                <option value="CRITICAL"
                                    {{ old('priority', $task->priority) == 'CRITICAL' ? 'selected' : '' }}>CRITICAL</option>
                                <option value="HIGH" {{ old('priority', $task->priority) == 'HIGH' ? 'selected' : '' }}>
                                    HIGH</option>
                                <option value="MEDIUM" {{ old('priority', $task->priority) == 'MEDIUM' ? 'selected' : '' }}>
                                    MEDIUM</option>
                                <option value="LOW" {{ old('priority', $task->priority) == 'LOW' ? 'selected' : '' }}>LOW
                                </option>
                            </optgroup>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Category</label>
                        <select class="form-control select2 @error('category_id') is-invalid @enderror" id="select-category"
                            name="category_id">
                            <optgroup label="Select Category Type">
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category_id', $task->category_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->type }} - {{ $item->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Assign to</label>
                        <select class="form-control select2" id="select-assign" name="assign_to">
                            <optgroup label="Select User">
                                @foreach ($assignTo as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('assign_to', $task->assign_to) == $id ? 'selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Level</label>
                        <input type="text" class="form-control @error('task_level') is-invalid @enderror"
                            name="task_level" value="{{ old('task_level', $task->task_level) }}" readonly>
                        @error('task_level')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">User</label>
                        <input type="text" id="select-personal"
                            class="form-control @error('enduser_id') is-invalid @enderror" name="enduser_id"
                            value="{{ old('enduser_id', $task->enduser->name . ' - ' . $task->enduser->department) }}"
                            readonly>
                        @error('enduser_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Department</label>
                        <input type="text" id="select-department"
                            class="form-control @error('enduser_id') is-invalid @enderror" name="enduser_id"
                            value="{{ old('enduser_id', $task->enduser->department) }}" readonly>
                        @error('enduser_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label for="simple-select2">Status</label>
                        <select class="form-control select2 @error('status')is-invalid @enderror" id="select-status"
                            name="status">
                            <optgroup label="Select Status Type">
                                <option value="" selected disabled>Select Status</option>
                                @if ($task->status === 'ON DUTY')
                                    <option value="ON DUTY"
                                        {{ old('status', $task->status) == 'ON DUTY' ? 'selected' : '' }}>
                                        ON DUTY
                                    </option>
                                @endif
                                <option value="NEW" {{ old('status', $task->status) == 'NEW' ? 'selected' : '' }}>
                                    NEW
                                </option>
                                <option value="ON PROGRESS"
                                    {{ old('status', $task->status) == 'ON PROGRESS' ? 'selected' : '' }}>
                                    ON PROGRESS
                                </option>
                                <option value="ON HOLD" {{ old('status', $task->status) == 'ON HOLD' ? 'selected' : '' }}>
                                    ON HOLD
                                </option>
                                <option value="COMPLETED"
                                    {{ old('status', $task->status) == 'COMPLETED' ? 'selected' : '' }}>
                                    COMPLETED
                                </option>
                                <option value="CANCELLED"
                                    {{ old('status', $task->status) == 'CANCELLED' ? 'selected' : '' }}>
                                    CANCELLED
                                </option>
                            </optgroup>
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Progress</label>
                        <select class="form-control select2 @error('progress') is-invalid @enderror" id="select-progress"
                            name="progress">
                            <optgroup label="Select Progress">
                                <option value="" selected disabled>Select Progress</option>
                                <option value="0" {{ old('progress', $task->progress) == 0 ? 'selected' : '' }}>0%
                                </option>
                                <option value="10" {{ old('progress', $task->progress) == 10 ? 'selected' : '' }}>10%
                                </option>
                                <option value="25" {{ old('progress', $task->progress) == 25 ? 'selected' : '' }}>25%
                                </option>
                                <option value="50" {{ old('progress', $task->progress) == 50 ? 'selected' : '' }}>50%
                                </option>
                                <option value="75" {{ old('progress', $task->progress) == 75 ? 'selected' : '' }}>75%
                                </option>
                                <option value="100" {{ old('progress', $task->progress) == 100 ? 'selected' : '' }}>100%
                                </option>
                            </optgroup>
                        </select>
                    </div>

                    {{-- <div class="form-group col-md-6">
                        <label for="simple-select2">Location</label>
                        <select class="form-control select2 @error('location_id') is-invalid @enderror" id="select-location"
                            name="location_id">
                            <optgroup label="Select Location">
                                <option value="" selected disabled>Select Location</option>
                                @foreach ($location as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('location_id', $task->location_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->department }} - {{ $item->location }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="form-group col-md-6">
                        <label for="">Schedule Start</label>
                        <input type="datetime-local" class="form-control @error('schedule_start') is-invalid @enderror"
                            name="schedule_start" value="{{ old('schedule_start', $task->schedule_start) }}">
                        @error('schedule_start')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Schedule End</label>
                        <input type="datetime-local" class="form-control @error('schedule_end') is-invalid @enderror"
                            name="schedule_end" value="{{ old('schedule_end', $task->schedule_end) }}">
                        @error('schedule_end')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label for="">Description</label>
                        <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                            value="{{ old('description') }}">{{ old('description', $task->description) }}</textarea>
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

    <script>
        $(document).ready(function() {
            var currentLevel = '{{ $task->task_level }}';

            if (currentLevel === 'DEPARTMENT') {
                $('#select-personal').closest('.form-group').hide();
                $('#select-department').closest('.form-group').show();
            } else if (currentLevel === 'PERSONAL') {
                $('#select-department').closest('.form-group').hide();
                $('#select-personal').closest('.form-group').show();
            } else {
                $('#select-department').closest('.form-group').hide();
                $('#select-personal').closest('.form-group').hide();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var originalProgress = '{{ $task->progress }}';
            $('#select-status').on('change', function() {
                var selectedStatus = $(this).val();
                if (selectedStatus === 'COMPLETED') {
                    $('#select-progress').val('100').trigger('change');
                } else if (selectedStatus === 'NEW') {
                    $('#select-progress').val('0').trigger('change');
                } else {
                    $('#select-progress').val(originalProgress).trigger('change');
                }
            });
        });
    </script>


    <script>
        $('.select2').select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: 0,
            width: '100%',
        });
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
            width: '100%',
        });
    </script>

@endsection
