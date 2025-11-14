@extends('admin.layouts.app')

@section('title', 'Applicants for ' . $job->title)

@section('content')

<style>

    /* -------------------------
       PREMIUM GLOBAL LOOK
    -------------------------- */

    :root {
        --primary: #3B82F6;
        --primary-light: #E8F1FF;
        --card-bg: #ffffff;
        --soft-shadow: 0 4px 20px rgba(0,0,0,0.07);
        --soft-border: 1px solid #E2E8F0;
    }

    /* PAGE HEADER */
    .premium-header {
        background: linear-gradient(135deg, #86b4ffff, #7f9dffff);
        padding: 34px 30px;
        border-radius: 20px;
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        margin-bottom: 30px;
    }

    .premium-header h2 {
        font-size: 28px;
        font-weight: 800;
    }


    /* CARDS */
    .premium-card {
        background: var(--card-bg);
        border-radius: 18px;
        padding: 28px;
        border: var(--soft-border);
        box-shadow: var(--soft-shadow);
        margin-bottom: 25px;
    }


    /* TABLE */
    .premium-table thead tr {
        background: var(--primary-light);
        color: #1e293b;
    }

    .premium-table tbody tr {
        transition: 0.25s ease;
    }

    .premium-table tbody tr:hover {
        background: #F8FAFC;
        box-shadow: 0 3px 10px rgba(0,0,0,0.07);
        transform: translateY(-2px);
    }


    /* AVATAR */
    .avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
        border: 2px solid #e5e7eb;
    }


    /* SKILL TAGS */
    .skill-tag {
        background: #EEF2FF;
        color: #4338CA;
        padding: 4px 12px;
        font-size: 11px;
        border-radius: 30px;
        margin: 2px;
        display: inline-block;
        font-weight: 600;
    }


    /* STATUS BADGES */
    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pending { background: #FFF2CC; color: #9A6B00; }
    .status-approved { background: #C8F8DE; color: #065F46; }
    .status-rejected { background: #E2E8F0; color: #475569; }


    /* DROPDOWN BUTTON */
    .dropdown-custom {
        border-radius: 12px;
        background: #EDF3FF;
        padding: 6px 15px;
        font-weight: 600;
        border: none;
        color: #3B4F75;
    }

    /* PREMIUM BUTTON */
    .btn-premium {
        border-radius: 12px;
        padding: 7px 15px;
        font-weight: 600;
        border: none;
        transition: 0.25s;
    }

    .btn-view { background: #3B82F6; color: white; }
    .btn-view:hover { background: #1D4ED8; }

    .btn-approve { background: #10B981; color: white; }
    .btn-approve:hover { background: #059669; }

    .btn-secondary { background: #CBD5E1; color: #334155; }

    /* MODAL */
    .modal-content {
        border-radius: 14px;
        padding: 20px;
    }

</style>


<div class="container-fluid">

    <!-- HEADER -->
    <div class="premium-header">
        <h2>Applicants for: {{ $job->title }}</h2>
        <p class="mb-0">Review applicant details, resumes, and take action.</p>
    </div>


    <!-- JOB INFO -->
    <div class="premium-card">
        <h5 class="fw-bold mb-3" style="color:#3B82F6;">Job Information</h5>

        <div class="row">
            <div class="col-md-4"><strong>Company:</strong> {{ $job->employer->company_name ?? 'N/A' }}</div>
            <div class="col-md-4"><strong>Location:</strong> {{ $job->location }}</div>
        </div>
    </div>


    <!-- APPLICANT TABLE -->
    <div class="premium-card">
        <h5 class="fw-bold mb-3" style="color:#3B82F6;">Applicants List</h5>

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
                            $avatar = "https://ui-avatars.com/api/?name=" . urlencode($application->employee->user->name) . "&background=3B82F6&color=fff";
                        @endphp

                        <tr>
                            <!-- APPLICANT WITH AVATAR -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $avatar }}" class="avatar">
                                    <span class="fw-semibold">{{ $application->employee->user->name }}</span>
                                </div>
                            </td>

                            <td>{{ $application->employee->user->email }}</td>
                            <td>{{ $application->employee->experience_years ?? '-' }} yrs</td>

                            <!-- SKILLS -->
                            <td>
                                @foreach ($skills as $skill)
                                    @if(trim($skill) != '')
                                        <span class="skill-tag">{{ trim($skill) }}</span>
                                    @endif
                                @endforeach
                            </td>

                            <!-- STATUS -->
                            <td>
                                <span class="status-badge
                                    @if($application->status == 'pending') status-pending
                                    @elseif($application->status == 'approved') status-approved
                                    @else status-rejected
                                    @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>

                            <!-- RESUME MODAL -->
                            <td>
                                @if($application->employee->resume_file)
                                    <button class="btn-premium btn-view" data-bs-toggle="modal"
                                            data-bs-target="#resumeModal{{ $application->id }}">
                                        Preview
                                    </button>
                                @else
                                    <span class="text-danger fw-semibold">No Resume</span>
                                @endif
                            </td>

                            <!-- ACTIONS DROPDOWN -->
                            <td>
                                @if($application->status == 'pending')
                                    <form method="POST"
                                          action="{{ route('admin.applicants.approve', $application->id) }}"
                                          onsubmit="return confirm('Approve applicant?');">
                                        @csrf
                                        <button class="btn-premium btn-approve">Approve</button>
                                    </form>
                                @else
                                    <button class="btn-premium btn-secondary" disabled>Approved</button>
                                @endif
                            </td>

                        </tr>

                        <!-- RESUME PREVIEW MODAL -->
                        <div class="modal fade" id="resumeModal{{ $application->id }}" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <h5 class="fw-bold mb-3">Resume Preview</h5>
                                    <embed src="{{ asset('storage/' . $application->employee->resume_file) }}"
                                           type="application/pdf"
                                           width="100%" height="600px" />
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No applicants yet.</td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
