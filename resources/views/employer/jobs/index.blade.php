@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">My Job Listings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary mb-3">+ Post New Job</a>

    @if($jobs->isEmpty())
        <p>No jobs posted yet.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Posted On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr>
                        <td>{{ $job->title }}</td>
                        <td>{{ ucfirst($job->job_type) }}</td>
                        <td>
                            <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'secondary' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </td>
                        <td>{{ $job->location }}</td>
                        <td>{{ $job->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="{{ route('employer.jobs.applicants', $job->id) }}" class="btn btn-sm btn-info text-white">Applicants</a>
                            <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this job?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
