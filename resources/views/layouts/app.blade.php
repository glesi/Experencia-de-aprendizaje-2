<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sistema de Finanzas') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
    @auth
        <div class="wrapper">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="logo-details">
                    <span class="logo_name">{{ config('app.name', 'Sistema de Finanzas') }}</span>
                </div>
                <nav class="nav flex-column mt-4">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class='bx bxs-dashboard'></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('incomes.create') }}" class="nav-link {{ request()->routeIs('incomes.create') ? 'active' : '' }}">
                        <i class='bx bx-plus-circle'></i>
                        <span>Registrar Entrada</span>
                    </a>
                    <a href="{{ route('expenses.create') }}" class="nav-link {{ request()->routeIs('expenses.create') ? 'active' : '' }}">
                        <i class='bx bx-minus-circle'></i>
                        <span>Registrar Salida</span>
                    </a>
                    <a href="{{ route('incomes.index') }}" class="nav-link {{ request()->routeIs('incomes.index') ? 'active' : '' }}">
                        <i class='bx bx-money'></i>
                        <span>Ver Entradas</span>
                    </a>
                    <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                        <i class='bx bx-receipt'></i>
                        <span>Ver Salidas</span>
                    </a>
                    <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                        <i class='bx bx-line-chart'></i>
                        <span>Balance</span>
                    </a>
                </nav>
            </div>

            <div class="main-wrapper">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="dropdown ms-auto">
                            <button class="btn" type="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </button>
                        </div>
                        <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                                <button type="submit" class="dropdown-item">
                                    <span class="material-symbols-outlined">logout</span>
                                </button>
                        </form>
                        </div>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="main-content">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <main>
            @yield('content')
        </main>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>