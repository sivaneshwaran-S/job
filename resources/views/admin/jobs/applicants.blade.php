@extends('admin.layouts.app')

@section('title', 'Applicants for ' . $job->title)

@section('content')

<style>
    /* ----------------------------------------------------
       PREMIUM COLOR SYSTEM
    ----------------------------------------------------- */

    :root {
        --primary: #4b7bec;
        --primary-dark: #91b2fdff;
        --primary-soft: #e6eeff;

        --success: #10B981;
        --success-soft: #D1FAE5;

        --warning: #FBBF24;
        --warning-soft: #FFF7D6;

        --danger: #EF4444;
        --danger-soft: #FFE2E2;

        --text-dark: #1f2937;
        --text-muted: #6b7280;

        --card-bg: rgba(255, 255, 255, 0.82);
        --glass-border: 1px solid rgba(255, 255, 255, 0.45);
        --glass-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    }

    /* ----------------------------------------------------
       HEADER SECTION
    ----------------------------------------------------- */

    .premium-header {
        background: linear-gradient(135deg, #1a2a3c, #2e4053);
        padding: 32px 34px;
        border-radius: 22px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.15);
        color: white;
        margin-bottom: 32px;
        border: 1px solid rgba(255,255,255,0.15);
    }

    .premium-header h2 {
        font-weight: 800;
        letter-spacing: .4px;
        margin-bottom: 8px;
    }


    /* ----------------------------------------------------
       GLASS CARD
    ----------------------------------------------------- */

    .glass-card {
        background: var(--card-bg);
        backdrop-filter: blur(16px);
        border-radius: 22px;
        padding: 30px;
        border: var(--glass-border);
        box-shadow: var(--glass-shadow);
        margin-bottom: 28px;
    }


    /* ----------------------------------------------------
       TABLE DESIGN
    ----------------------------------------------------- */

    .premium-table thead tr {
        background: var(--primary-soft);
        color: var(--text-dark);
        font-weight: 600;
    }

    .premium-table tbody tr {
        transition: .25s ease;
    }

    .premium-table tbody tr:hover {
        background: rgba(56,103,214,0.06);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }


    /* ----------------------------------------------------
       AVATAR
    ----------------------------------------------------- */

    .avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(0,0,0,0.08);
        margin-right: 12px;
    }


    /* ----------------------------------------------------
       SKILL TAGS
    ----------------------------------------------------- */

    .skill-tag {
        background: #eef2ff;
        color: #4338ca;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin: 2px;
    }


    /* ----------------------------------------------------
       STATUS BADGES
    ----------------------------------------------------- */

    .badge-status {
        padding: 6px 14px;
        border-radius: 18px;
        font-size: 12px;
        font-weight: 700;
    }

    .pending { background: var(--warning-soft); color: #8a5c00; }
    .approved { background: var(--success-soft); color: #065f46; }
    .rejected { background: var(--danger-soft); color: #b91c1c; }


    /* ----------------------------------------------------
       BUTTONS
    ----------------------------------------------------- */

    .btn-premium {
        border-radius: 40px !important;
        padding: 7px 18px !important;
        font-weight: 600;
        transition: .25s ease;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-view {
    white-space: nowrap !important;   /* Prevents text from breaking */
    border-radius: 12px !important;   /* Ensures rounded corners */
    padding: 8px 16px !important;     /* Makes button taller and premium */
    display: inline-block !important;
}

    .btn-view:hover { background: var(--primary-dark); }

    .btn-approve { background: var(--success); color: white; }
    .btn-approve:hover { background: #059669; }

    .btn-disabled { background: #d6d9df; color: #6b7280; }


    /* ----------------------------------------------------
       MODAL
    ----------------------------------------------------- */

    .modal-content {
        border-radius: 18px;
        padding: 25px;
        border: none;
    }

</style>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="premium-header">
        <h2 class="text-white">Applicants for: {{ $job->title }}</h2>
        <p class="opacity-75 mb-0">Review applicants, check resumes, approve or reject.</p>
    </div>


    <!-- JOB INFO CARD -->
    <div class="glass-card">
        <h5 class="fw-bold mb-4 text-primary">Job Information</h5>

        <div class="row mb-2">
            <div class="col-md-4"><strong>Company:</strong> {{ $job->employer->company_name ?? 'N/A' }}</div>
            <div class="col-md-4"><strong>Location:</strong> {{ $job->location }}</div>
            <div class="col-md-4"><strong>Salary:</strong> ₹{{ $job->salary_min }} - ₹{{ $job->salary_max }}</div>
        </div>
    </div>


    <!-- APPLICANTS TABLE -->
    <div class="glass-card">
        <h5 class="fw-bold mb-4 text-primary">Applicants List</h5>

        <div class="table-responsive">
            <table class="table premium-table align-middle">
                <thead>
                    <tr>
                        <th>Applicant</th>
                        <th>Email</th>
                        <th>Experience</th>
                        <th>Skills</th>
                        <th>Status</th>
                        <th>Resume</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($job->applications as $application)
                        @php
                            $skills = explode(',', $application->employee->skills ?? '');
                            $avatar = "https://ui-avatars.com/api/?name="
                                        . urlencode($application->employee->user->name)
                                        . "&background=4b7bec&color=fff";
                        @endphp

                        <tr>
                            <!-- APPLICANT -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $avatar }}" class="avatar">
                                    <span class="fw-semibold">{{ $application->employee->user->name }}</span>
                                </div>
                            </td>

                            <td>{{ $application->employee->user->email }}</td>

                            <td>{{ $application->employee->experience_years ?? '0' }} yrs</td>

                            <!-- SKILLS -->
                            <td>
                                @foreach ($skills as $skill)
                                    @if(trim($skill) !== '')
                                        <span class="skill-tag">{{ trim($skill) }}</span>
                                    @endif
                                @endforeach
                            </td>

                            <!-- STATUS BADGE -->
                            <td>
                                <span class="badge-status
                                    @if($application->status == 'pending') pending
                                    @elseif($application->status == 'approved') approved
                                    @else rejected
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>

                            <!-- RESUME -->
                            <td>
    @if($application->employee->resume_file)
        <a href="{{ asset('storage/' . $application->employee->resume_file) }}" 
           target="_blank" 
           class="btn-premium btn-view">
           View Resume
        </a>
    @else
        <span class="text-danger fw-semibold">No Resume</span>
    @endif
</td>


                            <!-- ACTION -->
                            <td>
                                @if($application->status === 'pending')
                                    <form method="POST"
                                          action="{{ route('admin.applicants.approve', $application->id) }}">
                                        @csrf
                                        <button class="btn-premium btn-approve">Approve</button>
                                    </form>
                                @else
                                    <button class="btn-premium btn-disabled" disabled>Approved</button>
                                @endif
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-exclamation-circle fs-4 d-block"></i>
                                No applicants yet.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
