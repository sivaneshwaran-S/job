@extends('admin.layouts.app')

@section('title', 'Pending Employers')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Pending</strong> Employers</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company</th>
                        <th>Industry</th>
                        <th>Address</th>
                        <th>Website</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employers as $employer)
                        <tr>
                            <td>{{ $employer->id }}</td>
                            <td>{{ $employer->company_name }}</td>
                            <td>{{ $employer->industry_type ?? 'N/A' }}</td>
                            <td>{{ $employer->address ?? '-' }}</td>
                            <td>{{ $employer->website ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.employers.approve', $employer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form action="{{ route('admin.employers.reject', $employer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No pending employers.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
