@extends('layouts.app')

@section('title', 'Generar Token de Jurado')

@push('styles')
<link rel="stylesheet" href="{{ Vite::asset('resources/css/admin/jurado-tokens/create.css') }}">
@endpush

@section('content')
<div class="token-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <a href="{{ route('admin.jurado-tokens.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Volver a Tokens
        </a>

        <!-- Hero Header -->
        <div class="hero-header text-center">
            <div class="hero-icon"><i class="fas fa-key"></i></div>
            <h1 class="hero-title">Generador de <span>Tokens de Jurado</span></h1>
            <p class="hero-subtitle">Crea tokens de acceso seguro para que los jurados se registren en la plataforma</p>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="fas fa-check-circle"></i>
                <div class="alert-content">
                    <p class="alert-title">¡Token generado exitosamente!</p>
                    <p class="alert-text">{{ session('success') }}</p>
                    @if(session('token'))
                        <div class="token-display">
                            <span id="tokenValue">{{ session('token') }}</span>
                            <button class="btn-copy" onclick="copyToken()">
                                <i class="fas fa-copy"></i> Copiar
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-custom alert-error-custom">
                <i class="fas fa-exclamation-circle"></i>
                <div class="alert-content">
                    <p class="alert-title" style="color: #b91c1c;">Error en el formulario</p>
                    <p class="alert-text" style="color: #dc2626;">{{ $errors->first() }}</p>
                </div>
            </div>
        @endif

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Form Card -->
            <div class="modern-card">
                <div class="card-header-custom">
                    <i class="fas fa-plus-circle"></i>
                    <h3>Crear Nuevo Token</h3>
                </div>
                
                <form action="{{ route('admin.jurado-tokens.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nombre Completo -->
                    <div class="form-group">
                        <label class="form-label">Nombre(s) del Jurado *</label>
                        <input type="text" name="nombre_destinatario" class="form-input name-input"
                               placeholder="Juan"
                               value="{{ old('nombre_destinatario') }}" required>
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Solo se permiten letras y acentos
                        </div>
                        <div class="error-message" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>El nombre solo puede contener letras y acentos</span>
                        </div>
                    </div>

                    <!-- Apellido Paterno -->
                    <div class="form-group">
                        <label class="form-label">Apellido Paterno *</label>
                        <input type="text" name="apellido_paterno" class="form-input name-input"
                               placeholder="Pérez"
                               value="{{ old('apellido_paterno') }}" required>
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Solo se permiten letras y acentos
                        </div>
                        <div class="error-message" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>El apellido solo puede contener letras y acentos</span>
                        </div>
                    </div>

                    <!-- Apellido Materno -->
                    <div class="form-group">
                        <label class="form-label">Apellido Materno</label>
                        <input type="text" name="apellido_materno" class="form-input name-input"
                               placeholder="López"
                               value="{{ old('apellido_materno') }}">
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Solo se permiten letras y acentos (opcional)
                        </div>
                        <div class="error-message" style="display: none;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>El apellido solo puede contener letras y acentos</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email del Jurado Invitado</label>
                        <input type="email" name="email" class="form-input"
                               placeholder="jurado@ejemplo.com"
                               value="{{ old('email') }}" required>
                        <div class="form-help">
                            <i class="fas fa-info-circle"></i>
                            Se enviará una invitación a este correo electrónico
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Días de Vigencia</label>
                        <input type="number" name="dias_vigencia" class="form-input" 
                               value="{{ old('dias_vigencia', 15) }}" 
                               min="1" max="90" required>
                        <div class="form-help">
                            <i class="fas fa-clock"></i>
                            El token será válido por este número de días (máx. 90)
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Generar y Enviar Token
                    </button>
                </form>
            </div>

            <!-- Info Card -->
            <div class="modern-card info-card">
                <div class="card-header-custom">
                    <i class="fas fa-lightbulb"></i>
                    <h3>¿Cómo funciona?</h3>
                </div>

                <ul class="step-list">
                    <li class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h5>Ingresa el email</h5>
                            <p>Escribe el correo electrónico del jurado que deseas invitar</p>
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h5>Define la vigencia</h5>
                            <p>Establece cuántos días será válido el token de acceso</p>
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h5>Genera el token</h5>
                            <p>Se creará un código único y se enviará automáticamente al jurado</p>
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h5>Registro del jurado</h5>
                            <p>El jurado usará el token para completar su registro en la plataforma</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Table Section -->
        <div class="modern-card table-container">
            <div class="table-header">
                <h3><i class="fas fa-list"></i> Tokens Recientes</h3>
                <a href="{{ route('admin.jurado-tokens.index') }}" class="btn-view-all">
                    Ver todos <i class="fas fa-arrow-right" style="margin-left: 0.25rem;"></i>
                </a>
            </div>

            <table class="tokens-table">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Expiración</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tokens->take(5) as $token)
                        <tr>
                            <td><code class="token-code">{{ $token->token }}</code></td>
                            <td>{{
                                trim(($token->nombre_destinatario ?? '') . ' ' .
                                     ($token->apellido_paterno ?? '') . ' ' .
                                     ($token->apellido_materno ?? '')) ?: 'Sin nombre'
                            }}</td>
                            <td>{{ $token->email_invitado ?? 'N/A' }}</td>
                            <td>
                                @if($token->usado)
                                    <span class="status-badge status-used">Usado</span>
                                @elseif($token->fecha_expiracion < now())
                                    <span class="status-badge status-expired">Expirado</span>
                                @else
                                    <span class="status-badge status-active">Activo</span>
                                @endif
                            </td>
                            <td>{{ $token->fecha_expiracion->format('d/m/Y') }}</td>
                            <td>
                                <button class="btn-action" onclick="navigator.clipboard.writeText('{{ $token->token }}')" title="Copiar token">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>No hay tokens generados todavía</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function copyToken() {
        const tokenValue = document.getElementById('tokenValue').textContent;
        navigator.clipboard.writeText(tokenValue).then(() => {
            const btn = document.querySelector('.btn-copy');
            btn.innerHTML = '<i class="fas fa-check"></i> Copiado';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-copy"></i> Copiar';
            }, 2000);
        });
    }

    // Validación en tiempo real para campos de nombre
    document.addEventListener('DOMContentLoaded', function() {
        const nameInputs = document.querySelectorAll('.name-input');

        // Expresión regular que solo permite letras, espacios y acentos
        const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;

        nameInputs.forEach(input => {
            input.addEventListener('input', function() {
                const value = this.value;
                const errorMessage = this.parentElement.querySelector('.error-message');

                if (value && !nameRegex.test(value)) {
                    // Hay caracteres no válidos
                    this.classList.add('error');

                    // Remover caracteres no válidos
                    const cleanValue = value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
                    this.value = cleanValue;

                    // Mostrar mensaje de error
                    errorMessage.style.display = 'flex';

                    // Temporizador para ocultar el error después de 3 segundos
                    clearTimeout(this.errorTimeout);
                    this.errorTimeout = setTimeout(() => {
                        this.classList.remove('error');
                        errorMessage.style.display = 'none';
                    }, 3000);
                } else {
                    // Todo está bien
                    this.classList.remove('error');
                    errorMessage.style.display = 'none';
                    clearTimeout(this.errorTimeout);
                }
            });

            // También validar al perder el foco
            input.addEventListener('blur', function() {
                const value = this.value;
                const errorMessage = this.parentElement.querySelector('.error-message');

                if (value && !nameRegex.test(value)) {
                    this.classList.add('error');
                    errorMessage.style.display = 'flex';
                } else {
                    this.classList.remove('error');
                    errorMessage.style.display = 'none';
                }
            });

            // Ocultar error al empezar a escribir de nuevo
            input.addEventListener('focus', function() {
                if (this.classList.contains('error')) {
                    setTimeout(() => {
                        this.classList.remove('error');
                        this.parentElement.querySelector('.error-message').style.display = 'none';
                    }, 100);
                }
            });
        });
    });
</script>
@endsection
