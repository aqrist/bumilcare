<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Klinik Kehamilan') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Global Styles */
        :root {
            --primary: #ff6b9f;
            --primary-dark: #d84a7b;
            --secondary: #4a90c8;
            --dark: #333333;
            --light: #f8f9fa;
            --light-gray: #e9ecef;
            --gray: #6c757d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
            min-height: 100vh;
        }

        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            color: var(--primary) !important;
            font-weight: 700;
        }

        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary) !important;
        }

        .sidebar {
            background-color: white !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            min-height: calc(100vh - 56px);
        }

        .sidebar .nav-link {
            padding: 12px 20px;
            margin-bottom: 5px;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: var(--light);
            color: var(--primary) !important;
        }

        .sidebar .nav-link.active {
            background-color: var(--primary);
            color: white !important;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn {
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        .form-control {
            padding: 12px;
            border: 1px solid var(--light-gray);
            border-radius: 6px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 159, 0.25);
        }

        .dropdown-item:active {
            background-color: var(--primary);
        }

        .page-link {
            color: var(--primary);
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        main {
            padding: 30px 20px;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <i class="bi bi-heart-pulse-fill text-danger"></i>
                    {{ config('app.name', 'Klinik Kehamilan') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @auth
            <div class="container-fluid">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                        <div class="position-sticky pt-3">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
                                        href="{{ route('dashboard') }}">
                                        <i class="bi bi-house-door"></i> Dashboard
                                    </a>
                                </li>

                                @if (auth()->user()->hasAnyRole(['admin', 'doctor', 'nurse']))
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('patients*') ? 'active' : '' }}"
                                            href="{{ route('patients.index') }}">
                                            <i class="bi bi-people"></i> Pasien
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->user()->hasAnyRole(['admin', 'doctor', 'nurse']))
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('queues*') && !Request::is('queues/display') ? 'active' : '' }}"
                                            href="{{ route('queues.index') }}">
                                            <i class="bi bi-list-ol"></i> Antrian
                                        </a>
                                    </li>
                                @endif

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('queues.display') }}" target="_blank">
                                        <i class="bi bi-display"></i> Display Antrian
                                    </a>
                                </li>

                                @if (auth()->user()->hasRole('pharmacist'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('pharmacy') ? 'active' : '' }}"
                                            href="{{ route('prescriptions.pharmacy') }}">
                                            <i class="bi bi-capsule"></i> Farmasi
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('medicines*') ? 'active' : '' }}"
                                            href="{{ route('medicines.index') }}">
                                            <i class="bi bi-boxes"></i> Stok Obat
                                        </a>
                                    </li>
                                @endif

                                @if (auth()->user()->hasRole('cashier'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ Request::is('payments*') ? 'active' : '' }}"
                                            href="{{ route('payments.index') }}">
                                            <i class="bi bi-cash-coin"></i> Pembayaran
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Main content -->
                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                        @yield('content')
                    </main>
                </div>
            </div>
        @else
            <main class="py-4">
                @yield('content')
            </main>
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
</body>

</html>
