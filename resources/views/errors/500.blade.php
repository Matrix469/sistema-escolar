<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Error del Servidor | Instituto Tecnológico de Oaxaca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/errors/errors.css'])
</head>
<body class="error-page error-500">
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
            <i class="fas fa-server"></i>
        </div>

        <!-- Código de error -->
        <h1 class="error-code" data-code="500">500</h1>
        
        <!-- Título -->
        <h2 class="error-title">¡Error del Servidor!</h2>
        
        <!-- Descripción -->
        <p class="error-description">
            Algo salió mal en nuestros servidores. Nuestro equipo técnico ha sido notificado 
            y estamos trabajando para solucionarlo. Por favor, intenta de nuevo más tarde.
        </p>

        <!-- Botones de acción -->
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn-error btn-primary-error">
                <i class="fas fa-home"></i>
                Ir al Inicio
            </a>
            <a href="javascript:location.reload()" class="btn-error btn-secondary-error">
                <i class="fas fa-redo"></i>
                Reintentar
            </a>
        </div>

        <!-- Información adicional -->
        <div class="error-info">
            <p>Si el problema persiste, <a href="mailto:soporte@oaxaca.tecnm.mx">contáctanos</a></p>
        </div>
    </div>
</body>
</html>
