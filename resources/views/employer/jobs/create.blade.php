@extends('admin.layouts.app')

@section('content')

<style>

/* Fade animation */
.fade-premium {
    animation: fadeIn 0.45s ease forwards;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Premium Form Card */
.premium-card {
    background: #ffffff;
    border: 1px solid #e5e5e5;
    padding: 34px;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06);
}

/* Title */
.page-title {
    font-size: 30px;
    font-weight: 800;
    color: #242424;
    letter-spacing: -0.4px;
}

/* Label */
.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 6px;
}

/* Input fields */
.form-control, .form-select {
    border-radius: 10px;
    padding: 10px 14px;
    border: 1px solid #dcdcdc;
    transition: 0.25s ease;
}
.form-control:focus, .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
}

/* Submit button */
.btn-premium {
    background: #6366f1 !important;
    color: white !important;
    border-radius: 10px;
    padding: 10px 26px;
    font-weight: 600;
    transition: 0.25s ease;
}
.btn-premium:hover {
    background: #4f46e5 !important;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(99,102,241,0.35);
}

</style>


<div class="container fade-premium mt-4">

    <h2 class="page-title mb-4">Post a New Job</h2>

    <div class="premium-card">

        <form action="{{ route('employer.jobs.store') }}" method="POST">
            @csrf

            {{-- Title --}}
            <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            {{-- Qualification + Experience --}}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Qualification Required</label>
                    <input type="text" name="qualification_required" value="{{ old('qualification_required') }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Experience (Years)</label>
                    <input type="number" name="experience_required" value="{{ old('experience_required') }}" class="form-control" required>
                </div>
            </div>

            {{-- Skills --}}
            <div class="mb-3">
                <label class="form-label">Skills Required</label>
                <textarea name="skills_required" rows="2" class="form-control" required>{{ old('skills_required') }}</textarea>
            </div>

            {{-- Location + Type --}}
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Job Type</label>
                    <select name="job_type" class="form-select" required>
                        <option value="">Select</option>
                        <option value="full-time">Full-Time</option>
                        <option value="part-time">Part-Time</option>
                        <option value="internship">Internship</option>
                        <option value="contract">Contract</option>
                    </select>
                </div>

            </div>

            {{-- Salary --}}
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Minimum Salary</label>
                    <input type="number" name="salary_min" value="{{ old('salary_min') }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Maximum Salary</label>
                    <input type="number" name="salary_max" value="{{ old('salary_max') }}" class="form-control">
                </div>

            </div>

            {{-- Submit --}}
            <div class="text-end mt-4">
                <button type="submit" class="btn-premium">
                    <i class="bi bi-send"></i> Post Job
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
