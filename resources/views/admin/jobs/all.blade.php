@extends('admin.layouts.app')

@section('title', 'All Job Listings')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>All</strong> Job Listings</h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>company_name</th>
                        <th>Location</th>
                        <th>Salary Range</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>{{ $job->title }}</td>
                            <td>{{ $job->employer->company_name ?? 'N/A' }}</td>
                            <td>{{ $job->location }}</td>
                            <td>₹{{ $job->salary_min }} - ₹{{ $job->salary_max }}</td>
                            <td>{{ ucfirst($job->status) }}</td>
                            <td>
                                <a href="{{ route('admin.jobs.applicants', $job->id) }}" 
                                   class="btn btn-sm btn-primary">
                                   View Applicants
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No job listings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
