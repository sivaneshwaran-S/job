@extends('admin.layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
        Approved Applicants
    </h2>

    {{-- ✅ Flash Message (optional) --}}
    @if(session('success'))
        <div class="mb-3 p-3 bg-green-500/20 border border-green-500 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Applicants Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="p-3">Job Title</th>
                    <th class="p-3">Applicant Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Qualification</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr class="border-b dark:border-gray-700">
                        <td class="p-3">{{ $app->job->title ?? 'N/A' }}</td>
                        <td class="p-3">{{ $app->employee->user->name ?? 'N/A' }}</td>
                        <td class="p-3">{{ $app->employee->user->email ?? 'N/A' }}</td>
                        <td class="p-3">{{ $app->employee->qualification ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">
                            No approved applicants found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
