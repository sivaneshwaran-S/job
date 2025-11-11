<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title', 'Admin Dashboard')</title>

	<link rel="shortcut icon" href="{{ asset('admin/img/icons/icon-48x48.png') }}" />
	<link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
	<div class="wrapper">
		{{-- Sidebar --}}
		@include('admin.layouts.sidebar')

		<div class="main">
			{{-- Navbar --}}
			@include('admin.layouts.navbar')

			<main class="content">
				@yield('content')
			</main>

			{{-- Footer --}}
			@include('admin.layouts.footer')
		</div>
	</div>

	<script src="{{ asset('adminkit/js/app.js') }}"></script>
	@yield('scripts')
</body>
</html>
