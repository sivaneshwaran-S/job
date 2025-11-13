@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Post a New Job</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('employer.jobs.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Job Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control" required>{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Qualification Required</label>
                        <input type="text" name="qualification_required" value="{{ old('qualification_required') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Experience Required (Years)</label>
                        <input type="number" name="experience_required" value="{{ old('experience_required') }}" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Skills Required</label>
                    <textarea name="skills_required" rows="2" class="form-control" required>{{ old('skills_required') }}</textarea>
                </div>

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

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Post Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
