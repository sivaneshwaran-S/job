@extends('admin.layouts.app')

@section('title', 'All Job Listings')

@section('content')

<style>
    /* MAIN CARD WITH PREMIUM GLASS EFFECT */
    .premium-card {
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(18px);
        border-radius: 22px;
        border: 1px solid rgba(255,255,255,0.5);
        box-shadow: 0 12px 35px rgba(0,0,0,0.08);
    }

    /* HEADER */
    .premium-header {
        background: linear-gradient(135deg, #1a2a3c, #2e4053);
        padding: 22px 28px;
        border-radius: 22px 22px 0 0;
        color: white;
        border-bottom: 1px solid rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .premium-header h3 {
        font-weight: 700;
        letter-spacing: .4px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .premium-header i {
        font-size: 28px;
        color: #7eb6ff;
    }

    /* TABLE */
    table thead {
        background: #eef2f7;
        color: #444;
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background: rgba(56,103,214,0.07);
        transition: .25s ease;
    }

    /* BADGES */
    .status-badge {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    /* PREMIUM BUTTON */
    .btn-premium {
        border-radius: 40px !important;
        padding: 7px 18px !important;
        font-weight: 600;
        transition: .25s ease;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

</style>

<div class="container-fluid py-3">

    <!-- HEADER SECTION -->
    <div class="premium-card mb-4">
        <div class="premium-header">
            <h3 class="text-white">
                <i class="bi bi-briefcase"></i>
                All Job Listings
            </h3>
            <span class="text-light opacity-75">
                {{ $jobs->count() }} Total Jobs
            </span>
        </div>

        <div class="p-4">
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

                                <td class="fw-semibold text-dark">{{ $job->title }}</td>

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

</div>

@endsection
