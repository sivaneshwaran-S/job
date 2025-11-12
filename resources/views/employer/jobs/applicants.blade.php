@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Applicants for: <strong>{{ $job->title }}</strong></h2>

    @if($applicants->isEmpty())
        <p>No applicants yet for this job.</p>
    @else
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Experience</th>
                    <th>Skills</th>
                    <th>Applied On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applicants as $application)
                    <tr>
                        <td>{{ $application->employee->user->name ?? 'N/A' }}</td>
                        <td>{{ $application->employee->user->email ?? 'N/A' }}</td>
                        <td>{{ $application->employee->experience ?? 'N/A' }} years</td>
                        <td>{{ $application->employee->skills ?? 'N/A' }}</td>
                        <td>{{ $application->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
