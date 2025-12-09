<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Página Expirada | Instituto Tecnológico de Oaxaca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/errors/errors.css'])
</head>
<body class="error-page error-419">
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
        <div class="error-icon">
            <i class="fas fa-clock"></i>
        </div>

        <!-- Código de error -->
        <h1 class="error-code" data-code="419">419</h1>
        
        <!-- Título -->
        <h2 class="error-title">¡Página Expirada!</h2>
        
        <!-- Descripción -->
        <p class="error-description">
            Tu sesión ha expirado o el token de seguridad ya no es válido. 
            Esto suele ocurrir cuando pasas mucho tiempo sin actividad. 
            Por favor, recarga la página e intenta de nuevo.
        </p>

        <!-- Botones de acción -->
        <div class="error-actions">
            <a href="javascript:location.reload()" class="btn-error btn-primary-error">
                <i class="fas fa-redo"></i>
                Recargar Página
            </a>
            <a href="{{ url('/') }}" class="btn-error btn-secondary-error">
                <i class="fas fa-home"></i>
                Ir al Inicio
            </a>
        </div>

        <!-- Información adicional -->
        <div class="error-info">
            <p>Si el problema persiste, intenta <a href="{{ route('login') }}">iniciar sesión nuevamente</a></p>
        </div>
    </div>
</body>
</html>
