@extends('admin.layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
        Approved Applicants
    </h2>

    @if(session('success'))
        <div class="mb-3 p-3 bg-green-500/20 border border-green-500 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>Job Title</th>
                <th>Applicant Name</th>
                <th>Email</th>
                <th>Qualification</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
                <tr>
                    <td>{{ $app->job->title ?? 'N/A' }}</td>
                    <td>{{ $app->employee->user->name ?? 'N/A' }}</td>
                    <td>{{ $app->employee->user->email ?? 'N/A' }}</td>
                    <td>{{ $app->employee->qualification ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        No approved applicants found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>
@endsection
