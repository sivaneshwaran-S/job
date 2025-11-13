@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Applicants for Your Jobs</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Applicant</th>
                <th>Status</th>
                <th>Applied At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($applications as $app)
                <tr>
                    <td>{{ $app->job->title ?? 'N/A' }}</td>
@if ($app->status === 'approved')
    <td>
        {{ $app->employee->user->name ?? 'N/A' }} <br>
        <small>{{ $app->employee->user->email ?? '' }}</small>
    </td>
@else
    <td><em>Hidden (waiting for admin approval)</em></td>
@endif




                    <td>{{ ucfirst($app->status) }}</td>
                    <td>{{ $app->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No applications yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
