<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
			<span class="align-middle">AdminKit</span>
		</a>

		<ul class="sidebar-nav">
			<li class="sidebar-header">Admin Panel</li>

			{{-- Dashboard --}}
			<li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ route('admin.dashboard') }}">
					<i class="align-middle" data-feather="sliders"></i>
					<span class="align-middle">Dashboard</span>
				</a>
			</li>

			{{-- Profile --}}
			<li class="sidebar-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ route('profile.edit') }}">
					<i class="align-middle" data-feather="user"></i>
					<span class="align-middle">Profile</span>
				</a>
			</li>

			<li class="sidebar-item {{ request()->routeIs('admin.users.manage') ? 'active' : '' }}">
    <a class="sidebar-link" href="{{ route('admin.users.manage') }}">
        <i class="align-middle" data-feather="users"></i>
        <span class="align-middle">Manage Users</span>
    </a>
</li>

			{{-- All Job Listings --}}
			<li class="sidebar-item {{ request()->routeIs('admin.jobs.all') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ route('admin.jobs.all') }}">
					<i class="align-middle" data-feather="list"></i>
					<span class="align-middle">All Job Listings</span>
				</a>
			</li>
		</ul>
	</div>
</nav>

{{-- ✅ Feather Icons Script --}}
<script src="https://unpkg.com/feather-icons"></script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		feather.replace();
	});
</script>
