@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-4 py-3">
        <h2 class="fw-bold mb-4">Edit Profile</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

       {{-- Error Message --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Oops! Something went wrong:</strong>
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


        <div class="card shadow-sm">
            <div class="card-body">

                <form method="POST" action="{{ route('employee.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $employee->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ $employee->gender == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob', $employee->dob) }}" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Qualification</label>
                            <input type="text" name="qualification" value="{{ old('qualification', $employee->qualification) }}" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Experience (in years)</label>
                            <input type="text" name="experience_years" value="{{ old('experience_years', $employee->experience_years) }}" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Skills</label>
                        <input type="text" name="skills" value="{{ old('skills', $employee->skills) }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Preferred Location</label>
                        <input type="text" name="preferred_location" value="{{ old('preferred_location', $employee->preferred_location) }}" class="form-control">
                    </div>

                    {{-- ⭐ Resume Upload --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Upload Resume (PDF Only)</label>
                        <input type="file" name="resume_file" class="form-control">

                        <small class="text-muted">
                            Allowed: PDF only • Max 2MB
                        </small>
                    </div>

                    {{-- ⭐ Simple Resume Buttons --}}
@if ($employee->resume_file)
    <div class="mb-3">
        <label class="fw-bold">Current Resume</label>

        <div class="d-flex gap-2 mt-2">

            {{-- Open Resume --}}
            <a href="{{ asset('storage/' . $employee->resume_file) }}"
               target="_blank"
               class="btn btn-success btn-sm">
                Open Resume
            </a>

            {{-- Delete Resume --}}
            <a href="{{ route('employee.resume.delete') }}"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Are you sure you want to delete your resume?');">
                Delete Resume
            </a>

        </div>
    </div>
@endif
                    <button type="submit" class="btn btn-primary">Save Changes</button>

                </form>

            </div>
        </div>
    </div>
@endsection
