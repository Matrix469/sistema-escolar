<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acceso Denegado | Instituto Tecnológico de Oaxaca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/errors/errors.css'])
</head>
<body class="error-page error-403">
    <!-- Partículas de fondo -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Decoraciones -->
    <div class="decoration decoration-1"></div>
    <div class="decoration decoration-2"></div>

    <!-- Contenedor principal -->
    <div class="error-container">
        <!-- Logo -->
        <div class="error-logo">
            <img src="{{ asset('images/logito.png') }}" alt="Logo ITO">
        </div>

        <!-- Icono -->
        <div class="error-icon shake">
            <i class="fas fa-ban"></i>
        </div>

        <!-- Código de error -->
        <h1 class="error-code" data-code="403">403</h1>
        
        <!-- Título -->
        <h2 class="error-title">¡Acceso Denegado!</h2>
        
        <!-- Descripción -->
        <p class="error-description">
            No tienes los permisos necesarios para acceder a esta página. 
            Si crees que esto es un error, por favor contacta al administrador del sistema.
        </p>

        <!-- Botones de acción -->
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn-error btn-primary-error">
                <i class="fas fa-home"></i>
                Ir al Inicio
            </a>
            @auth
                <a href="{{ route('login') }}" class="btn-error btn-secondary-error" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-error btn-secondary-error">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </a>
            @endauth
        </div>

        <!-- Información adicional -->
        <div class="error-info">
            <p>¿Necesitas acceso? <a href="mailto:soporte@oaxaca.tecnm.mx">Solicítalo aquí</a></p>
        </div>
    </div>
</body>
</html>
