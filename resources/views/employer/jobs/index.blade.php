@extends('admin.layouts.app')

@section('content')
<style>

/* Page smooth fade */
.fade-premium {
    animation: fadePremium 0.45s ease forwards;
}
@keyframes fadePremium {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* MAIN CARD */
.premium-card {
    background: #ffffff;
    border: 1px solid #e3e3e3;
    padding: 34px;
    border-radius: 14px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.06);
    transition: 0.3s ease;
}
.premium-card:hover {
    box-shadow: 0 14px 46px rgba(0,0,0,0.10);
}

/* TITLES */
.page-title {
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -0.4px;
    color: #242424;
}

/* ----------------------------------------------
   PREMIUM BUTTONS — White Theme + Indigo Accent
---------------------------------------------- */
.btn-premium {
    background: #6366f1 !important;
    color: #fff !important;
    border-radius: 10px;
    padding: 10px 22px;
    font-weight: 600;
    border: none;
    transition: 0.25s ease;
}
.btn-premium:hover {
    background: #4f46e5 !important;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(99,102,241,0.35);
}

/* EDIT */
.btn-edit {
    background: #f3f4f6 !important;
    color: #3b3b3b !important;
    border-radius: 10px;
    padding: 8px 16px;
    font-weight: 600;
    transition: 0.25s;
}
.btn-edit:hover {
    background: #e5e7eb !important;
    transform: translateY(-2px);
}

/* DELETE */
.btn-delete {
    background: #ef4444 !important;
    color: white !important;
    border-radius: 10px;
    padding: 8px 16px;
    font-weight: 600;
    transition: 0.25s ease;
}
.btn-delete:hover {
    background: #dc2626 !important;
    transform: translateY(-2px);
}

/* ----------------------------------------------
   PREMIUM TABLE — White + Soft Grey Borders
---------------------------------------------- */
.table-premium {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e5e5e5;
}
.table-premium thead {
    background: #f7f7f7;
    color: #333;
    font-weight: 700;
}
.table-premium tbody tr {
    transition: 0.25s ease;
}
.table-premium tbody tr:hover {
    background: #fafafa;
    transform: translateX(4px);
}

/* Status badge */
.badge-status {
    background: #f3f4f6;
    color: #333;
    padding: 8px 16px;
    border-radius: 10px;
    font-weight: 600;
}

/* ----------------------------------------------
   PREMIUM MODAL (White, Glass, Smooth Shadow)
---------------------------------------------- */

.modal-dialog {
    transition: transform 0.25s ease !important;
}
.modal.fade .modal-dialog {
    transform: scale(0.93);
}
.modal.show .modal-dialog {
    transform: scale(1);
}

.premium-modal {
    border-radius: 18px !important;
    overflow: hidden;
    border: none;
    background: #ffffff;
    box-shadow: 0 18px 55px rgba(0,0,0,0.18);
}

/* Modal header (white glass) */
.premium-modal-header {
    background: #ffffff;
    border-bottom: 1px solid #eeeeee;
    padding: 20px 28px;
}

.premium-modal-title {
    font-size: 22px;
    font-weight: 800;
    color: #2d2d2d;
}

/* Resume box */
.resume-view-box {
    height: 78vh;
    border-radius: 12px;
    border: 1px solid #e5e5e5;
    overflow: hidden;
    background: #fff;
    box-shadow: inset 0 0 12px rgba(0,0,0,0.05);
}

.resume-frame {
    width: 100%;
    height: 100%;
    border: none;
}

</style>



<div class="container mt-5 fade-premium">

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success premium-card">
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- MAIN CARD --}}
    <div class="premium-card fade-premium">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">My Job Posts</h2>
            <a href="{{ route('employer.jobs.create') }}" class="btn-premium">
                <i class="bi bi-plus-circle"></i> Create Job
            </a>
        </div>

        @if ($jobs->isEmpty())

            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> No job posts found.
            </div>

        @else

            <div class="table-responsive">
                <table class="table table-premium align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td class="fw-bold">{{ $job->title }}</td>
                                <td>{{ $job->location }}</td>

                                <td>
                                    <span class="badge-status">{{ ucfirst($job->job_type) }}</span>
                                </td>

                                <td>
                                    <span class="badge-status">{{ $job->status }}</span>
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <a href="{{ route('employer.jobs.edit', $job->id) }}"
                                           class="btn btn-sm btn-edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        <form action="{{ route('employer.jobs.destroy', $job->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this job?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-delete">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                            {{-- PREMIUM MODAL --}}
                            <div class="modal fade" id="resumeModal{{ $job->id }}" tabindex="-1">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content premium-modal">

                                        <div class="premium-modal-header d-flex justify-content-between">
                                            <h5 class="premium-modal-title">Resume Preview</h5>
                                            <button class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="resume-view-box">
                                                @if($job->resume)
                                                    <iframe 
                                                        src="{{ asset('storage/resumes/' . $job->resume) }}" 
                                                        class="resume-frame">
                                                    </iframe>
                                                @else
                                                    <div class="text-center p-5 fw-bold text-danger">
                                                        No Resume Uploaded
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </tbody>

                </table>
            </div>

        @endif

    </div>

</div>

@endsection
