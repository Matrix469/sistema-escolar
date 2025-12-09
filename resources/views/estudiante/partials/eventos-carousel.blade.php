@php
    $eventosDisponibles = \App\Models\Evento::where('estado','Próximo')
        ->orWhere('estado','Activo')
        ->with('inscripciones')
        ->orderBy('fecha_inicio','asc')
        ->take(6)
        ->get();
@endphp

<div class="section-header">
    <h3 class="section-title">
        <span class="section-title-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </span>
        Eventos Disponibles
    </h3>
    <a href="{{ route('estudiante.eventos.index') }}" class="section-link">
        Ver todos
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </a>
</div>

@if($eventosDisponibles->count() > 0)
    <div class="carousel-container animate-in delay-3" id="eventosCarousel">
        <div class="carousel-track-container">
            <div class="carousel-track" id="eventosTrack">
                @foreach($eventosDisponibles as $evento)
                    <div class="carousel-slide">
                        <div class="card-neu">
                            {{-- Imagen de fondo --}}
                            <div class="card-image-container">
                                @if($evento->ruta_imagen)
                                    <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="{{ $evento->nombre }}" class="card-image">
                                @else
                                    <div class="card-image-placeholder">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="card-image-overlay"></div>
                                <span class="card-badge">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $evento->estado }}
                                </span>
                            </div>
                            
                            {{-- Contenido --}}
                            <div class="card-content">
                                <h4 class="card-title">{{ $evento->nombre }}</h4>
                                <p class="card-desc">{{ Str::limit($evento->descripcion, 60) }}</p>
                                
                                <div class="card-meta">
                                    <span class="card-meta-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ $evento->fecha_inicio->format('d M') }}
                                    </span>
                                    <span class="card-meta-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $evento->inscripciones->count() }} equipos
                                    </span>
                                </div>
                                
                                <a href="{{ route('estudiante.eventos.show', $evento) }}" class="card-action-btn">
                                    Ver Detalles
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="carousel-nav">
            <button class="carousel-arrow prev" onclick="navigateCarousel('eventos','prev')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <div class="carousel-dots" id="eventosDots"></div>
            <button class="carousel-arrow next" onclick="navigateCarousel('eventos','next')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        <div class="carousel-progress">
            <div class="carousel-progress-bar" id="eventosProgress"></div>
        </div>
    </div>
@endif
