<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Easypay')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --success: #4ade80;
            --warning: #facc15;
            --danger: #f87171;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
            padding-top: 56px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Header Styles */
        .navbar {
            background-color: var(--primary);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 600;
            color: white !important;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - 56px);
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar .nav-link {
            color: var(--dark);
            padding: 1rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--primary);
            color: white;
        }

        /* Sidebar Account Section */
        .sidebar-account {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .account-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            color: var(--dark);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .account-dropdown .dropdown-toggle:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        .account-dropdown .dropdown-toggle i {
            margin-right: 12px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .account-dropdown .dropdown-menu {
            position: static !important;
            transform: none !important;
            margin: 0.5rem;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .account-dropdown .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin: 0.25rem 0;
        }

        .account-dropdown .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        /* Main Wrapper */
        .main-wrapper {
            display: flex;
            height: calc(100vh - 56px);
        }

        /* Sidebar Wrapper */
        .sidebar-wrapper {
            width: var(--sidebar-width);
            flex-shrink: 0;
        }

        /* Content Wrapper */
        .content-wrapper {
            flex: 1;
            overflow-y: auto;
        }

        /* Main Content */
        .main-content {
            padding: 1rem;
            width: 100%;
            flex: 1;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Buttons */
        .btn {
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        /* Stats Cards */
        .stat-card {
            background-color: var(--primary);
            color: white;
        }

        .stat-card .card-title {
            color: rgba(255, 255, 255, 0.8);
        }

        .stat-card .display-4 {
            font-weight: 700;
        }

        /* Background Utility Classes */
        .bg-light-primary {
            background-color: rgba(67, 97, 238, 0.1) !important;
            color: var(--primary);
        }

        .bg-light-success {
            background-color: rgba(74, 222, 128, 0.1) !important;
            color: var(--success);
        }

        .bg-light-info {
            background-color: rgba(76, 201, 240, 0.1) !important;
            color: var(--accent);
        }

        .bg-light-warning {
            background-color: rgba(250, 204, 21, 0.1) !important;
            color: var(--warning);
        }

        .bg-light-danger {
            background-color: rgba(248, 113, 113, 0.1) !important;
            color: var(--danger);
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border-top: none;
            font-weight: 600;
            color: var(--dark);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        /* Forms */
        .form-control, .form-select {
            padding: 0.6rem 0.9rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 0.75rem 1rem;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            transition: margin 0.3s ease;
            padding: 0.75rem 0;
        }

        .footer .container-fluid {
            padding: 0 1rem;
        }

        /* Sidebar for Mobile */
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        /* Responsive Design */
        @media (max-width: 991.98px) {
            .main-wrapper {
                flex-direction: column;
            }

            .sidebar-wrapper {
                width: 100%;
                height: auto;
            }

            .sidebar {
                transform: translateX(-100%);
                height: calc(100vh - 56px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 1.5rem;
            }

            .footer {
                margin-left: 0;
                width: 100%;
            }

            .welcome-banner h1 {
                font-size: 1.75rem;
            }

            .stat-card .display-4 {
                font-size: 2rem;
            }

            .footer .container-fluid {
                padding: 0 1.5rem;
            }
        }

        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(0) !important;
            }
        }

        @media (max-width: 767.98px) {
            .main-content {
                padding: 1rem;
            }

            .card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1.25rem;
            }

            .table-responsive {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 575.98px) {
            body {
                padding-top: 56px;
            }

            .sidebar {
                top: 56px;
                height: calc(100vh - 56px);
            }

            .main-content {
                padding: 0.75rem;
            }

            .card {
                margin-bottom: 0.75rem;
            }

            .card-header {
                padding: 0.875rem 1rem;
            }

            .card-body {
                padding: 1rem;
            }
        }

        /* Override Bootstrap's fixed width for col-lg-10 */
        @media (min-width: 992px) {
            .col-lg-10 {
                flex: 1 1 auto;
                width: auto;
                max-width: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    @include('layouts.header')

    <div class="container-fluid flex-grow-1 p-0">
        <div class="main-wrapper">
            <!-- Single Sidebar for both desktop and mobile -->
            <div class="sidebar-wrapper">
                <div class="sidebar" id="mainSidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('setup') ? 'active' : '' }}" href="{{ route('setup') }}">
                                <i class="bi bi-gear"></i> Setup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('orders') ? 'active' : '' }}" href="{{ route('orders') }}">
                                <i class="bi bi-bag"></i> Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('gateways') ? 'active' : '' }}" href="{{ route('gateways') }}">
                                <i class="bi bi-credit-card"></i> Gateways
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}" href="{{ route('settings') }}">
                                <i class="bi bi-sliders"></i> Settings
                            </a>
                        </li>
                    </ul>

                    <!-- Account Menu at Bottom -->
                    <div class="sidebar-account">
                        <div class="account-dropdown dropdown">
                            <button class="dropdown-toggle" type="button" id="sidebarAccountDropdown" data-bs-toggle="dropdown">
                                <i class="bi bi-person"></i> {{ Auth::user()->name ?? 'User' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="content-wrapper">
                <div class="main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle using Bootstrap navbar toggler
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.querySelector('.navbar-toggler');
            const sidebar = document.getElementById('mainSidebar');

            if (navbarToggler && sidebar) {
                navbarToggler.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });

                // Close sidebar when clicking on a navigation link
                const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        setTimeout(function() {
                            sidebar.classList.remove('show');
                        }, 150);
                    });
                });

                // Close sidebar when clicking on account dropdown items
                const accountDropdownItems = document.querySelectorAll('.account-dropdown .dropdown-item');
                accountDropdownItems.forEach(item => {
                    // For links (Settings)
                    if (item.tagName === 'A') {
                        item.addEventListener('click', function() {
                            setTimeout(function() {
                                sidebar.classList.remove('show');
                            }, 150);
                        });
                    }
                    // For buttons (Logout)
                    else if (item.tagName === 'BUTTON') {
                        item.addEventListener('click', function() {
                            setTimeout(function() {
                                sidebar.classList.remove('show');
                            }, 150);
                        });
                    }
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
