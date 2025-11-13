@extends('admin.layouts.app')

@section('title', 'Edit Job')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Job Post</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('employer.jobs.update', $job->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Job Title</label>
                    <input type="text" name="title" value="{{ old('title', $job->title) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="5" class="form-control" required>{{ old('description', $job->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" value="{{ old('location', $job->location) }}" class="form-control" required>
                </div>

                {{-- Job Type Dropdown --}}
                <div class="mb-3">
                    <label class="form-label">Job Type</label>
                    <select name="job_type" class="form-control" required>
                        <option value="">-- Select Job Type --</option>
                        <option value="full-time" {{ old('job_type', $job->job_type) === 'full-time' ? 'selected' : '' }}>Full Time</option>
                        <option value="part-time" {{ old('job_type', $job->job_type) === 'part-time' ? 'selected' : '' }}>Part Time</option>
                        <option value="remote" {{ old('job_type', $job->job_type) === 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="internship" {{ old('job_type', $job->job_type) === 'internship' ? 'selected' : '' }}>Internship</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Salary Min</label>
                        <input type="number" name="salary_min" value="{{ old('salary_min', $job->salary_min) }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Salary Max</label>
                        <input type="number" name="salary_max" value="{{ old('salary_max', $job->salary_max) }}" class="form-control">
                    </div>
                </div>

                {{-- Status Dropdown --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
    <option value="open" {{ old('status', $job->status) === 'open' ? 'selected' : '' }}>Open</option>
    <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>Closed</option>
</select>

                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('employer.jobs.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
