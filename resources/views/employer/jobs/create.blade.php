@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Post New Job</h2>
    <form method="POST" action="{{ route('employer.jobs.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Job Title *</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Job Type *</label>
                <select name="job_type" class="form-control" required>
                    <option value="">Select</option>
                    <option value="full-time">Full Time</option>
                    <option value="part-time">Part Time</option>
                    <option value="internship">Internship</option>
                    <option value="contract">Contract</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Qualification Required</label>
                <input type="text" name="qualification_required" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Experience (Years)</label>
                <input type="number" name="experience_required" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Skills Required</label>
                <input type="text" name="skills_required" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Location</label>
                <input type="text" name="location" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Min Salary</label>
                <input type="number" name="salary_min" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Max Salary</label>
                <input type="number" name="salary_max" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Status *</label>
                <select name="status" class="form-control" required>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
        </div>

        <button class="btn btn-success">Post Job</button>
        <a href="{{ route('employer.jobs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
