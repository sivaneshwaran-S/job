<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="{{ route('dashboard') }}">
			<span class="align-middle">Job Portal</span>
		</a>

		<ul class="sidebar-nav">

			{{-- 🔹 Common Links for All Users --}}
			<li class="sidebar-header">Main</li>

			<li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ route('dashboard') }}">
					<i class="align-middle" data-feather="sliders"></i>
					<span class="align-middle">Dashboard</span>
				</a>
			</li>

			<li class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ route('profile.edit') }}">
					<i class="align-middle" data-feather="user"></i>
					<span class="align-middle">Profile</span>
				</a>
			</li>

			{{-- 🔹 ADMIN LINKS --}}
			@if(Auth::user()->role === 'admin')
				<li class="sidebar-header">Admin Panel</li>

				<li class="sidebar-item {{ request()->routeIs('admin.users.manage') ? 'active' : '' }}">
					<a class="sidebar-link" href="{{ route('admin.users.manage') }}">
						<i class="align-middle" data-feather="users"></i>
						<span class="align-middle">Manage Users</span>
					</a>
				</li>

				<li class="sidebar-item {{ request()->routeIs('admin.jobs.all') ? 'active' : '' }}">
					<a class="sidebar-link" href="{{ route('admin.jobs.all') }}">
						<i class="align-middle" data-feather="list"></i>
						<span class="align-middle">All Job Listings</span>
					</a>
				</li>
			@endif

			{{-- 🔹 EMPLOYER LINKS --}}
			@if(Auth::user()->role === 'employer')
				<li class="sidebar-header">Employer Panel</li>

				<li class="sidebar-item {{ request()->routeIs('employer.profile.*') ? 'active' : '' }}">
					<a class="sidebar-link" href="{{ route('employer.profile.edit') }}">
						<i class="align-middle" data-feather="building"></i>
						<span class="align-middle">Company Profile</span>
					</a>
				</li>

				<li class="sidebar-item {{ request()->routeIs('employer.jobs.*') ? 'active' : '' }}">
					<a class="sidebar-link" href="{{ route('employer.jobs.index') }}">
						<i class="align-middle" data-feather="briefcase"></i>
						<span class="align-middle">My Job Posts</span>
					</a>
				</li>


				{{-- ⚠️ Create a route for applicants if not exists --}}
				<li class="sidebar-item {{ request()->routeIs('employer.applicants.*') ? 'active' : '' }}">
					<a class="sidebar-link" href="{{ route('employer.applicants.index') }}">
						<i class="align-middle" data-feather="users"></i>
						<span class="align-middle">View Applicants</span>
					</a>
				</li>
			@endif

			{{-- 🔹 EMPLOYEE LINKS --}}
			@if(Auth::user()->role === 'employee')
				<li class="sidebar-header">Employee Panel</li>

				{{-- Browse Jobs --}}
				<li class="sidebar-item {{ request()->routeIs('employee.jobs.*') ? 'active' : '' }}">
					<a class="sidebar-link" href="{{ route('employee.jobs.index') }}">
						<i class="align-middle" data-feather="search"></i>
						<span class="align-middle">Browse Jobs</span>
					</a>
				</li>
				@if(Auth::user()->role === 'employee')
					<li class="sidebar-item {{ request()->routeIs('employee.profile.*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ route('employee.profile.edit') }}">
							<i class="align-middle" data-feather="user"></i>
							<span class="align-middle">My Profile</span>
						</a>
					</li>
				@endif

			@endif


		</ul>
	</div>
</nav>

{{-- ✅ Feather Icons --}}
<script src="https://unpkg.com/feather-icons"></script>
<script>
	document.addEventListener("DOMContentLoaded", function () {
		feather.replace();
	});
</script>