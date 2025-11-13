@extends('admin.layouts.app')

@section('title', 'Applicants')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Applicants for My Jobs</h2>

    @if($applications->isEmpty())
        <div class="alert alert-info">No applicants have applied yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
    <thead>
        <tr>
            <th>Applicant Name</th>
            <th>Email</th>
            <th>Applied For</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($applications as $application)
            <tr>
                <td>{{ $application->employee->name ?? 'N/A' }}</td>
                <td>{{ $application->employee->email ?? 'N/A' }}</td>
                <td>{{ $application->job->title ?? 'N/A' }}</td>
                <td>{{ ucfirst($application->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

        </div>
    @endif
</div>
@endsection
