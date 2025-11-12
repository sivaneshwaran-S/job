<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Employer Dashboard')</title>

    {{-- Bootstrap & Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 230px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #ffffff;
            border-right: 1px solid #e6e6e6;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
        }
        .sidebar h5 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 8px;
            transition: all 0.2s;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #e7f1ff;
            color: #0d6efd;
        }

        /* Highlighted Post Button */
        .sidebar a.post-btn {
            background-color: #0d6efd;
            color: #fff;
            justify-content: center;
            font-weight: 600;
            transition: background 0.3s;
            margin-top: 10px;
        }
        .sidebar a.post-btn:hover {
            background-color: #0b5ed7;
        }

        /* Main Area */
        .main-content {
            margin-left: 230px;
            min-height: 100vh;
            background: #f8fafc;
        }

        /* Topbar */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e6e6e6;
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #555;
            font-weight: 500;
        }

        /* Content Wrapper */
        .content-wrapper {
            padding: 25px;
        }

        /* Buttons */
        .btn-outline-danger {
            border-color: #dc3545;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <h5>Employer Panel</h5>

        <a href="{{ route('employer.dashboard') }}" 
           class="{{ request()->routeIs('employer.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>

        <a href="{{ route('employer.jobs.index') }}" 
           class="{{ request()->routeIs('employer.jobs.*') ? 'active' : '' }}">
            <i class="fas fa-briefcase"></i> My Jobs
        </a>

        <a href="{{ route('employer.jobs.create') }}" class="post-btn">
            <i class="fas fa-plus-circle"></i> Post Job
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto">
            @csrf
            <button class="btn btn-sm btn-outline-danger w-100">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Top Navbar --}}
        <div class="topbar">
            <h5 class="mb-0 fw-semibold text-dark">@yield('page-title', 'Dashboard')</h5>
            <div class="user-info">
                <i class="fas fa-user-circle fa-lg text-primary"></i>
                <span>{{ Auth::user()->name ?? 'Employer' }}</span>
            </div>
        </div>

        {{-- Page Content --}}
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
