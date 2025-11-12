@extends('admin.layouts.app')

@section('title', 'Applicants for ' . $job->title)

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Applicants for:</strong> {{ $job->title }}</h1>

    <div class="mb-3">
        <p><strong>Employer:</strong> {{ $job->employer->company_name ?? 'N/A' }}</p>
        <p><strong>Location:</strong> {{ $job->location }}</p>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Email</th>
                        <th>Experience</th>
                        <th>Skills</th>
                        <th>Cover Letter</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($job->applications as $application)
                        <tr>
                            <td>{{ $application->employee->user->name ?? 'N/A' }}</td>
                            <td>{{ $application->employee->user->email ?? 'N/A' }}</td>
                            <td>{{ $application->employee->experience_years ?? '-' }} yrs</td>
                            <td>{{ $application->employee->skills ?? '-' }}</td>
                            <td>{{ $application->cover_letter ?? '-' }}</td>
                            <td>
                                <span class="badge 
                                    @if($application->status == 'pending') bg-warning
                                    @elseif($application->status == 'approved') bg-success
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>
                                @if($application->status == 'pending')
                                    <form action="{{ route('admin.applicants.approve', $application->id) }}" method="POST" onsubmit="return confirm('Approve this applicant?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Approved</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No applicants yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
