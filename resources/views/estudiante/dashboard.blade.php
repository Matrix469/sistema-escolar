@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ Vite::asset('resources/css/estudiante/dashboard.css') }}">
@endpush

@section('content')

<div class="student-dashboard py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Welcome Hero Section -->
        <div class="welcome-hero">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1>¡Hola, <span>{{ Auth::user()->name }}</span>!</h1>
                    <p>Bienvenido a tu panel de control. Aquí puedes ver tus eventos, proyectos y progreso.</p>
                </div>
                <div class="welcome-stats">
                    <div class="welcome-stat">
                        <div class="welcome-stat-number">{{ $miInscripcion ? 1 : 0 }}</div>
                        <div class="welcome-stat-label">Evento Activo</div>
                    </div>
                    <div class="welcome-stat">
                        <div class="welcome-stat-number">{{ $eventosDisponibles->count() }}</div>
                        <div class="welcome-stat-label">Disponibles</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipos Disponibles Carousel -->
        <div class="section-header">
            <h3 class="section-title">
                <span class="section-title-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                Equipos Disponibles
            </h3>
            <a href="{{ route('estudiante.eventos.index') }}" class="section-link">
                Ver todos
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @php
            $equiposDisponibles = \App\Models\InscripcionEvento::whereHas('evento', function($q) {
                $q->where('estado', 'Próximo')
                  ->orWhere('estado', 'Activo');
            })
            ->where('status_registro', 'Incompleto')
            ->with(['equipo', 'evento', 'miembros.rol'])
            ->take(6)
            ->get();
        @endphp

        @if($equiposDisponibles->count() > 0)
            <div style="margin-bottom: 2rem;">
                <div class="carousel-container animate-in delay-3" id="equiposCarousel">
                    <div class="carousel-track-container">
                        <div class="carousel-track" id="equiposTrack">
                            @foreach ($equiposDisponibles as $inscripcion)
                                <div class="carousel-slide">
                                    <div class="team-card">
                                        <div class="team-header">
                                            <div class="team-avatar">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <div class="team-info">
                                                <h4>{{ $inscripcion->equipo->nombre }}</h4>
                                                <p>{{ $inscripcion->evento->nombre }}</p>
                                            </div>
                                        </div>

                                        <div class="team-members">
                                            @foreach($inscripcion->miembros->take(4) as $miembro)
                                                <div class="member-avatar" title="{{ $miembro->estudiante->user->nombre ?? 'Miembro' }}">
                                                    {{ strtoupper(substr($miembro->estudiante->user->nombre ?? 'M', 0, 1)) }}
                                                </div>
                                            @endforeach
                                            @if($inscripcion->miembros->count() > 4)
                                                <div class="member-avatar more">
                                                    +{{ $inscripcion->miembros->count() - 4 }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="team-status {{ $inscripcion->miembros->count() >= 5 ? 'completo' : 'incompleto' }}">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($inscripcion->miembros->count() >= 5)
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                                @endif
                                            </svg>
                                            {{ $inscripcion->miembros->count() >= 5 ? 'Equipo Completo' : (5 - $inscripcion->miembros->count()) . ' espacio' . ((5 - $inscripcion->miembros->count()) != 1 ? 's' : '') . ' disponible' }}
                                        </div>

                                        <a href="{{ route('estudiante.equipos.vista-previa', $inscripcion->equipo) }}" class="team-view-btn">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Ver Equipo
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="carousel-nav">
                        <button class="carousel-arrow prev" onclick="navigateCarousel('prev')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <div class="carousel-dots" id="equiposDots"></div>
                        <button class="carousel-arrow next" onclick="navigateCarousel('next')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                    <div class="carousel-progress">
                        <div class="carousel-progress-bar" id="equiposProgress"></div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Grid -->
        <div class="dashboard-grid">
            
            <!-- Left Column - Events -->
            <div class="left-column">
                {{-- Eventos Disponibles (partial) --}}
                @include('estudiante.partials.eventos-carousel')

                {{-- Equipos Disponibles (partial) --}}
                @include('estudiante.partials.equipos-carousel')
                @if ($miInscripcion)
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="section-title-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </span>
                        Evento Activo
                    </h3>
                </div>
                
                <div class="event-card event-card-active">
                    <div class="event-card-header">
                        <span class="event-badge">Participando</span>
                        <h4 class="event-title">{{ $miInscripcion->evento->nombre }}</h4>
                    </div>
                    <div class="event-card-body">
                        <p class="event-desc">{{ Str::limit($miInscripcion->evento->descripcion ?? 'Sin descripción disponible', 120) }}</p>
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $miInscripcion->evento->fecha_inicio->format('d M, Y') }}
                            </div>
                            <div class="event-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $miInscripcion->evento->inscripciones->count() }} equipos
                            </div>
                        </div>
                        <a href="{{ route('estudiante.eventos.show', $miInscripcion->evento) }}" class="event-action-btn">
                            Ver detalles
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Available Events -->
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="section-title-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        Eventos Disponibles
                    </h3>
                    <a href="{{ route('estudiante.eventos.index') }}" class="section-link">
                        Ver todos
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @forelse ($eventosDisponibles->take(2) as $evento)
                <div class="event-card">
                    <div class="event-card-header">
                        <span class="event-badge">{{ $evento->estado }}</span>
                        <h4 class="event-title">{{ $evento->nombre }}</h4>
                    </div>
                    <div class="event-card-body">
                        <p class="event-desc">{{ Str::limit($evento->descripcion ?? 'Sin descripción', 100) }}</p>
                        <div class="event-meta">
                            <div class="event-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Inicia: {{ $evento->fecha_inicio->format('d M, Y') }}
                            </div>
                            <div class="event-meta-item">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $evento->inscripciones->count() }} participantes
                            </div>
                        </div>
                        <a href="{{ route('estudiante.eventos.show', $evento) }}" class="event-action-btn">
                            Ver detalles
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3>Sin eventos disponibles</h3>
                    <p>No hay eventos disponibles en este momento. Vuelve pronto para ver nuevas oportunidades.</p>
                    <a href="{{ route('estudiante.eventos.index') }}" class="empty-state-btn">
                        Explorar eventos
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Right Column - Progress & Actions -->
            <div class="right-column">
                
                <!-- Progress Section -->
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="section-title-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </span>
                        Progreso del Proyecto
                    </h3>
                </div>

                <div class="progress-card">
                    @if($miInscripcion && $miInscripcion->equipo)
                        @php
                            $equipo = $miInscripcion->equipo;
                            $miembro = $equipo->miembros->where('id_estudiante', Auth::user()->estudiante->id_estudiante)->first();
                            $progreso = 0; // Aquí puedes calcular el progreso real
                        @endphp
                        
                        <div class="progress-header">
                            <div class="progress-info">
                                <h4 class="progress-team-name">{{ $equipo->nombre }}</h4>
                                <div class="progress-tags">
                                    <span class="progress-tag">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                        {{ $miInscripcion->evento->nombre }}
                                    </span>
                                    <span class="progress-tag">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $miembro->rol->nombre ?? 'Miembro' }}
                                    </span>
                                </div>
                            </div>
                            <div class="progress-circle">
                                <svg width="120" height="120" viewBox="0 0 100 100">
                                    <defs>
                                        <linearGradient id="progressGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" style="stop-color:#6366f1"/>
                                            <stop offset="100%" style="stop-color:#8b5cf6"/>
                                        </linearGradient>
                                    </defs>
                                    <circle class="progress-circle-bg" cx="50" cy="50" r="40" stroke="#e5e7eb" fill="none"/>
                                    <circle class="progress-circle-fill" cx="50" cy="50" r="40" style="stroke-dashoffset: {{ 251.2 - (251.2 * $progreso / 100) }}"/>
                                </svg>
                                <div class="progress-circle-text">
                                    <span class="progress-percentage">{{ $progreso }}%</span>
                                    <span class="progress-label">Avance</span>
                                </div>
                            </div>
                        </div>

                        <div class="progress-details">
                            <div class="progress-detail-item">
                                <div class="progress-detail-value">{{ $equipo->miembros->count() }}</div>
                                <div class="progress-detail-label">Miembros</div>
                            </div>
                            <div class="progress-detail-item">
                                <div class="progress-detail-value">0</div>
                                <div class="progress-detail-label">Tareas</div>
                            </div>
                            <div class="progress-detail-item">
                                <div class="progress-detail-value">0</div>
                                <div class="progress-detail-label">Avances</div>
                            </div>
                        </div>

                        <div class="progress-link">
                            <a href="{{ route('estudiante.equipo.index') }}">
                                Ver detalles del equipo
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="no-progress-state">
                            <div class="no-progress-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="no-progress-text">
                                <h4>Sin equipo asignado</h4>
                                <p>Únete a un equipo para comenzar tu proyecto</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="section-title-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </span>
                        Acciones Rápidas
                    </h3>
                </div>

                <div class="quick-actions">
                    <a href="{{ route('estudiante.eventos.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-events">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="quick-action-content">
                            <h4>Eventos</h4>
                            <p>Explora eventos activos</p>
                        </div>
                    </a>

                    @if($miInscripcion && $miInscripcion->evento->estado === 'En Progreso')
                        @php
                            $evento = $miInscripcion->evento;
                            $proyectoEvento = $evento->tipo_proyecto === 'general' 
                                ? $evento->proyectoGeneral 
                                : $miInscripcion->proyectoEvento;
                        @endphp
                        
                        @if($proyectoEvento && $proyectoEvento->publicado)
                            <a href="{{ route('estudiante.proyecto-evento.show') }}" class="quick-action-card">
                                <div class="quick-action-icon icon-project">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="quick-action-content">
                                    <h4>Proyecto del Evento</h4>
                                    <p>{{ Str::limit($proyectoEvento->titulo, 20) }}</p>
                                </div>
                            </a>
                        @else
                            <div class="quick-action-card quick-action-disabled">
                                <div class="quick-action-icon icon-project">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="quick-action-content">
                                    <h4>Proyecto del Evento</h4>
                                    <p>Esperando publicación...</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('estudiante.constancias.index') }}" class="quick-action-card">
                            <div class="quick-action-icon icon-certificates">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <div class="quick-action-content">
                                <h4>Constancias</h4>
                                <p>Genera tus constancias</p>
                            </div>
                        </a>
                    @endif

                    @if($miInscripcion && $miInscripcion->proyecto)
                        <a href="#" class="quick-action-card">
                            <div class="quick-action-icon icon-project">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="quick-action-content">
                                <h4>Mi Proyecto</h4>
                                <p>Ver mi proyecto actual</p>
                            </div>
                        </a>
                    @else
                        <div class="quick-action-card quick-action-disabled">
                            <div class="quick-action-icon icon-project">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="quick-action-content">
                                <h4>Mi Proyecto</h4>
                                <p>Sin proyectos activos</p>
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('estudiante.equipo.index') }}" class="quick-action-card">
                        <div class="quick-action-icon icon-team">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="quick-action-content">
                            <h4>Mi Equipo</h4>
                            <p>Gestiona tu equipo</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Carousel functionality for equipos
class Carousel {
    constructor(trackId, dotsId, progressBarId) {
        console.log('Carousel constructor called with:', trackId, dotsId, progressBarId);

        this.track = document.getElementById(trackId);
        this.dotsContainer = document.getElementById(dotsId);
        this.progressBar = document.getElementById(progressBarId);

        if (!this.track) {
            console.error('Track element not found:', trackId);
            return;
        }

        this.currentIndex = 0;
        this.slides = this.track.querySelectorAll('.carousel-slide');
        this.totalSlides = this.slides.length;

        console.log('Carousel found slides:', this.totalSlides);

        this.init();
    }

    init() {
        // Always initialize, even with 1 or 0 slides
        console.log('Initializing carousel with', this.totalSlides, 'slides');

        // Create dots only if we have slides
        if (this.totalSlides > 0) {
            this.createDots();
        }

        // Set initial state
        this.updateCarousel();

        // Auto-play only if we have more than 1 slide
        if (this.totalSlides > 1) {
            this.startAutoPlay();

            // Pause on hover
            this.track.addEventListener('mouseenter', () => this.stopAutoPlay());
            this.track.addEventListener('mouseleave', () => this.startAutoPlay());
        }
    }

    createDots() {
        for (let i = 0; i < this.totalSlides; i++) {
            const dot = document.createElement('button');
            dot.className = 'carousel-dot';
            dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
            dot.onclick = () => this.goToSlide(i);
            this.dotsContainer.appendChild(dot);
        }
    }

    goToSlide(index) {
        this.currentIndex = index;
        this.updateCarousel();
    }

    next() {
        if (this.totalSlides <= 1) return;
        this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
        this.updateCarousel();
    }

    prev() {
        if (this.totalSlides <= 1) return;
        this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;
        this.updateCarousel();
    }

    updateCarousel() {
        if (!this.track || !this.dotsContainer || !this.progressBar) return;

        // Update position
        this.track.style.transform = `translateX(-${this.currentIndex * 100}%)`;

        // Update dots only if they exist
        const dots = this.dotsContainer.querySelectorAll('.carousel-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentIndex);
        });

        // Update progress bar only if we have slides
        if (this.totalSlides > 0) {
            const progress = ((this.currentIndex + 1) / this.totalSlides) * 100;
            this.progressBar.style.width = `${progress}%`;
        }
    }

    startAutoPlay() {
        this.stopAutoPlay();
        this.autoPlayInterval = setInterval(() => this.next(), 5000);
    }

    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
        }
    }
}

// Global navigation function
function navigateCarousel(direction) {
    if (window.equiposCarousel) {
        console.log('Navigating carousel:', direction);
        if (direction === 'prev') {
            window.equiposCarousel.prev();
        } else if (direction === 'next') {
            window.equiposCarousel.next();
        }
    } else {
        console.error('Carousel not initialized');
    }
}

// Initialize carousels
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking for carousel elements...');

    // Check if carousel elements exist before initializing
    const equiposTrack = document.getElementById('equiposTrack');
    const equiposDots = document.getElementById('equiposDots');
    const equiposProgress = document.getElementById('equiposProgress');

    console.log('Carousel elements found:', {
        track: !!equiposTrack,
        dots: !!equiposDots,
        progress: !!equiposProgress
    });

    if (equiposTrack && equiposDots && equiposProgress) {
        const equiposCarousel = new Carousel('equiposTrack', 'equiposDots', 'equiposProgress');
        // Make it globally accessible for onclick handlers
        window.equiposCarousel = equiposCarousel;
        console.log('Carousel initialized successfully');
    } else {
        console.error('Carousel elements not found');
    }
});
</script>
@endsection