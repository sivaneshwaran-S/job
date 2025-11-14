@extends('admin.layouts.app')

@section('title', 'All Job Listings')

@section('content')

<style>
    /* Soft Premium Glass Styling */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(14px);
        border-radius: 18px;
        border: 1px solid rgba(220, 220, 220, 0.45);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }

    .section-title {
        font-weight: 700;
        color: #4a4a4a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        font-size: 28px;
        color: #6aa6ff;
    }

    table thead {
        background: linear-gradient(120deg, #eef6ff, #dfefff);
        color: #444;
        border-bottom: 2px solid #e3e3e3;
    }

    .table-hover tbody tr:hover {
        background: rgba(150, 200, 255, 0.12);
        transition: 0.2s ease;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-premium {
        border-radius: 30px;
        padding: 6px 14px;
        font-weight: 600;
        transition: 0.25s;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>


<div class="container-fluid">

    <!-- Premium Title -->
    <div class="mb-4">
        <h1 class="section-title">
            <i class="bi bi-briefcase"></i>
            All Job Listings
        </h1>
    </div>

    <!-- Premium Card -->
    <div class="card glass-card p-4">

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Salary Range</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jobs as $job)
                        <tr>
                            <td class="fw-semibold">{{ $job->id }}</td>
                            <td>{{ $job->title }}</td>

                            <td class="text-muted">
                                {{ $job->employer->company_name ?? 'N/A' }}
                            </td>

                            <td>{{ $job->location }}</td>

                            <td>
                                <span class="fw-semibold text-primary">
                                    ₹{{ $job->salary_min }} - ₹{{ $job->salary_max }}
                                </span>
                            </td>

                            <td>
                                <span class="status-badge 
                                    @if($job->status == 'active') bg-success bg-opacity-25 text-success
                                    @elseif($job->status == 'pending') bg-warning bg-opacity-25 text-warning
                                    @else bg-danger bg-opacity-25 text-danger
                                    @endif">
                                    {{ ucfirst($job->status) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('admin.jobs.applicants', $job->id) }}" 
                                   class="btn btn-primary btn-sm btn-premium">
                                   View Applicants
                                </a>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-exclamation-circle fs-4 d-block"></i>
                                No job listings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
