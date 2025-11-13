@extends('admin.layouts.app')

@section('content')
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100 flex items-center gap-2">
        {{-- 💼 Small briefcase icon --}}
        Available Jobs
    </h2>

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div class="mb-3 p-3 bg-green-500/20 border border-green-500 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @elseif(session('warning'))
        <div class="mb-3 p-3 bg-yellow-500/20 border border-yellow-500 text-yellow-700 rounded-md">
            {{ session('warning') }}
        </div>
    @elseif(session('error'))
        <div class="mb-3 p-3 bg-red-500/20 border border-red-500 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    {{-- ✅ Jobs Table --}}
    <div class="table-responsive">
        <table class="table table-bordered text-sm align-middle w-full">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Salary</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr class="border-b dark:border-gray-700">
                        <td>{{ $job->title }}</td>
                        <td>{{ $job->location }}</td>
                        <td>{{ ucfirst($job->job_type) }}</td>
                        <td>₹{{ number_format($job->salary_min) }} - ₹{{ number_format($job->salary_max) }}</td>
                        <td class="text-center">
                            <form action="{{ route('employee.jobs.apply', $job->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
    class="btn btn-primary btn-sm fw-semibold shadow-sm">
    Apply
</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-4">
                            No jobs available right now.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
