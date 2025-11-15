@extends('admin.layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: #f5f6fa !important;
    }

    /* FILTER BOX */
    .filter-box {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        padding: 18px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: .25s;
    }
    .filter-box:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    /* JOB CARD */
    .premium-card {
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        transition: all .25s ease;
        border: 1px solid #e9ecef;
    }
    .premium-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 35px rgba(0,0,0,0.10);
    }

    .premium-header {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2b2d42;
    }

    .status-pill {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .pill-active { background: #d4f8e8; color: #1c7c54; }
    .pill-closed { background: #fde2e4; color: #b4161b; }
    .pill-applied { background: #e8e8ff; color: #3d45d7; }

    .btn-premium {
        background: #4b5bf1;
        color: #fff;
        border-radius: 10px;
        transition: .25s;
    }
    .btn-premium:hover {
        background: #3c4ad8;
    }
</style>

<div class="container py-4">

    {{-- FILTER SECTION --}}
    <div class="filter-box mb-4">
        <form method="GET" action="">
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search Job</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by title...">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="open" {{ request('status')=='open' ? 'selected' : '' }}>Active</option>
                        <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort By</label>
                    <select name="sort" class="form-select">
                        <option value="new" {{ request('sort')=='new'?'selected':'' }}>Newest First</option>
                        <option value="old" {{ request('sort')=='old'?'selected':'' }}>Oldest First</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-premium w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>

    {{-- JOB LISTINGS --}}
    @forelse($jobs as $job)

        @php
            $employee = auth()->user()->employee ?? null;

            $applied = $employee ? 
                \App\Models\JobApplication::where('job_id',$job->id)
                    ->where('employee_id',$employee->id)
                    ->exists()
                : false;
        @endphp

        <!-- JOB CARD -->
        <div class="premium-card p-3 mb-3">
            <div class="d-flex justify-content-between">

                <div>
                    <h5 class="premium-header mb-1">{{ $job->title }}</h5>
                    <small class="text-muted">
                        {{ $job->location }} • ₹{{ number_format($job->salary_min) }} - ₹{{ number_format($job->salary_max) }}
                    </small>
                </div>

                <div>
                    @if($job->status === 'open')
                        <span class="status-pill pill-active">Active</span>
                    @else
                        <span class="status-pill pill-closed">Closed</span>
                    @endif
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">

                <!-- VIEW DETAILS POPUP -->
                <button 
                    class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#jobModal{{ $job->id }}">
                    View Details
                </button>

                @if($job->status === 'closed')
                    <span class="status-pill pill-closed">Closed</span>

                @elseif($applied)
                    <span class="status-pill pill-applied">Applied</span>

                @else
                    <a href="{{ route('employee.jobs.showApplyForm', $job->id) }}" 
                       class="btn btn-premium btn-sm">
                       Apply
                    </a>
                @endif

            </div>
        </div>

        <!-- POPUP MODAL -->
        <div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-lg">

                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">{{ $job->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <p><strong>Location:</strong> {{ $job->location }}</p>
                        <p><strong>Salary:</strong> ₹{{ number_format($job->salary_min) }} - ₹{{ number_format($job->salary_max) }}</p>

                        <p><strong>Experience Required:</strong> {{ $job->experience ?? 'Not Specified' }}</p>
                        <p><strong>Job Type:</strong> {{ ucfirst($job->job_type ?? 'Not Mentioned') }}</p>
                        <p><strong>Education:</strong> {{ $job->education ?? 'Not Specified' }}</p>

                        @if($job->skills)
                        <p><strong>Skills Required:</strong></p>
                        @foreach(explode(',', $job->skills) as $skill)
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill me-1 mb-1">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                        <br><br>
                        @endif

                        <p><strong>Description:</strong></p>
                        <p class="text-muted" style="line-height:1.6;">
                            {!! nl2br(e($job->description)) !!}
                        </p>

                    </div>

                    <div class="modal-footer">

                        @if($job->status === 'closed')
                            <span class="status-pill pill-closed">Closed</span>

                        @elseif($applied)
                            <span class="status-pill pill-applied">Already Applied</span>

                        @else
                            <a href="{{ route('employee.jobs.showApplyForm', $job->id) }}" 
                               class="btn btn-premium px-4">
                                Apply Now
                            </a>
                        @endif

                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    @empty
        <div class="text-center text-muted py-5">No jobs found.</div>
    @endforelse

</div>

@endsection
