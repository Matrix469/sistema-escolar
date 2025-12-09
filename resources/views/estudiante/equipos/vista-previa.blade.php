@extends('layouts.app')

@section('content')

{{-- Mensajes de alerta con auto-dismiss --}}
@if(session('success'))
    <div class="alert-toast alert-success" id="alertSuccess">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; padding: 0; margin-left: 0.5rem;">
            <svg style="width: 18px; height: 18px; color: inherit; opacity: 0.7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert-toast alert-error" id="alertError">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; padding: 0; margin-left: 0.5rem;">
            <svg style="width: 18px; height: 18px; color: inherit; opacity: 0.7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

<style>
    .alert-toast {
        position: fixed;
        top: 80px;
        right: 20px;
        z-index: 9999;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 4px 4px 12px rgba(0,0,0,0.15);
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        max-width: 400px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation: slideInRight 0.5s ease, fadeOut 0.5s ease 4s forwards;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        color: #065f46;
    }
    
    .alert-error {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }
    
    @keyframes fadeOut {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(100px); pointer-events: none; }
    }
</style>

<script>
    // Auto-remove alerts after animation completes
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-toast');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert && alert.parentElement) {
                    alert.remove();
                }
            }, 4500);
        });
    });
</script>

<div class="vista-previa-container">
    {{-- Botón Volver arriba con estilo neumórfico --}}
    <a href="{{ url()->previous() }}" class="back-link-previa">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver
    </a>

    <div class="vista-previa-card">
        <!-- Header del Equipo -->
        <div class="vista-previa-header">
            <div class="equipo-info">
                <div class="equipo-logo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="equipo-titulo">
                    <h1>{{ $equipo->nombre }}</h1>
                    @if($inscripcionActiva->evento)
                        <div class="evento-nombre">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $inscripcionActiva->evento->nombre }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Body del Equipo -->
        <div class="vista-previa-body">
            <!-- Estado del Equipo -->
            <div class="badge-status {{ $inscripcionActiva->miembros->count() >= 5 ? 'completo' : 'disponible' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                    @if($inscripcionActiva->miembros->count() >= 5)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    @endif
                </svg>
                {{ $inscripcionActiva->miembros->count() >= 5 ? 'Equipo Completo' : (5 - $inscripcionActiva->miembros->count()) . ' espacios disponibles' }}
            </div>

            <!-- Descripción -->
            @if($equipo->descripcion)
                <div class="seccion-descripcion">
                    <div class="seccion-titulo">
                        <div class="seccion-titulo-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        Acerca del Equipo
                    </div>
                    <div class="descripcion-texto">
                        {{ $equipo->descripcion }}
                    </div>
                </div>
            @endif

            <!-- Miembros -->
            <div class="seccion-miembros">
                <div class="seccion-titulo">
                    <div class="seccion-titulo-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    Miembros del Equipo ({{ $inscripcionActiva->miembros->count() }}/5)
                </div>

                <div class="miembros-grid">
                    @foreach($inscripcionActiva->miembros as $miembro)
                        <div class="miembro-card {{ $miembro->es_lider ? 'is-lider' : '' }}">
                            {{-- Badge de Líder --}}
                            @if($miembro->es_lider)
                            <div class="lider-crown">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5z"/>
                                </svg>
                            </div>
                            @endif
                            
                            {{-- Header con avatar y nombre --}}
                            <div class="miembro-header">
                                <div class="miembro-avatar">
                                    @if($miembro->user->foto_perfil)
                                        <img src="{{ asset('storage/' . $miembro->user->foto_perfil) }}" alt="Avatar">
                                    @else
                                        {{ strtoupper(substr($miembro->user->nombre ?? 'M', 0, 1) . substr($miembro->user->app_paterno ?? '', 0, 1)) }}
                                    @endif
                                </div>
                                <div class="miembro-nombre-rol">
                                    <h4 class="miembro-nombre">{{ $miembro->user->nombre_completo ?? $miembro->user->nombre }}</h4>
                                    <div class="miembro-rol {{ $miembro->es_lider ? 'lider' : '' }}">
                                        @if($miembro->es_lider)
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                        @endif
                                        {{ $miembro->rol->nombre ?? 'Miembro' }}
                                    </div>
                                </div>
                            </div>

                            {{-- Información Académica --}}
                            <div class="miembro-info-academica">
                                @if($miembro->user->estudiante)
                                    <div class="info-item carrera">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                        </svg>
                                        <span>{{ $miembro->user->estudiante->carrera->nombre ?? 'Sin carrera' }}</span>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-item semestre">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            <span>{{ $miembro->user->estudiante->semestre }}° Semestre</span>
                                        </div>
                                        <div class="info-item control">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                            </svg>
                                            <span>{{ $miembro->user->estudiante->numero_control }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Email --}}
                            <div class="miembro-contacto">
                                <a href="mailto:{{ $miembro->user->email }}" class="email-link">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $miembro->user->email ?? 'N/A' }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Acciones -->
            <div class="acciones-container">
                @if($esMiembro)
                    <a href="{{ route('estudiante.equipo.index') }}" class="btn-accion btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Gestionar Equipo
                    </a>
                @else
                    @php
                        $equipoLleno = $inscripcionActiva ? $inscripcionActiva->miembros->count() >= 5 : true;
                        $eventoActivo = $inscripcionActiva && $inscripcionActiva->evento && in_array($inscripcionActiva->evento->estado, ['Próximo', 'Activo']);
                    @endphp

                    @if($eventoActivo && !$equipoLleno)
                        @if($solicitudActual)
                            @if($solicitudActual->status === 'pendiente')
                                <button disabled class="btn-accion btn-outline" style="background: rgba(234, 179, 8, 0.1); color: #ca8a04; border-color: #ca8a04;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Solicitud Pendiente
                                </button>
                            @elseif($solicitudActual->status === 'rechazada')
                                <div style="display: flex; flex-direction: column; gap: 0.5rem; flex: 1;">
                                    <form action="{{ route('estudiante.solicitudes.store', $equipo) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-accion btn-primary" style="width: 100%;">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Volver a Solicitar
                                        </button>
                                    </form>
                                    <p style="color: #dc2626; font-size: 0.75rem; text-align: center;">Tu solicitud anterior fue rechazada</p>
                                </div>
                            @endif
                        @else
                            <form action="{{ route('estudiante.solicitudes.store', $equipo) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn-accion btn-primary" style="width: 100%;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                    </svg>
                                    Solicitar Unirme
                                </button>
                            </form>
                        @endif
                    @elseif($equipoLleno)
                        <button disabled class="btn-accion btn-outline" style="background: rgba(107, 114, 128, 0.1); color: #6b7280;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Equipo Completo
                        </button>
                    @else
                        <button disabled class="btn-accion btn-outline" style="background: rgba(107, 114, 128, 0.1); color: #6b7280;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Inscripciones No Disponibles
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection