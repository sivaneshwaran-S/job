@extends('admin.layouts.app')

@section('content')

<style>
    /* ------------------------------------------
       MATCHED EXACTLY TO YOUR SIDEBAR COLORS
    ------------------------------------------ */
    :root {
        --navy-dark: #222e3c;       /* Sidebar BG */
        --primary-blue: #60a0ffff;    /* Sidebar active blue */
        --primary-blue-dark: #0b5ed7;
        --soft-bg: #f5f7fa;
        --border-light: #d7dce3;
        --text-main: #1e1e1e;
    }

    /* ------------------------------------------
       PREMIUM CARD
    ------------------------------------------ */
    .premium-card {
        background: white;
        border-radius: 18px;
        padding: 32px;
        border: 1px solid var(--border-light);
        box-shadow: 0px 14px 38px rgba(0, 0, 0, 0.08);
        animation: fadeUp 0.5s ease;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .premium-title {
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--navy-dark);
        display: flex;
        align-items: center;
    }

    .premium-title i {
        color: var(--primary-blue);
        font-size: 1.5rem;
    }

    /* ------------------------------------------
       PREMIUM TABLE
    ------------------------------------------ */
    .premium-table {
        border-radius: 14px !important;
        overflow: hidden;
    }

    .premium-table thead {
        background: var(--navy-dark);
        color: white;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .premium-table tbody tr {
        transition: 0.25s ease;
    }

    .premium-table tbody tr:hover {
        background: #e9f2ff;
        transform: translateX(4px);
    }

    /* ------------------------------------------
       BUTTON UPGRADE - MATCH SIDEBAR BLUE
    ------------------------------------------ */
    .resume-btn {
        background: var(--primary-blue);
        color: #fff !important;
        padding: 6px 16px;
        border-radius: 8px;
        font-size: 0.83rem;
        font-weight: 500;
        border: none;
        transition: 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .resume-btn:hover {
        background: var(--primary-blue-dark);
        transform: translateY(-2px);
    }

    .resume-btn:active {
        transform: scale(0.96);
    }

</style>


<div class="premium-card">
    <h2 class="premium-title mb-4">
        <i class="bi bi-people-fill me-2"></i> Approved Applicants
    </h2>

    @if(session('success'))
        <div class="alert alert-success rounded-3">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif


    <div class="table-responsive">
        <table class="table premium-table table-hover align-middle">
            <thead>
                <tr>
                    <th class="text-white">Job Title</th>
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
                                <i class="bi bi-file-earmark-text me-1"></i>
                                View Resume
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
