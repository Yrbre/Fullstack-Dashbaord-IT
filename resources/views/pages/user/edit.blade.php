@extends('layouts.template')
@section('menuuser', 'active')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong class="card-title">Edit User</strong>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-row">

                    <div class="form-group col-md-12">
                        <label for="">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $user->name ?? '') }}">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', $user->email ?? '') }}">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            value="{{ old('password', $user->password) }}">
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone', $user->phone ?? '') }}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,15);">
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="">photo</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo">
                        @error('photo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($user->photo)
                        <p class="mt-2">File saat ini:
                            <a href="{{ Storage::url($user->photo) }}" target="_blank"
                                class="btn btn-primary btn-sm">Download photo</a>
                        </p>
                    @endif

                    <div class="form-group col-12">
                        <label for="simple-select2">role</label>
                        <select class="form-control select2" id="simple-select3" name="role">
                            <optgroup label="Select Role Type">
                                <option value="" selected disabled>Select Role</option>
                                <option value="ADMIN"@if (old('role', $user->role) === 'ADMIN') selected @endif>ADMIN</option>
                                <option value="MANAGEMENT"@if (old('role', $user->role) === 'MANAGEMENT') selected @endif>MANAGEMENT
                                </option>
                                <option value="OPERATOR"@if (old('role', $user->role) === 'OPERATOR') selected @endif>OPERATOR</option>
                            </optgroup>
                        </select>
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
        $('.select2-multi').select2({
            multiple: true,
            theme: 'bootstrap4',
        });
    </script>
@endsection
