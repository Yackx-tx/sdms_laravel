<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            margin: 0;
            padding: 0;

        }

        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            width: 250px;
            z-index: 1;
            transition: transform 0.3s ease;
            /* overflow-y: auto; */
        }

        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin 0.3s ease;
        }

        .nav-link {
            color: #fff !important;
            padding: 0.8rem 1rem !important;
            display: flex !important;
            align-items: center !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: #283593;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .top-navbar {
            margin-left: 250px;
            position: fixed;
            transition: margin 0.3s ease;
            z-index: 1;
            flex: 0 0 auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content,
            .top-navbar {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>

</head>

<body>
    <div id="app">

        @auth
        <div class="sidebar" style="background-color: #1a237e;">
            <div class="px-3 py-4" style="background-color: #0d1557;">
                <h4 class="text-white mb-0">ETS-SDMS</h4>
            </div>
            <nav class="mt-3">
                <div class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('sections*') ? 'active' : '' }}" href="{{ route('sections.index') }}">
                            <i class="fas fa-chalkboard"></i>Manage Sections
                        </a>
                    </li>
                    <a href="{{ route('students.index') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Manage Students</span>
                    </a>

                    <a href="{{ route('courses.index') }}" class="nav-link">
                        <i class="fas fa-book"></i>
                        <span>Manage Courses</span>
                    </a>
                    <a href="{{ route('attendance.index') }}" class="nav-link">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Attendance Records</span>
                    </a>
                    <a href="{{ route('grades.index') }}" class="nav-link">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Grade Management</span>
                    </a>
                    <a href="{{ route('reports.index') }}" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Report Management</span>
                    </a>

                </div>
            </nav>
        </div>
        @endauth

        <main class="@auth main-content @endauth" style="margin-top: 0; ">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>

</html>
