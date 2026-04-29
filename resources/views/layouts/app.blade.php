<!DOCTYPE html>
<html>
<head>
    <title>Mi Sistema Bancario</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- 🔥 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        
        <h2 class="navbar-brand">Banco</h2>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- 🔥 MENÚ DINÁMICO -->
            <ul class="navbar-nav me-auto">

                @auth

                    @if(auth()->user()->tienePermiso('ver_clientes'))
                        <li class="nav-item">
                            <a class="nav-link" href="/clientes">Clientes</a>
                        </li>
                    @endif

                    @if(auth()->user()->tienePermiso('ver_cuentas'))
                        <li class="nav-item">
                            <a class="nav-link" href="/cuentas">Cuentas</a>
                        </li>
                    @endif

                    @if(auth()->user()->tienePermiso('ver_empleados'))
                        <li class="nav-item">
                            <a class="nav-link" href="/empleados">Empleados</a>
                        </li>
                    @endif

                    @if(auth()->user()->tienePermiso('ver_sucursales'))
                        <li class="nav-item">
                            <a class="nav-link" href="/sucursales">Sucursales</a>
                        </li>
                    @endif

                    @if(auth()->user()->tienePermiso('ver_usuarios'))
                        <li class="nav-item">
                            <a class="nav-link" href="/usuarios">Usuarios</a>
                        </li>
                    @endif

                @endauth

            </ul>
                <!-- 🔔 NOTIFICACIONES + USUARIO -->
<ul class="navbar-nav ms-auto">

    @auth

    <!-- 🔔 Notificaciones -->
    <li class="nav-item">
        <a href="{{ route('notificaciones.index') }}" class="nav-link position-relative">
            🔔

            @php
$noLeidas = auth()->user()->cliente->notificaciones()
    ->where('leida', false)
    ->count();
@endphp

            @if($noLeidas > 0)
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                    {{ $noLeidas }}
                </span>
            @endif
        </a>
    </li>

    <!-- 👤 Usuario -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
            {{ auth()->user()->name }}
        </a>

        <ul class="dropdown-menu dropdown-menu-end">

            <li>
                <span class="dropdown-item-text text-muted">
                    Rol: {{ auth()->user()->rol->nombre ?? 'Sin rol' }}
                </span>
            </li>

            <li><hr class="dropdown-divider"></li>

            <!-- 🔥 LOGOUT REAL -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        Cerrar sesión
                    </button>
                </form>
            </li>

        </ul>
    </li>

    @endauth

</ul>

            

        </div>

    </div>
</nav>

<!-- CONTENIDO -->
<div class="container mt-5">
    @yield('contenido')
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>