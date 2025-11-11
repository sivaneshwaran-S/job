<nav id="sidebar" class="sidebar js-sidebar">
	<div class="sidebar-content js-simplebar">
		<a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
			<span class="align-middle">AdminKit</span>
		</a>

		<ul class="sidebar-nav">
			<li class="sidebar-header">Pages</li>

			<li class="sidebar-item active">
				<a class="sidebar-link" href="{{ route('admin.dashboard') }}">
					<i class="align-middle" data-feather="sliders"></i> 
					<span class="align-middle">Dashboard</span>
				</a>
			</li>

			<li class="sidebar-item">
				<a class="sidebar-link" href="#">
					<i class="align-middle" data-feather="user"></i> 
					<span class="align-middle">Profile</span>
				</a>
			</li>
		</ul>
	</div>
</nav>
