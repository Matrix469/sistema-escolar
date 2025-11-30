@extends('layouts.prueba')

@section('title', 'Inicio')

@section('content')
    <section class="left-col">
        <h3 class="section-title">Eventos actuales</h3>
        
        @if ($miInscripcion)
            {{-- Evento Activo --}}
            <div class="event-card-container neu-card">
                <div class="event-card-header">{{ $miInscripcion->evento->nombre }}</div>
                <div class="event-card-body">
                    <p class="event-desc">{{ Str::limit($miInscripcion->evento->descripcion ?? 'Sin descripción disponible', 100) }}</p>
                    <p class="event-date">{{ $miInscripcion->evento->fecha_inicio->format('d \d\e F, Y') }}</p>
                    <p class="event-participants">
                        Participantes: {{ $miInscripcion->evento->inscripciones->count() }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('estudiante.eventos.show', $miInscripcion->evento) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                            Ver detalles del evento →
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="event-card-container neu-card">
                <div class="event-card-header">No hay eventos activos</div>
                <div class="event-card-body">
                    <p class="event-desc">Actualmente no estás participando en ningún evento. Explora los eventos disponibles para unirte.</p>
                </div>
            </div>
        @endif

        <h3 class="section-title">Eventos disponibles</h3>
        
        @forelse ($eventosDisponibles->take(2) as $evento)
            <div class="event-card-container neu-card">
                <div class="event-card-header">{{ $evento->nombre }}</div>
                <div class="event-card-body">
                    <p class="event-desc">{{ Str::limit($evento->descripcion ?? 'Sin descripción', 100) }}</p>
                    <p class="event-date">Inicia: {{ $evento->fecha_inicio->format('d \d\e F, Y') }}</p>
                    <p class="event-participants">
                        Participantes: {{ $evento->inscripciones->count() }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('estudiante.eventos.show', $evento) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                            Ver detalles →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="event-card-container neu-card">
                <div class="event-card-header">Sin eventos disponibles</div>
                <div class="event-card-body">
                    <p class="event-desc">No hay eventos disponibles en este momento. Vuelve pronto para ver nuevas oportunidades.</p>
                </div>
            </div>
        @endforelse
    </section>

    <section class="right-col">
        <h3 class="section-title">Progreso del proyecto actual</h3>
        
        <div class="progress-main-card neu-card">
            @if($miInscripcion && $miInscripcion->equipo)
                <div class="progress-info-items">
                    <div class="info-item">{{ $miInscripcion->equipo->nombre }}</div>
                    <div class="info-item">{{ $miInscripcion->evento->nombre }}</div>
                    <div class="info-item">
                        {{ $miInscripcion->equipo->miembros->where('id_estudiante', Auth::user()->estudiante->id_estudiante)->first()->rol->nombre ?? 'Miembro' }}
                    </div>
                </div>
                <div class="progress-circle-container">
                    <div class="progress-ring"></div>
                    <div class="progress-text">
                        <span>Avance</span>
                        <strong>0%</strong>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('estudiante.equipo.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold text-sm">
                        Ver detalles del equipo →
                    </a>
                </div>
            @else
                <div class="progress-info-items">
                    <div class="info-item">Sin equipo asignado</div>
                    <div class="info-item">Sin evento activo</div>
                    <div class="info-item">Sin rol</div>
                </div>
                <div class="progress-circle-container">
                    <div class="progress-ring"></div>
                    <div class="progress-text">
                        <span>Avance</span>
                        <strong>0%</strong>
                    </div>
                </div>
            @endif
        </div>

        <div class="cards-grid">
            <a href="{{ route('estudiante.eventos.index') }}" class="small-card neu-card">
                <div class="card-icon-box icon-athena"><i class="fas fa-calendar-alt"></i></div>
                <div class="card-content-box">
                    <h4>EVENTOS ACTIVOS</h4>
                    <p>Verifica los eventos en curso</p>
                </div>
            </a>

            <div class="small-card neu-card">
                <div class="card-icon-box icon-const"><i class="fas fa-certificate"></i></div>
                <div class="card-content-box">
                    <h4>CONSTANCIAS</h4>
                    <p>Genera tus constancias</p>
                </div>
            </div>

            @if($miInscripcion && $miInscripcion->proyecto)
                <a href="#" class="small-card neu-card">
                    <div class="card-icon-box icon-projects"><i class="fas fa-cogs"></i></div>
                    <div class="card-content-box">
                        <h4>MIS PROYECTOS</h4>
                        <p>Verifica tus proyectos</p>
                    </div>
                </a>
            @else
                <div class="small-card neu-card">
                    <div class="card-icon-box icon-projects"><i class="fas fa-cogs"></i></div>
                    <div class="card-content-box">
                        <h4>MIS PROYECTOS</h4>
                        <p>Sin proyectos activos</p>
                    </div>
                </div>
            @endif

            <a href="{{ route('estudiante.equipo.index') }}" class="small-card neu-card">
                <div class="card-icon-box icon-teams"><i class="fas fa-users"></i></div>
                <div class="card-content-box">
                    <h4>EQUIPOS</h4>
                    <p>Verifica los equipos disponibles</p>
                </div>
            </a>
        </div>

        

    </section>
@endsection
