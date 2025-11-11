@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid p-0">
	<h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1>

	<div class="row">
		<div class="col-sm-6 col-lg-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Employers</h5>
					<h1 class="mt-1 mb-3">{{ $employers ?? 0 }}</h1>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-lg-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Employees</h5>
					<h1 class="mt-1 mb-3">{{ $employees ?? 0 }}</h1>
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-lg-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Jobs Posted</h5>
					<h1 class="mt-1 mb-3">{{ $jobs ?? 0 }}</h1>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
