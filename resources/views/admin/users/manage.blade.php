@extends('admin.layouts.app')

@section('content')

<style>
    /* Light Glass + Premium Styling */
    .glass-card {
        backdrop-filter: blur(18px);
        background: rgba(255, 255, 255, 0.85);
        border-radius: 20px;
        border: 1px solid rgba(200, 200, 200, 0.35);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    .glass-header {
        backdrop-filter: blur(12px);
        background: linear-gradient(120deg, #eef7ff, #d9ecff);
        border-radius: 20px 20px 0 0;
        border-bottom: 1px solid rgba(200, 200, 200, 0.4);
    }

    .avatar-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        font-size: 17px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #a3d0ff, #7db8ff);
        color: white;
    }

    .btn-premium {
        transition: 0.25s ease;
        border-radius: 40px !important;
        padding: 6px 16px !important;
        font-weight: 600;
    }

    .btn-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .status-badge {
        border-radius: 50px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
    }

    thead tr {
        background: linear-gradient(120deg, #e8f2ff, #edf6ff);
        color: #3b3b3b;
    }

    .table-hover tbody tr:hover {
        background: rgba(150, 200, 255, 0.12);
    }
</style>

<div class="container-fluid py-4">

    <div class="card glass-card border-0">

        <!-- Gentle Light Header -->
        <div class="card-header glass-header py-3 px-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">
                <i class="bi bi-people me-2"></i> Manage Users
            </h5>

            <form method="GET" action="{{ route('admin.users.manage') }}" class="d-flex align-items-center gap-2">
                <select name="status" class="form-select form-select-sm rounded-pill shadow-sm">
                    <option value="">All Users</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 btn-premium">
                    <i class="bi bi-filter-circle me-1"></i> Filter
                </button>
            </form>
        </div>

        <div class="card-body table-responsive px-4 py-4">
            <table class="table table-hover align-middle">
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
                            <span class="fw-semibold text-secondary">{{ $user->name }}</span>
                        </td>

                        <td class="text-muted">{{ $user->email }}</td>

                        <td>
                            <span class="badge bg-info bg-opacity-25 text-primary status-badge">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td>
                            <span class="status-badge 
                                @if($user->status == 'approved') bg-success bg-opacity-25 text-success
                                @elseif($user->status == 'pending') bg-warning bg-opacity-25 text-warning
                                @else bg-danger bg-opacity-25 text-danger
                                @endif">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>

                        <td>
                            @if($user->status !== 'approved')
                            <form method="POST" action="{{ route('admin.users.approve', $user->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm btn-premium bg-success bg-opacity-75 text-white">
                                    <i class="bi bi-check-circle me-1"></i> Approve
                                </button>
                            </form>
                            @endif

                            @if($user->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.users.reject', $user->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-danger btn-sm btn-premium bg-danger bg-opacity-75 text-white">
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
