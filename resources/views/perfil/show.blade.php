@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    .perfil-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    .back-link {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        color: black;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
        padding: 0.5rem 1rem;
        background: #FFEEE2;
        border-radius: 10px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .back-link:hover {
        color: #4f46e5;
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .back-link svg {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }
    
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #0e0e0eff 0%, #434343ff 50%, #1d1d1dff 100%);
        border-radius: 24px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 8px 8px 16px rgba(200, 200, 200, 0.4), -8px -8px 16px rgba(255, 255, 255, 0.9);
    }

    .hero-content {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .hero-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.3);
    }

    .hero-info h1 {
        color: #ffffff;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }

    .hero-info .role-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-estudiante {
        background: rgba(191, 219, 254, 0.9);
        color: #1e40af;
    }

    .role-jurado {
        background: rgba(254, 240, 138, 0.9);
        color: #854d0e;
    }

    .role-admin {
        background: rgba(254, 202, 202, 0.9);
        color: #991b1b;
    }

    .hero-info .email {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    /* Info Card */
    .info-card {
        background: #FFEEE2;
        border-radius: 20px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .info-card h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card h3 svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #e89a3c;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .info-item {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 12px;
        padding: 1rem;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }

    .info-item label {
        font-size: 0.75rem;
        color: #6b6b6b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 0.25rem;
    }

    .info-item span {
        font-size: 1rem;
        color: #2c2c2c;
        font-weight: 600;
    }

    /* Equipo Card */
    .equipo-card {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
    }

    .equipo-card:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }

    .equipo-card h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .equipo-card .evento-name {
        font-size: 0.75rem;
        color: #e89a3c;
        margin-bottom: 0.5rem;
    }

    .equipo-card .rol-badge {
        display: inline-block;
        padding: 0.125rem 0.5rem;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 500;
        background: rgba(232, 154, 60, 0.2);
        color: #e89a3c;
    }

    .equipo-card .lider-badge {
        background: linear-gradient(135deg, #e89a3c, #f5a847);
        color: white;
    }

    /* Evento Card */
    .evento-card {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
    }

    .evento-card:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }

    .evento-card h4 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .evento-card .fecha {
        font-size: 0.75rem;
        color: #6b6b6b;
    }

    .status-badge {
        display: inline-block;
        padding: 0.125rem 0.5rem;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 500;
    }

    .status-activo {
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
    }

    .status-en-progreso {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
    }

    .status-finalizado {
        background: rgba(229, 231, 235, 0.8);
        color: #374151;
    }

    .status-proximo {
        background: rgba(191, 219, 254, 0.8);
        color: #1e40af;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6b6b6b;
    }

    .empty-state svg {
        width: 3rem;
        height: 3rem;
        margin: 0 auto 1rem;
        color: #d1d5db;
    }
</style>

<div class="perfil-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="javascript:history.back()" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Regresar
        </a>
        
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-avatar">
                    {{ strtoupper(substr($user->nombre, 0, 1)) }}{{ strtoupper(substr($user->app_paterno, 0, 1)) }}
                </div>
                <div class="hero-info">
                    <h1>{{ $user->nombre }} {{ $user->app_paterno }} {{ $user->app_materno }}</h1>
                    <span class="role-badge role-{{ $user->rolSistema->nombre }}">
                        {{ ucfirst($user->rolSistema->nombre) }}
                    </span>
                    <p class="email">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        @if($estudiante)
        <!-- Información del Estudiante -->
        <div class="info-card">
            <h3>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Información Académica
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Número de Control</label>
                    <span>{{ $estudiante->numero_control }}</span>
                </div>
                <div class="info-item">
                    <label>Carrera</label>
                    <span>{{ $estudiante->carrera->nombre ?? 'Sin asignar' }}</span>
                </div>
                <div class="info-item">
                    <label>Semestre</label>
                    <span>{{ $estudiante->semestre }}° Semestre</span>
                </div>
            </div>
        </div>

        <!-- Equipos -->
        <div class="info-card">
            <h3>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Equipos ({{ $equipos->count() }})
            </h3>
            @if($equipos->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($equipos as $info)
                        <div class="equipo-card">
                            <h4>{{ $info['equipo']->nombre }}</h4>
                            <p class="evento-name">{{ $info['evento']->nombre }}</p>
                            <div class="flex gap-2">
                                <span class="rol-badge {{ $info['es_lider'] ? 'lider-badge' : '' }}">
                                    {{ $info['es_lider'] ? '👑 Líder' : $info['rol']->nombre ?? 'Miembro' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p>No pertenece a ningún equipo aún</p>
                </div>
            @endif
        </div>

        <!-- Eventos -->
        <div class="info-card">
            <h3>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Eventos ({{ $eventos->count() }})
            </h3>
            @if($eventos->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($eventos as $evento)
                        <div class="evento-card">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4>{{ $evento->nombre }}</h4>
                                    <p class="fecha">{{ $evento->fecha_inicio->format('d M, Y') }} - {{ $evento->fecha_fin->format('d M, Y') }}</p>
                                </div>
                                <span class="status-badge 
                                    @if($evento->estado == 'Activo') status-activo
                                    @elseif($evento->estado == 'En Progreso') status-en-progreso
                                    @elseif($evento->estado == 'Finalizado') status-finalizado
                                    @else status-proximo @endif">
                                    {{ $evento->estado }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p>No ha participado en eventos aún</p>
                </div>
            @endif
        </div>
        @else
        <!-- Información para no-estudiantes -->
        <div class="info-card">
            <h3>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Información del Usuario
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nombre Completo</label>
                    <span>{{ $user->nombre }} {{ $user->app_paterno }} {{ $user->app_materno }}</span>
                </div>
                <div class="info-item">
                    <label>Email</label>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <label>Rol</label>
                    <span>{{ ucfirst($user->rolSistema->nombre) }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
