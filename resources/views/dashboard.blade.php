@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-0">
    <h1 class="h3 mb-3">
        <strong>{{ ucfirst($user->role) }}</strong> Dashboard
    </h1>

    <div class="row">
        {{-- ADMIN SECTION --}}
        @if($user->role === 'admin')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employers</h5>
                        <h1 class="mt-1 mb-3">{{ $data['employers'] }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employees</h5>
                        <h1 class="mt-1 mb-3">{{ $data['employees'] }}</h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jobs Posted</h5>
                        <h1 class="mt-1 mb-3">{{ $data['jobs'] }}</h1>
                    </div>
                </div>
            </div>
        @endif

        {{-- EMPLOYER SECTION --}}
        @if($user->role === 'employer')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Job Posts</h5>
                        <h1 class="mt-1 mb-3">{{ $data['jobs'] }}</h1>
                    </div>
                </div>
            </div>
        @endif

        {{-- EMPLOYEE SECTION --}}
        @if($user->role === 'employee')
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Applied Jobs</h5>
                        <h1 class="mt-1 mb-3">{{ $data['applications'] ?? 0 }}</h1>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
