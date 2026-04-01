@extends('layouts.template')
@section('judul', 'Edit Job Assignment')
@section('content')
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>

    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Edit Job Assignment</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('task_personal.update', $task->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Job Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $task->name) }}">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label for="simple-select2">Parent Activity</label>
                        <select class="form-control select2 @error('relation_task') is-invalid @enderror"
                            id="select-relation-task" name="relation_task">
                            <optgroup label="Select Relation Activity">
                                <option value="" selected>Without Relation</option>
                                @foreach ($relationTask as $item)
                                    <option value="{{ $item->id }}" @if (old('relation_task', $task->relation_task) == $item->id) selected @endif>
                                        Name: {{ $item->name }} | S/E
                                        {{ $item->schedule_start ? $item->schedule_start->format('m-d-Y h:i A') : '-' }} /
                                        {{ $item->schedule_end ? $item->schedule_end->format('m-d-Y h:i A') : '-' }} |
                                        Weight: {{ $weight[$item->id] ?? 0 }}%</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('relation_task')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6" id="wrapper_schedule_start_parent" style="display: none;">
                        <label for="">Schedule Start Parent Activity</label>
                        <input type="text" class="form-control" id="schedule_start_parent" readonly>
                    </div>
                    <div class="form-group col-md-6" id="wrapper_schedule_end_parent" style="display: none;">
                        <label for="">Schedule End Parent Activity</label>
                        <input type="text" class="form-control" id="schedule_end_parent" readonly>
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
                                <option value="MEDIUM"
                                    {{ old('priority', $task->priority) == 'MEDIUM' ? 'selected' : '' }}>
                                    MEDIUM</option>
                                <option value="LOW" {{ old('priority', $task->priority) == 'LOW' ? 'selected' : '' }}>
                                    LOW
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
                                        {{ $item->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Responsibility</label>
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

                    <div class="form-group col-6">
                        <label for="simple-select2">Member</label>
                        @php
                            $selectedMembers = old('member', $memberIds ?? []);
                        @endphp
                        <select class="form-control select2-multi" id="multi-select2" name="member[]" multiple>
                            <optgroup label="Select User">
                                @foreach ($assignTo as $id => $name)
                                    <option value="{{ $id }}" @if (in_array($id, $selectedMembers)) selected @endif>
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
                        <label for="simple-select2">End User / Dept PIC</label>
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

                    @if (Auth::check() && in_array(Auth::user()->role, ['MANAGEMENT', 'ADMIN']))
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
                                    <option value="ON HOLD"
                                        {{ old('status', $task->status) == 'ON HOLD' ? 'selected' : '' }}>
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
                    @endif
                    @if (Auth::check() && in_array(Auth::user()->role, ['OPERATOR']))
                        <div class="form-group col-md-6">
                            <label for="simple-select2">Status</label>
                            <input type="text" class="form-control" value="{{ $task->status }}" readonly>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Progress</label>
                        <select class="form-control select2 @error('progress') is-invalid @enderror" id="select-progress"
                            name="progress">
                            <optgroup label="Select Progress">
                                <option value="" selected disabled>Select Progress</option>
                                <option value="0" {{ old('progress', $task->progress) == 0 ? 'selected' : '' }}>
                                    0%
                                </option>
                                <option value="10" {{ old('progress', $task->progress) == 10 ? 'selected' : '' }}>
                                    10%
                                </option>
                                <option value="25" {{ old('progress', $task->progress) == 25 ? 'selected' : '' }}>
                                    25%
                                </option>
                                <option value="50" {{ old('progress', $task->progress) == 50 ? 'selected' : '' }}>
                                    50%
                                </option>
                                <option value="75" {{ old('progress', $task->progress) == 75 ? 'selected' : '' }}>
                                    75%
                                </option>
                                <option value="100" {{ old('progress', $task->progress) == 100 ? 'selected' : '' }}>
                                    100%
                                </option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="simple-select2">Location</label>
                        <select class="form-control select2 @error('location_id') is-invalid @enderror"
                            id="select-location" name="location_id">
                            <optgroup label="Select Location">
                                <option value="" selected disabled>Select Location</option>
                                @foreach ($location as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('location_id', $task->location_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->location }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Activity Weight</label>
                        <input type="text" class="form-control @error('task_load') is-invalid @enderror"
                            name="task_load" value="{{ old('task_load', $task->task_load ?? '') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g,'');if(this.value > 100) this.value = 100;">
                        @error('task_load')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

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

    <script>
        function fetchParentSchedule(taskId) {
            if (!taskId) {
                $('#schedule_start_parent').val('');
                $('#schedule_end_parent').val('');
                $('#wrapper_schedule_start_parent').hide();
                $('#wrapper_schedule_end_parent').hide();
                return;
            }

            fetch('/task/' + taskId)
                .then(response => response.json())
                .then(data => {
                    $('#schedule_start_parent').val(data.schedule_start ?? '-');
                    $('#schedule_end_parent').val(data.schedule_end ?? '-');
                    $('#wrapper_schedule_start_parent').show();
                    $('#wrapper_schedule_end_parent').show();
                })
                .catch(error => {
                    console.error(error);
                });
        }

        // Saat user mengubah pilihan relation task
        $('#select-relation-task').on('change', function() {
            fetchParentSchedule($(this).val());
        });

        // Saat page load (misal redirect back karena validasi gagal)
        $(document).ready(function() {
            let initialTaskId = $('#select-relation-task').val();
            if (initialTaskId) {
                fetchParentSchedule(initialTaskId);
            }
        });
    </script>

@endsection
