@extends('admin.layouts.app')

@section('content')

<style>
/* ---------------- PREMIUM UI STYLES ---------------- */

/* Smooth entry animation */
.fade-premium {
    animation: fadeUp .45s ease-out both;
}
@keyframes fadeUp {
    from {opacity:0; transform:translateY(12px);}
    to   {opacity:1; transform:translateY(0);}
}

/* Premium Card */
.card-premium {
    background: linear-gradient(135deg, #ffffff, #f6f8fc);
    border-radius: 18px;
    padding: 28px;
    border: 1px solid #e6eaf3;
    box-shadow: 6px 6px 18px rgba(0,0,0,0.07),
                -6px -6px 16px rgba(255,255,255,0.9);
    transition: .25s ease;
}
.card-premium:hover {
    transform: translateY(-3px);
    box-shadow: 8px 8px 26px rgba(0,0,0,0.10),
                -6px -6px 14px rgba(255,255,255,0.85);
}

/* Premium Form Controls */
.form-control,
.form-select {
    border-radius: 12px !important;
    padding: 12px 14px !important;
    background: #ffffff !important;
    border: 1px solid #dfe4ec !important;
    transition: .25s ease;
}
.form-control:focus,
.form-select:focus {
    border: 1px solid #8cb4ff !important;
    box-shadow: 0 0 0 4px rgba(140,180,255,0.25) !important;
}

/* Labels */
.form-label {
    font-weight: 600;
    color: #2d334a;
}

/* Premium Button */
.btn-premium {
    background: linear-gradient(135deg, #6ea8ff, #3677ff);
    border: none;
    padding: 10px 28px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    box-shadow: 0 6px 16px rgba(70,110,255,0.25);
    transition: .25s ease;
}
.btn-premium:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(70,110,255,0.35);
}

/* Smaller resume buttons */
.btn-resume {
    border-radius: 10px;
    padding: 6px 16px;
    font-size: 13px;
    font-weight: 600;
}

/* Page Heading */
.p-title {
    font-size: 28px;
    font-weight: 800;
    color: #1f2639;
}
</style>



<div class="container-fluid px-4 py-3 fade-premium">
    
    <h2 class="p-title mb-4">Edit Profile</h2>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded" role="alert">
            <strong>Oops! Something went wrong:</strong>
            <ul class="mt-2 mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="card-premium">

        <form method="POST" action="{{ route('employee.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="Male"   {{ $employee->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $employee->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other"  {{ $employee->gender == 'Other' ? 'selected' : '' }}>Other</option>
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
                    <label class="form-label">Experience (Years)</label>
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


            <div class="mb-3">
                <label class="form-label fw-bold">Upload Resume (PDF Only)</label>
                <input type="file" name="resume_file" class="form-control">
                <small class="text-muted">Allowed: PDF only • Max: 2MB</small>
            </div>


            @if($employee->resume_file)
            <div class="mb-3">
                <label class="fw-bold">Current Resume</label>

                <div class="d-flex gap-2 mt-2">

                    <a href="{{ asset('storage/' . $employee->resume_file) }}"
                       class="btn btn-success btn-resume"
                       target="_blank">
                        Open Resume
                    </a>

                    <a href="{{ route('employee.resume.delete') }}"
                       class="btn btn-danger btn-resume"
                       onclick="return confirm('Are you sure you want to delete your resume?');">
                        Delete Resume
                    </a>

                </div>
            </div>
            @endif

            <button type="submit" class="btn-premium mt-2">
                Save Changes
            </button>

        </form>
    </div>

</div>

@endsection
