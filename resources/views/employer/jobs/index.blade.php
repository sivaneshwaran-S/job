@extends('admin.layouts.app')

@section('content')
<style>
    /* ---- PREMIUM GLASS CARD ---- */
    .premium-card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 22px;
        padding: 30px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.45);
        transition: .35s ease;
    }
    .premium-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 55px rgba(0,0,0,0.18);
    }

    /* ---- PAGE TITLE ---- */
    .page-title {
        font-size: 32px;
        font-weight: 800;
        background: linear-gradient(90deg, #2b3cff, #8b5cff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }

    /* ---- PREMIUM BUTTON ---- */
    .btn-premium {
        background: linear-gradient(135deg, #4a6bff, #8d4eff);
        border: none;
        border-radius: 14px;
        padding: 10px 20px;
        color: white !important;
        font-weight: 600;
        box-shadow: 0 4px 14px rgba(80, 60, 255, 0.4);
        transition: .25s ease;
    }
    .btn-premium:hover {
        background: linear-gradient(135deg, #344bff, #7132ff);
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(80, 60, 255, 0.55);
    }

    /* ---- TABLE ---- */
    .table-premium thead {
        background: linear-gradient(135deg, #1f1f1f, #444);
        color: white;
        border-radius: 12px;
        overflow: hidden;
    }
    .table-premium tbody tr {
        transition: .25s ease;
    }
    .table-premium tbody tr:hover {
        background: rgba(76, 110, 255, 0.08);
        backdrop-filter: blur(6px);
        transform: scale(1.01);
    }

    /* ---- ACTION BUTTONS ---- */
    .btn-edit {
        background: #ffca2c;
        color: #000 !important;
        font-weight: 600;
        border-radius: 10px;
        padding: 6px 12px;
        transition: .25s;
    }
    .btn-edit:hover {
        background: #e0b325;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #dc3545;
        color: #fff !important;
        font-weight: 600;
        border-radius: 10px;
        padding: 6px 12px;
        transition: .25s;
    }
    .btn-delete:hover {
        background: #bb2d3b;
        transform: translateY(-2px);
    }

    /* ---- BADGES ---- */
    .badge-status {
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        box-shadow: 0 3px 6px rgba(0,0,0,0.15);
    }

    .badge-open {
        background: linear-gradient(135deg, #28a745, #5cf27b);
        color: #fff;
    }

    .badge-closed {
        background: linear-gradient(135deg, #6c757d, #9aa0a6);
        color: #fff;
    }

</style>
<div class="container mt-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show premium-card" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="premium-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="page-title">My Job Posts</h2>

            <a href="{{ route('employer.jobs.create') }}" class="btn-premium">
                <i class="bi bi-plus-circle"></i> Post New Job
            </a>
        </div>

        @if ($jobs->isEmpty())
            <div class="alert alert-info text-center">
                No job posts found.
            </div>
        @else

            <div class="table-responsive">
                <table class="table table-premium align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th style="width: 160px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td class="fw-bold text-dark">{{ $job->title }}</td>
                                <td>{{ $job->location }}</td>
                                <td>
                                    <span class="badge bg-primary badge-status">
                                        {{ ucfirst($job->job_type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-status bg-{{ $job->status === 'open' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('employer.jobs.edit', $job->id) }}" class="btn btn-sm btn-edit">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <form action="{{ route('employer.jobs.destroy', $job->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this job?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-delete">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endif
    </div>
</div>

@endsection
