@extends('employer.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card text-center p-3 shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Jobs</h6>
                <h2 class="fw-bold text-primary">{{ $totalJobs ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center p-3 shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Applicants</h6>
                <h2 class="fw-bold text-success">{{ $totalApplicants ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center p-3 shadow-sm border-0">
            <div class="card-body">
                <h6 class="text-muted">Open Jobs</h6>
                <h2 class="fw-bold text-warning">{{ $openJobs ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center border-0">
        <h5 class="mb-0 fw-semibold">Recent Jobs</h5>
        <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Job
        </a>
    </div>
    <div class="card-body">
        @if(isset($jobs) && $jobs->count() > 0)
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Applicants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $index => $job)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $job->title }}</td>
                        <td>
                            <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'secondary' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                        <td>{{ $job->applications_count ?? 0 }}</td>
                        <td>
                            <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('employer.jobs.delete', $job->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this job?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-muted mb-0">No jobs found. Add one now!</p>
        @endif
    </div>
</div>
@endsection
