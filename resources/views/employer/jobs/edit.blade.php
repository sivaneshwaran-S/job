@extends('admin.layouts.app')

@section('title', 'Edit Job')

@section('content')

<style>
    /* --- Premium V2 Form Styling --- */

    :root {
        /* Match this to your sidebar primary color */
        --accent: #4F46E5;  /* Replace with your sidebar color */
    }

    .premium-card {
        border-radius: 16px;
        padding: 28px;
        border: 1px solid #eaeaea;
        box-shadow: 0 6px 22px rgba(0,0,0,0.07);
        transition: 0.3s ease;
        background: #fff;
    }

    .premium-card:hover {
        box-shadow: 0 10px 28px rgba(0,0,0,0.12);
    }

    .form-control, .form-select {
        border-radius: 10px;
        padding: 10px 14px;
        transition: 0.25s ease;
        border: 1px solid #d8d8d8;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 0.15rem rgba(79,70,229,0.15);
    }

    .section-title {
        font-weight: 600;
        font-size: 1.45rem;
        color: var(--accent);
        margin-bottom: 22px;
    }

    .btn-accent {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
        padding: 10px 22px;
        border-radius: 10px;
        transition: 0.3s ease;
        font-weight: 500;
    }

    .btn-accent:hover {
        background: #3f3ac9;
        border-color: #3f3ac9;
    }

    .btn-secondary {
        border-radius: 10px;
        padding: 10px 22px;
    }

    .fade-up {
        animation: fadeUp 0.5s ease;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container mt-4 fade-up">

    <h2 class="section-title">Edit Job Post</h2>

    @if (session('success'))
        <div class="alert alert-success rounded-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="premium-card mt-3">
        <form method="POST" action="{{ route('employer.jobs.update', $job->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Job Title</label>
                <input type="text" name="title" value="{{ old('title', $job->title) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="5"
                          class="form-control" required>{{ old('description', $job->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" value="{{ old('location', $job->location) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Job Type</label>
                <select name="job_type" class="form-select" required>
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
                    <input type="number" name="salary_min"
                           value="{{ old('salary_min', $job->salary_min) }}"
                           class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Salary Max</label>
                    <input type="number" name="salary_max"
                           value="{{ old('salary_max', $job->salary_max) }}"
                           class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="open" {{ old('status', $job->status) === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('employer.jobs.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-accent">Update Job</button>
            </div>
        </form>
    </div>

</div>
@endsection
