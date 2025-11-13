@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="mb-4">My Job Posts</h2>

    <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary mb-3">
        + Post New Job
    </a>

    @if ($jobs->isEmpty())
        <div class="alert alert-info">No job posts found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->location }}</td>
                            <td>{{ ucfirst($job->job_type) }}</td>
                            <td>
                                <span class="badge bg-{{ $job->status === 'open' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
