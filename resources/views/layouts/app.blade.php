<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: radial-gradient(circle at 10% -20%, #273f7f 0, transparent 30%), #080d1f;
            color: #e8efff;
        }

        .glass {
            background: linear-gradient(160deg, #101b36 0%, #0b1430 100%);
            border: 1px solid #243d68;
            border-radius: 14px;
        }

        .table-glass {
            --bs-table-bg: #111f3c;
            --bs-table-striped-bg: #122347;
            --bs-table-hover-bg: #132a52;
            --bs-table-color: #e4ecff;
            --bs-table-border-color: #27416e;
            border-radius: 12px;
            overflow: hidden;
        }

        .text-muted-x {
            color: #9aacd8;
        }

        .form-control,
        .form-select {
            background-color: #0b1632;
            border-color: #2c4674;
            color: #e4ecff;
        }

        .form-control::placeholder {
            color: #8ea3d4;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #0b1632;
            border-color: #4d6aff;
            color: #e4ecff;
            box-shadow: 0 0 0 .2rem rgba(124, 108, 255, .2);
        }

        .navbar {
            border: 1px solid #243d68;
            border-radius: 14px;
            background: linear-gradient(160deg, #101b36 0%, #0b1430 100%);
        }

        .nav-link {
            color: #b7c7ef;
        }

        .nav-link.active,
        .nav-link:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container py-3 py-md-4">
        <nav class="navbar navbar-expand-lg px-3 px-md-4 mb-3 mb-md-4">
            <a class="navbar-brand fw-bold text-light" href="{{ route('dashboard') }}">DashX Admin</a>
            <button class="navbar-toggler border-0 text-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}">
                            <i class="bi bi-window me-1"></i> Portfolio
                        </a>
                    </li>

                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-sliders me-1"></i> Dashboard
                            </a>
                        </li>

                        @if (auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="bi bi-people me-1"></i> Users CRUD
                                </a>
                            </li>
                        @endif

                        <li class="nav-item d-flex align-items-center text-light-emphasis px-2 small">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->email }}
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('access.request.form') ? 'active' : '' }}" href="{{ route('access.request.form') }}">
                                <i class="bi bi-envelope me-1"></i> Request Access
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
