@extends('admin.layouts.app')
{{-- use the same layout as employer/employee --}}

@section('content')
    <div class="container">
        <h2 class="mb-4">Edit Profile</h2>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">
                Profile updated successfully.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password (leave blank if not changing)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>

        <hr>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mt-3"
                onclick="return confirm('Are you sure you want to delete your account?');">
                Delete Account
            </button>
        </form>
    </div>
@endsection