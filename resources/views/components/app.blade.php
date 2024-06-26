<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://unpkg.com/bootstrap-datepicker@1.8.0/dist/css/bootstrap-datepicker.standalone.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://unpkg.com/js-year-calendar@latest/dist/js-year-calendar.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <title>Prueba</title>
</head>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        @auth

            <div class="dropdown show">
                <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                    {{ auth()->user()->username }}
                </a>

                <ul class="dropdown-menu mr-4 mt-2" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Cerrar sesión</a></li>
                </ul>
            </div>
        @endauth

    </header>
    <hr class="hr">

    @if (session('alert'))
        <div class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3"
            role="alert" style="opacity: 0.9; z-index: 1050;">
            {{ session('alert')['message'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 3000);
        </script>
    @endif







    <div class="l-navbar hide-elements" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="{{ route('inicio') }}" class="nav_logo">
                    <i class='bx bx-layer nav_logo-icon'></i>
                    <span class="nav_logo-name">PRUEBA TÉCNICA</span>
                </a>
                <li>
                    <hr class="dropdown-divider custom-divider">
                </li>
                <span class="nav_name styled-text">SOLUCIONES INFORMÁTICAS MJ</span>
                <li>
                    <hr class="dropdown-divider custom-divider">
                </li>

                <div class="nav_list">
                    @php
                        $currentRoute = request()->path();
                        $containsUsuarios = Str::contains($currentRoute, 'usuarios');
                        $containsDiasFestivos = Str::contains($currentRoute, 'diasfestivos');
                    @endphp
                    <a href="{{ route('inicio') }}" class="nav_link {{ $currentRoute == '/' ? 'active' : '' }}">
                        <i class='bx bx-home nav_icon'></i>
                        <span class="nav_name">Inicio</span>
                    </a>
                    <a href="{{ route('diasfestivos') }}" class="nav_link {{ $containsDiasFestivos ? 'active' : '' }}">
                        <i class='bx bx-calendar nav_icon'></i>
                        <span class="nav_name">Días Festivos</span>
                    </a>
                    <a href="{{ route('usuarios') }}" class="nav_link {{ $containsUsuarios ? 'active' : '' }}">
                        <i class='bx bx-group nav_icon'></i>
                        <span class="nav_name">Usuarios</span>
                    </a>
                </div>
        </nav>
    </div>
    <div class="container">
        {{ $slot }}
    </div>

    <footer class="footer pt-3 bg-light fixed-bottom z-0 shadow-lg" id="footer">
        <div class="container text-center">
            <p>&copy; 2024 <strong>Soluciones Informáticas MJ, S.C.A</strong></p>
        </div>
    </footer>

    <!-- Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/js-year-calendar@latest/dist/js-year-calendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
</body>

</html>
