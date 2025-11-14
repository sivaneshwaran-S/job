@extends('admin.layouts.app')

@section('content')

<style>
    /* Light/Dark mode adaptive variables */
    :root {
        --card-bg: #ffffff;
        --card-text: #1c1c1c;
        --table-header-bg: #3f51b5;
        --table-header-text: #ffffff;
        --row-hover-bg: rgba(63, 81, 181, 0.10);
        --button-bg: #5c6bc0;
        --button-text: #ffffff;
    }

    html.dark :root {
        --card-bg: #1e1e2f;
        --card-text: #f0f0f7;
        --table-header-bg: #283593;
        --table-header-text: #ffffff;
        --row-hover-bg: rgba(92, 107, 192, 0.25);
        --button-bg: #7986cb;
        --button-text: #ffffff;
    }

    .premium-card {
        background: var(--card-bg);
        color: var(--card-text);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(255,255,255,0.12);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .premium-title {
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--table-header-bg);
    }

    .premium-table thead {
        background: var(--table-header-bg);
        color: var(--table-header-text);
    }

    .premium-table tbody tr:hover {
        background: var(--row-hover-bg);
        cursor: pointer;
    }

    th{
        color:white;
    }
    .resume-btn {
        background: var(--button-bg) !important;
        color: var(--button-text) !important;
        padding: 7px 16px;
        font-size: 0.85rem;
        border-radius: 6px;
        border: none;
        transition: .3s ease-in-out;
    }

    .resume-btn:hover {
        transform: translateY(-2px);
        opacity: 0.95;
    }
</style>

<div class="premium-card">
    <h2 class="premium-title mb-4">
        <i class="bi bi-people-fill me-2"></i> Approved Applicants
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table premium-table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th  class="text-white">Job Title</th>
                    <th class="text-white">Applicant Name</th>
                    <th class="text-white">Email</th>
                    <th class="text-white">Qualification</th>
                    <th class="text-white">Resume</th>
                </tr>
            </thead>

            <tbody>
                @forelse($applications as $app)
                <tr>
                    <td class="fw-semibold">{{ $app->job->title ?? 'N/A' }}</td>
                    <td>{{ $app->employee->user->name ?? 'N/A' }}</td>
                    <td>{{ $app->employee->user->email ?? 'N/A' }}</td>
                    <td>{{ $app->employee->qualification ?? 'N/A' }}</td>

                    <td>
                        @if($app->employee->resume_file)
                            <a href="{{ asset('storage/' . $app->employee->resume_file) }}"
                               target="_blank"
                               class="resume-btn">
                                <i class="bi bi-file-earmark-text me-1"></i> View Resume
                            </a>
                        @else
                            <span class="text-danger fw-semibold">No Resume</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle"></i> No approved applicants found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
