@php
    $userId = auth()->id();
    
    // Obtener los IDs de eventos donde el usuario ya está inscrito
    $eventosDelUsuario = \App\Models\InscripcionEvento::whereHas('miembros', function($q) use ($userId) {
        $q->where('id_estudiante', $userId);
    })->pluck('id_evento')->toArray();
    
    // Obtener equipos disponibles
    $equiposDisponibles = \App\Models\InscripcionEvento::whereHas('evento', function($q) {
        $q->whereIn('estado', ['Próximo', 'Activo']);
    })
    ->when(count($eventosDelUsuario) > 0, function($q) use ($eventosDelUsuario) {
        $q->whereNotIn('id_evento', $eventosDelUsuario);
    })
    ->withCount('miembros')
    ->with(['equipo', 'evento', 'miembros.user'])
    ->get()
    ->filter(function($inscripcion) {
        return $inscripcion->miembros_count < 5;
    })
    ->take(6);
@endphp

<div class="section-header">
    <h3 class="section-title">
        <span class="section-title-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </span>
        Equipos Disponibles
    </h3>
    <a href="{{ route('estudiante.eventos.index') }}" class="section-link">
        Ver todos
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </a>
</div>

@if($equiposDisponibles->count() > 0)
    <div class="carousel-container animate-in delay-3" id="equiposCarousel">
        <div class="carousel-track-container">
            <div class="carousel-track" id="equiposTrack">
                @foreach ($equiposDisponibles as $inscripcion)
                    <div class="carousel-slide">
                        <div class="card-neu">
                            {{-- Imagen de fondo --}}
                            <div class="card-image-container">
                                @if($inscripcion->equipo->ruta_imagen)
                                    <img src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="{{ $inscripcion->equipo->nombre }}" class="card-image">
                                @else
                                    <div class="card-image-placeholder card-image-placeholder-team">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                @endif
                                <div class="card-image-overlay"></div>
                                <span class="card-badge card-badge-team">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                    {{ 5 - $inscripcion->miembros_count }} {{ (5 - $inscripcion->miembros_count) == 1 ? 'lugar' : 'lugares' }}
                                </span>
                            </div>
                            
                            {{-- Contenido --}}
                            <div class="card-content">
                                <h4 class="card-title">{{ $inscripcion->equipo->nombre }}</h4>
                                <p class="card-desc card-desc-event">{{ $inscripcion->evento->nombre }}</p>
                                
                                {{-- Avatares de miembros --}}
                                <div class="card-members">
                                    @foreach($inscripcion->miembros->take(4) as $miembro)
                                        <div class="card-member-avatar" title="{{ $miembro->user->nombre ?? 'Miembro' }}">
                                            {{ strtoupper(substr($miembro->user->nombre ?? 'M', 0, 1)) }}
                                        </div>
                                    @endforeach
                                    @if($inscripcion->miembros->count() > 4)
                                        <div class="card-member-avatar card-member-more">+{{ $inscripcion->miembros->count() - 4 }}</div>
                                    @endif
                                    <span class="card-member-count">{{ $inscripcion->miembros_count }}/5 miembros</span>
                                </div>
                                
                                <a href="{{ route('estudiante.equipos.vista-previa', $inscripcion->equipo) }}" class="card-action-btn card-action-btn-team">
                                    Ver Equipo
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="carousel-nav">
            <button class="carousel-arrow prev" onclick="navigateCarousel('equipos','prev')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="carousel-dots" id="equiposDots"></div>
            <button class="carousel-arrow next" onclick="navigateCarousel('equipos','next')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        <div class="carousel-progress">
            <div class="carousel-progress-bar" id="equiposProgress"></div>
        </div>
    </div>
@endif
