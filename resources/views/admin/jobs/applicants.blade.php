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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No applicants yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
