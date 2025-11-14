@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">

    <h1 class="h3 mb-4 text-center">
        <strong>Admin</strong> Dashboard
    </h1>

    <div class="row justify-content-center g-4">

        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-lg border-0 rounded-4 card-hover text-center p-3">
                <div class="card-body">
                    <div class="icon bg-primary text-white rounded-circle mb-3 d-inline-flex justify-content-center align-items-center"
                        style="width:60px;height:60px;font-size:22px;">
                        <i class="fa fa-building"></i>
                    </div>
                    <h5 class="card-title text-secondary">Employers</h5>
                    <h1 class="mt-1 fw-bold">{{ $employers ?? 0 }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-lg border-0 rounded-4 card-hover text-center p-3">
                <div class="card-body">
                    <div class="icon bg-success text-white rounded-circle mb-3 d-inline-flex justify-content-center align-items-center"
                        style="width:60px;height:60px;font-size:22px;">
                        <i class="fa fa-users"></i>
                    </div>
                    <h5 class="card-title text-secondary">Employees</h5>
                    <h1 class="mt-1 fw-bold">{{ $employees ?? 0 }}</h1>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card shadow-lg border-0 rounded-4 card-hover text-center p-3">
                <div class="card-body">
                    <div class="icon bg-warning text-white rounded-circle mb-3 d-inline-flex justify-content-center align-items-center"
                        style="width:60px;height:60px;font-size:22px;">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <h5 class="card-title text-secondary">Jobs Posted</h5>
                    <h1 class="mt-1 fw-bold">{{ $jobs ?? 0 }}</h1>
                </div>
            </div>
        </div>

    </div>
</div>