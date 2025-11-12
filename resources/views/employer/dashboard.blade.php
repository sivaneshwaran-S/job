@extends('employer.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm text-center p-3">
                <div><i class="bi bi-briefcase display-5"></i></div>
                <h5 class="mt-2">Total Jobs</h5>
                <h3>{{ $totalJobs ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm text-center p-3">
                <div><i class="bi bi-person-lines-fill display-5"></i></div>
                <h5 class="mt-2">Total Applicants</h5>
                <h3>{{ $totalApplicants ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow-sm text-center p-3">
                <div><i class="bi bi-hourglass-split display-5"></i></div>
                <h5 class="mt-2">Pending Jobs</h5>
                <h3>{{ $pendingJobs ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Jobs</h5>
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i> Add Job
            </a>
        </div>
        <div class="card-body">
            @if(isset($jobs) && $jobs->count() > 0)
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
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
                                <span class="badge bg-{{ $job->status == 'approved' ? 'success' : ($job->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td>{{ $job->applications->count() }}</td>
                            <td>
                                <a href="{{ route('employer.jobs.edit', $job->id ?? '#') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="{{ route('employer.jobs.applicants', $job->id ?? '#') }}" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('employer.jobs.delete', $job->id ?? 0) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this job?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center mb-0 text-muted py-3">No jobs found. Start by adding one!</p>
            @endif
        </div>
    </div>

</div>
@endsection
