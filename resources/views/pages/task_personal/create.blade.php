@extends('layouts.template')
@section('judul', 'Create Job Assignment')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('task_personal.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Job Name</label>
                        <input type="text" class="uppercase form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}">
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
                                @foreach ($task as $item)
                                    <option value="{{ $item->id }}" @if (old('relation_task') == $item->id) selected @endif>
                                        Name: {{ $item->name }} | S/E:
                                        {{ $item->schedule_start->format('m-d-Y h:i A') ?? '-' }}
                                        /
                                        {{ $item->schedule_end ? $item->schedule_end->format('m-d-Y h:i A') : '-' }} |
                                        Total Weight: {{ $weight[$item->id] ?? 0 }}%
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('relation_task')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group col-6">
                        <label for="simple-select2">Priority</label>
                        <select class="form-control select2 @error('priority') is-invalid @enderror" id="select-priority"
                            name="priority">
                            <optgroup label="Select Priority Type">
                                <option value="" selected disabled>Select Priority</option>
                                <option value="CRITICAL" @if (old('priority') == 'CRITICAL') selected @endif>CRITICAL</option>
                                <option value="HIGH" @if (old('priority') == 'HIGH') selected @endif>HIGH</option>
                                <option value="MEDIUM" @if (old('priority') == 'MEDIUM') selected @endif>MEDIUM</option>
                                <option value="LOW" @if (old('priority') == 'LOW') selected @endif>LOW</option>
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
                                    <option value="{{ $item->id }}" @if (old('category_id') == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="simple-select2">Responsibility</label>
                        <select class="form-control select2" id="select2" name="assign_to">
                            <optgroup label="Select User">
                                @foreach ($assignTo as $id => $name)
                                    <option value="{{ $id }}" @if (old('assign_to', Auth::user()->id) == $id) selected @endif>
                                        {{ $name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="simple-select2">Member</label>
                        <select class="form-control select2-multi @error('member') is-invalid @enderror" id="multi-select2"
                            name="member[]" multiple>
                            <optgroup label="Select User">
                                @foreach ($assignTo as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ in_array($id, old('member', [])) ? 'selected' : '' }}>
                                        {{ $name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        @error('member')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="form-group col-6">
                        <label for="simple-select2">Level</label> --}}
                    <input type="text" class="form-control @error('task_level') is-invalid @enderror" value="PERSONAL"
                        readonly id="select-level" name="task_level" hidden>
                    {{-- @error('task_level')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> --}}


                    <div class="form-group col-6">
                        <label for="simple-select2">End User / Dept PIC</label>
                        <select class="form-control select2" id="select-personal" name="enduser_personal">
                            <optgroup label="Select Personal">
                                <option value="" selected disabled>Select User</option>
                                @foreach ($endUser as $item)
                                    <option value="{{ $item->id }}" @if (old('enduser_personal') == $item->id) selected @endif>
                                        {{ $item->name }}</option>
                                @endforeach
                                <option value="OTHER" @if (old('enduser_personal') == 'OTHER') selected @endif>OTHER</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-6" id="otherPersonalInput" style="display: none;">
                        <label for="other_personal">Specify User</label>
                        <input type="text" class="uppercase form-control" id="other_personal" name="other_personal"
                            placeholder="Enter custom personal" value="{{ old('other_personal') }}">
                    </div>
                    <div class="form-group col-6" id="otherPersonalDepartmentInput" style="display: none;">
                        <label for="other_personal_department">Specify Department</label>
                        <input type="text" class="uppercase form-control" id="other_personal_department"
                            name="other_personal_department" placeholder="Enter custom department"
                            value="{{ old('other_personal_department') }}">
                    </div>

                    <input type="hidden" name="status" value="NEW">
                    {{-- <div class="form-group col-6">
                        <label for="simple-select2">Status</label>
                        <select class="form-control select2 @error('status')is-invalid @enderror" id="select-status"
                            name="status">
                            <optgroup label="Select Status Type">
                                <option value="" selected disabled>Select Status</option>
                                <option value="NEW" @if (old('status') == 'NEW') selected @endif>NEW</option>
                                <option value="ON DUTY" @if (old('status') == 'ON DUTY') selected @endif>ON DUTY
                                </option>
                                <option value="COMPLETED" @if (old('status') == 'COMPLETED') selected @endif>COMPLETED
                                </option>
                            </optgroup>
                        </select>
                        @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="form-group col-6">
                        <label for="simple-select2">Location</label>
                        <select class="form-control select2 @error('location_id') is-invalid @enderror"
                            id="select-location" name="location_id">
                            <optgroup label="Select Location">
                                <option value="" selected disabled>Select Location</option>
                                @foreach ($location as $item)
                                    <option value="{{ $item->id }}"
                                        @if (old('location_id') == $item->id) selected @endif>
                                        {{ $item->location }}</option>
                                @endforeach
                                <option value="OTHER" @if (old('location_id') == 'OTHER') selected @endif>OTHER</option>
                            </optgroup>
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-6" id="otherDepartmentLocationInput" style="display: none;">
                        <label for="other_department_location">Specify Department Location</label>
                        <input type="text" class="uppercase form-control" id="other_department_location"
                            name="other_department_location" placeholder="Enter custom department location"
                            value="{{ old('other_department_location') }}">
                    </div>

                    <div class="form-group col-6" id="otherLocationInput" style="display: none;">
                        <label for="other_location">Specify Location</label>
                        <input type="text" class="uppercase form-control" id="other_location" name="other_location"
                            placeholder="Enter custom location" value="{{ old('other_location') }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="">Activity Weight</label>
                        <input type="text" class="uppercase form-control @error('task_load') is-invalid @enderror"
                            name="task_load" value="{{ old('task_load', 100) }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g,'');if(this.value > 100) this.value = 100;">
                        @error('task_load')
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
                        <textarea type="text" class="uppercase form-control @error('description') is-invalid @enderror"
                            name="description" value="{{ old('description') }}">{{ old('description') }}</textarea>
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

            function toggleLevel() {
                const level = $('#select-level').val();

                // DEPARTMENT
                if (level === 'DEPARTMENT') {
                    $('#select-department').closest('.form-group').show();
                    $('#select-department').prop('required', true);
                } else {
                    $('#select-department')
                        .closest('.form-group').hide();
                    $('#select-department')
                        .prop('required', false)
                        .val(null)
                        .trigger('change');
                }

                // PERSONAL
                if (level === 'PERSONAL') {
                    $('#select-personal').closest('.form-group').show();
                    $('#select-personal').prop('required', true);
                } else {
                    $('#select-personal')
                        .closest('.form-group').hide();
                    $('#select-personal')
                        .prop('required', false)
                        .val(null)
                        .trigger('change');
                }
            }

            function toggleDepartmentOther() {
                if ($('#select-department').val() === 'OTHER') {
                    $('#otherDepartmentInput').show();
                    $('#other_department').prop('required', true);
                } else {
                    $('#otherDepartmentInput').hide();
                    $('#other_department')
                        .prop('required', false)
                        .val('');
                }
            }

            function togglePersonalOther() {
                if ($('#select-personal').val() === 'OTHER') {
                    $('#otherPersonalInput').show();
                    $('#other_personal').prop('required', true);

                    $('#otherPersonalDepartmentInput').show();
                    $('#other_personal_department').prop('required', true);
                } else {
                    $('#otherPersonalInput').hide();
                    $('#other_personal')
                        .prop('required', false)
                        .val('');

                    $('#otherPersonalDepartmentInput').hide();
                    $('#other_personal_department')
                        .prop('required', false)
                        .val('');
                }
            }

            function toggleLocationOther() {
                if ($('#select-location').val() === 'OTHER') {
                    $('#otherLocationInput').show();
                    $('#other_location').prop('required', true);

                    $('#otherDepartmentLocationInput').show();
                    $('#other_department_location').prop('required', true);
                } else {
                    $('#otherLocationInput').hide();
                    $('#other_location')
                        .prop('required', false)
                        .val('');

                    $('#otherDepartmentLocationInput').hide();
                    $('#other_department_location')
                        .prop('required', false)
                        .val('');
                }
            }

            // ===== Event Binding =====
            $('#select-level').on('change', toggleLevel);
            $('#select-department').on('change', toggleDepartmentOther);
            $('#select-personal').on('change', togglePersonalOther);
            $('#select-location').on('change', toggleLocationOther);

            // ===== Initial Load State (IMPORTANT) =====
            toggleLevel();
            toggleDepartmentOther();
            togglePersonalOther();
            toggleLocationOther();

            console.log('Initial load: Level = ' + $('#select-level').val());
            console.log('Initial load: Department = ' + $('#select-department').val());
            console.log('Initial load: Personal = ' + $('#select-personal').val());
            console.log('Initial load: Location = ' + $('#select-location').val());

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
