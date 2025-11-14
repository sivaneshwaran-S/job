@extends('admin.layouts.app')

@section('content')

<style>
/* Smooth appear */
.fade-up {
    animation: fadeUp .45s ease-out both;
}
@keyframes fadeUp {
    from {opacity:0; transform:translateY(12px);}
    to {opacity:1; transform:translateY(0);}
}

/* Ultra-premium card */
.job-card {
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e8ecf3;
    padding: 28px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
    transition: .25s ease;
}
.job-card:hover {
    box-shadow: 0 10px 28px rgba(0,0,0,0.08);
    transform: translateY(-3px);
}

/* Table */
.table-p {
    border-collapse: separate;
    border-spacing: 0 10px;
}
.table-p thead tr th {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #6b7280;
    padding-bottom: 12px;
}
.table-p tbody tr {
    background: #fdfdfd;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    transition: .25s;
}
.table-p tbody tr:hover {
    background: #f8faff;
    transform: scale(1.01);
}
.table-p td {
    padding: 16px 18px !important;
    font-size: 15px;
}

/* Badges — corporate slim */
.badge-slim {
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
}
.badge-open {
    background: #e5f7ee;
    color: #157a3c;
}
.badge-closed {
    background: #ffeaea;
    color: #b51f1f;
}
.badge-applied {
    background: #e8ecff;
    color: #2b3cbf;
}

/* Apply button */
.btn-apply {
    background: #3b5bfd;
    color: #fff;
    border: none;
    padding: 7px 18px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    transition: .25s ease;
    box-shadow: 0 4px 12px rgba(59,91,253,.25);
}
.btn-apply:hover {
    background: #2f4ae6;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(59,91,253,.35);
}
</style>

<div class="container-fluid fade-up">

    <h2 class="mb-4 fw-bold" style="color:#1f2937;">Available Jobs</h2>

    <div class="job-card">

        {{-- Alerts --}}
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('warning')) <div class="alert alert-warning">{{ session('warning') }}</div> @endif
        @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="table-responsive">
            <table class="table table-p align-middle">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td class="fw-semibold text-dark">{{ $job->title }}</td>
                        <td>{{ $job->location }}</td>
                        <td>{{ ucfirst($job->job_type) }}</td>

                        <td class="fw-bold text-primary">
                            ₹{{ number_format($job->salary_min) }} - ₹{{ number_format($job->salary_max) }}
                        </td>

                        <td>
                            @if($job->status == 'open')
                                <span class="badge-slim badge-open">Open</span>
                            @elseif($job->status == 'closed')
                                <span class="badge-slim badge-closed">Closed</span>
                            @endif
                        </td>

                        <td class="text-center">

                            @php
                                $employee = auth()->user()->employee ?? null;
                                $applied = $employee ?
                                    \App\Models\JobApplication::where('job_id',$job->id)
                                        ->where('employee_id',$employee->id)
                                        ->exists()
                                    : false;
                            @endphp

                            @if($job->status === 'closed')
                                <span class="badge-slim badge-closed">Closed</span>

                            @elseif($applied)
                                <span class="badge-slim badge-applied">Applied</span>

                            @else
                                <a href="{{ route('employee.jobs.showApplyForm', $job->id) }}"
                                   class="btn-apply btn-sm">
                                    Apply
                                </a>
                            @endif

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No jobs found.</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
