@extends('admin.layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Apply for: {{ $job->title }}</h2>

    <form method="POST" action="{{ route('employee.jobs.apply', $job->id) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Cover Letter <span class="text-danger">*</span></label>
            <textarea name="cover_letter" rows="6" class="form-control" required>{{ old('cover_letter') }}</textarea>
            @error('cover_letter') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Skills (optional)</label>
            <input type="text" name="skills" value="{{ old('skills', auth()->user()->employee->skills ?? '') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Education (optional)</label>
            <input type="text" name="education" value="{{ old('education', auth()->user()->employee->qualification ?? '') }}" class="form-control">
        </div>

        <div class="text-end">
            <a href="{{ route('employee.jobs.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit Application</button>
        </div>
    </form>
</div>
@endsection
