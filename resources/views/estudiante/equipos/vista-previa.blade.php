@extends('layouts.app')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/estudiante/equipos/vista-previa.css') }}">
@endpush

{{-- Mensajes de alerta --}}
@if(session('success'))
    <div style="position: fixed; top: 80px; right: 20px; z-index: 9999; padding: 1rem 1.5rem; background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-radius: 12px; box-shadow: 4px 4px 12px rgba(0,0,0,0.15); font-family: 'Inter', sans-serif; font-weight: 500; max-width: 400px; animation: slideInRight 0.5s ease;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div style="position: fixed; top: 80px; right: 20px; z-index: 9999; padding: 1rem 1.5rem; background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border-radius: 12px; box-shadow: 4px 4px 12px rgba(0,0,0,0.15); font-family: 'Inter', sans-serif; font-weight: 500; max-width: 400px; animation: slideInRight 0.5s ease;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    </div>
@endif

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
                        <div class="miembro-card">
                            <div class="miembro-header">
                                <div class="miembro-avatar">
                                    {{ strtoupper(substr($miembro->user->nombre ?? 'M', 0, 2)) }}
                                </div>
                                <div class="miembro-info">
                                    <h4>{{ $miembro->user->nombre }}</h4>
                                    <div class="miembro-rol {{ $miembro->es_lider ? 'lider' : '' }}">
                                        @if($miembro->es_lider)
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Líder
                                        @else
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        @endif
                                        {{ $miembro->rol->nombre ?? 'Miembro' }}
                                    </div>
                                </div>
                            </div>
                            <div class="miembro-detalle">
                                <strong>Email:</strong> {{ $miembro->user->email ?? 'N/A' }}
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