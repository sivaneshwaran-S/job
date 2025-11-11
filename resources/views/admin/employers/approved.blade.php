@extends('admin.layouts.app')

@section('title', 'Approved Employers')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3"><strong>Approved</strong> Employers</h1>

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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No approved employers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
