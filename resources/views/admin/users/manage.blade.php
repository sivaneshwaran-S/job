@extends('admin.layouts.app')

@section('content')

<style>
    /* PAGE BACKGROUND */
    body {
        background: #f4f7fb !important;
    }

    /* MAIN CARD */
    .premium-card {
        background: rgba(255, 255, 255, 0.7);
        border-radius: 22px;
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.45);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    /* HEADER MATCHING SIDEBAR COLORS */
    .premium-header {
        background: linear-gradient(135deg, #1a2a3c, #2e4053);
        padding: 20px;
        border-radius: 22px 22px 0 0;
        color: white;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .premium-header h5 {
        font-weight: 700;
        letter-spacing: .5px;
    }

    /* AVATAR */
    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        background: linear-gradient(135deg, #4b7bec, #3867d6);
        box-shadow: 0 4px 10px rgba(56,103,214,0.3);
        font-size: 18px;
    }

    /* TABLE */
    table {
        border-radius: 18px;
        overflow: hidden;
    }

    thead tr {
        background: #eef2f8 !important;
        font-weight: 600;
        color: #394b59;
    }

    tbody tr:hover {
        background: rgba(56,103,214,0.06);
        transition: .25s ease;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 12px;
    }

    /* BUTTONS PREMIUM */
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
</style>

<div class="container-fluid py-4">

    <div class="premium-card">

        <!-- HEADER MATCHING SIDEBAR -->
        <div class="premium-header d-flex justify-content-between align-items-center">
            <h5 class="text-white"><i class="bi bi-people me-2 text-white"></i> Manage Users</h5>

            <form method="GET" action="{{ route('admin.users.manage') }}" class="d-flex align-items-center gap-2">
                <select name="status" class="form-select form-select-sm rounded-pill shadow-sm">
                    <option value="">All Users</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                <button class="btn btn-light btn-sm btn-premium">
                    <i class="bi bi-filter-circle me-1"></i> Filter
                </button>
            </form>
        </div>

        <div class="p-4 table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td class="d-flex align-items-center">
                            <div class="avatar-circle me-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-semibold text-dark">{{ $user->name }}</span>
                        </td>

                        <td class="text-muted">{{ $user->email }}</td>

                        <td>
                            <span class="badge status-badge bg-info text-dark bg-opacity-25">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td>
                            <span class="status-badge
                                @if($user->status == 'approved') bg-success text-success bg-opacity-25
                                @elseif($user->status == 'pending') bg-warning text-warning bg-opacity-25
                                @else bg-danger text-danger bg-opacity-25
                                @endif">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>

                        <td>
                            @if($user->status !== 'approved')
                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm btn-premium text-white">
                                    <i class="bi bi-check-circle me-1"></i> Approve
                                </button>
                            </form>
                            @endif

                            @if($user->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm btn-premium text-white">
                                    <i class="bi bi-x-circle me-1"></i> Reject
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-exclamation-circle fs-4 d-block"></i>
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
