@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .equipo-publico-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .equipo-publico-page h1,
    .equipo-publico-page h2,
    .equipo-publico-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .equipo-publico-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back button */
    .back-button {
        color: #2c2c2c;
        transition: all 0.2s ease;
    }
    
    .back-button:hover {
        color: #e89a3c;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
    }
    
    .main-card img {
        height: 16rem;
        width: 100%;
        object-fit: cover;
    }
    
    /* Team header */
    .team-header {
        border-bottom: 1px solid rgba(232, 154, 60, 0.2);
        padding-bottom: 1.5rem;
    }
    
    .team-title {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 700;
        font-size: 1.875rem;
    }
    
    .event-link {
        color: #e89a3c;
        transition: all 0.2s ease;
    }
    
    .event-link:hover {
        color: #d98a2c;
        text-decoration: underline;
    }
    
    /* Description box */
    .description-box {
        margin-top: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    .description-box h3 {
        font-weight: 600;
        color: #2c2c2c;
        margin-bottom: 0.5rem;
    }
    
    /* Status info */
    .status-info {
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .status-info span {
        font-size: 0.875rem;
    }
    
    .status-info strong {
        color: #2c2c2c;
    }
    
    .status-complete {
        color: #059669;
        font-weight: 600;
    }
    
    .status-looking {
        color: #d97706;
        font-weight: 600;
    }
    
    /* Members section */
    .members-section {
        margin-top: 2rem;
    }
    
    .members-section h3 {
        font-size: 1.125rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    
    /* Member item */
    .member-item {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(232, 154, 60, 0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .member-item:last-child {
        border-bottom: none;
    }
    
    .member-photo {
        width: 3rem;
        height: 3rem;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e89a3c;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .member-name {
        font-weight: 600;
        color: #2c2c2c;
    }
    
    .member-career {
        font-size: 0.875rem;
        color: #9ca3af;
    }
    
    /* Badges */
    .badge-lider {
        font-family: 'Poppins', sans-serif;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        padding: 0.25rem 0.5rem;
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #92400e;
        border-radius: 20px;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .badge-rol {
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        padding: 0.125rem 0.5rem;
        border-radius: 20px;
        background: rgba(224, 231, 255, 0.8);
        color: #3730a3;
        font-size: 0.75rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    /* Action section */
    .action-section {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(232, 154, 60, 0.2);
    }
    
    /* Alert boxes */
    .alert-box {
        padding: 1rem;
        border-radius: 0 15px 15px 0;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        margin-bottom: 1rem;
    }
    
    .alert-success {
        background: linear-gradient(135deg, rgba(209, 250, 229, 0.5), rgba(167, 243, 208, 0.5));
        border-left: 4px solid #10b981;
    }
    
    .alert-success p {
        color: #065f46;
    }
    
    .alert-success .font-semibold {
        font-weight: 700;
    }
    
    .alert-success a {
        color: #047857;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: inline-block;
        transition: all 0.2s ease;
    }
    
    .alert-success a:hover {
        color: #065f46;
        text-decoration: underline;
    }
    
    .alert-warning {
        background: linear-gradient(135deg, rgba(254, 243, 199, 0.5), rgba(254, 240, 138, 0.5));
        border-left: 4px solid #f59e0b;
    }
    
    .alert-warning p {
        color: #92400e;
    }
    
    .alert-warning .font-semibold {
        font-weight: 700;
    }
    
    .alert-info {
        background: linear-gradient(135deg, rgba(219, 234, 254, 0.5), rgba(191, 219, 254, 0.5));
        border-left: 4px solid #3b82f6;
    }
    
    .alert-info p {
        color: #1e40af;
    }
    
    .alert-info .font-semibold {
        font-weight: 700;
    }
    
    .alert-error {
        background: linear-gradient(135deg, rgba(254, 226, 226, 0.5), rgba(252, 165, 165, 0.5));
        border-left: 4px solid #ef4444;
    }
    
    .alert-error p {
        color: #991b1b;
    }
    
    .alert-error .font-semibold {
        font-weight: 700;
    }
    
    .alert-gray {
        background: linear-gradient(135deg, rgba(243, 244, 246, 0.5), rgba(229, 231, 235, 0.5));
        border-left: 4px solid #6b7280;
    }
    
    .alert-gray p {
        color: #374151;
    }
    
    .alert-gray .font-semibold {
        font-weight: 700;
    }
    
    /* Request button */
    .btn-request {
        font-family: 'Poppins', sans-serif;
        width: 100%;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        border-radius: 0.75rem;
        font-weight: 600;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-request:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
    
    .help-text {
        font-size: 0.75rem;
        color: #9ca3af;
        text-align: center;
        margin-top: 0.5rem;
    }
</style>

<div class="equipo-publico-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('estudiante.eventos.equipos.index', $evento) }}" class="back-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl ml-2">
                {{ $inscripcion->equipo->nombre }}
            </h2>
        </div>

        <div class="main-card">
            @if ($inscripcion->equipo->ruta_imagen)
                <img src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
            @endif
            
            <div class="p-6 sm:p-8">
                <!-- Información del Equipo -->
                <div class="team-header">
                    <h1 class="team-title">{{ $inscripcion->equipo->nombre }}</h1>
                    <p class="text-sm mt-2">
                        Evento: 
                        <a href="{{ route('estudiante.eventos.show', $inscripcion->evento) }}" class="event-link">
                            {{ $inscripcion->evento->nombre }}
                        </a>
                    </p>

                    @if($inscripcion->equipo->descripcion)
                        <div class="description-box">
                            <h3>Descripción del Equipo</h3>
                            <p class="text-sm" style="line-height: 1.6;">{{ $inscripcion->equipo->descripcion }}</p>
                        </div>
                    @endif

                    <!-- Estado del Equipo -->
                    <div class="status-info">
                        <span>
                            <strong>Estado:</strong>
                            @if($inscripcion->status_registro === 'Completo')
                                <span class="status-complete">Equipo Completo</span>
                            @else
                                <span class="status-looking">Buscando Miembros</span>
                            @endif
                        </span>
                        <span>
                            <strong>Miembros:</strong> {{ $inscripcion->miembros->count() }}
                        </span>
                    </div>
                </div>

                <!-- Lista de Miembros (Solo lectura) -->
                <div class="members-section">
                    <h3>
                        Miembros del Equipo
                    </h3>
                    <ul>
                        @foreach($inscripcion->miembros as $miembro)
                            <li class="member-item">
                                <!-- Foto de Perfil -->
                                <img src="{{ $miembro->user->foto_perfil_url }}" 
                                     alt="{{ $miembro->user->nombre }}" 
                                     class="member-photo">
                                
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <p class="member-name">
                                            {{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}
                                        </p>
                                        @if($miembro->es_lider)
                                            <span class="badge-lider">
                                                Líder
                                            </span>
                                        @endif
                                    </div>
                                    <p class="member-career">
                                        {{ $miembro->user->estudiante->carrera->nombre ?? 'Carrera no disponible' }}
                                    </p>
                                    <p style="font-size: 0.75rem; margin-top: 0.125rem;">
                                        <span class="badge-rol">
                                            {{ $miembro->rol->nombre ?? 'Rol no asignado' }}
                                        </span>
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Botón de Solicitud -->
                <div class="action-section">
                    @if ($evento->estado === 'Activo' && $inscripcion->status_registro !== 'Completo')
                        @if ($miInscripcionDeEquipoId)
                            {{-- El usuario YA es miembro de un equipo en este evento --}}
                            @if ($miInscripcionDeEquipoId === $inscripcion->equipo->id_equipo)
                                <div class="alert-box alert-success">
                                    <p class="font-semibold">✓ Ya eres miembro de este equipo</p>
                                    <a href="{{ route('estudiante.equipo.index') }}">
                                        Ir a Mi Equipo →
                                    </a>
                                </div>
                            @else
                                <div class="alert-box alert-warning">
                                    <p class="font-semibold">Ya eres miembro de otro equipo en este evento</p>
                                    <p class="text-sm mt-1">No puedes estar en dos equipos simultáneamente.</p>
                                </div>
                            @endif
                        @else
                            {{-- El usuario NO es miembro de ningún equipo --}}
                            @if ($solicitudActual)
                                @if ($solicitudActual->status === 'pendiente')
                                    <div class="alert-box alert-info">
                                        <p class="font-semibold">⏳ Solicitud enviada</p>
                                        <p class="text-sm mt-1">El líder del equipo está revisando tu solicitud.</p>
                                    </div>
                                @elseif ($solicitudActual->status === 'aceptada')
                                    <div class="alert-box alert-success">
                                        <p class="font-semibold">✓ Solicitud aceptada</p>
                                        <p class="text-sm mt-1">Ya eres parte de este equipo.</p>
                                    </div>
                                @elseif ($solicitudActual->status === 'rechazada')
                                    <div class="alert-box alert-error">
                                        <p class="font-semibold">Tu solicitud fue rechazada</p>
                                        <p class="text-sm mt-1">Puedes volver a solicitar unirte si lo deseas.</p>
                                    </div>
                                    <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-request">
                                            Volver a Solicitar Unirme
                                        </button>
                                    </form>
                                @endif
                            @else
                                {{-- No hay solicitud, puede enviar una --}}
                                <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-request">
                                        Solicitar Unirme a este Equipo
                                    </button>
                                </form>
                                <p class="help-text">
                                    El líder del equipo recibirá tu solicitud y decidirá si aceptarte.
                                </p>
                            @endif
                        @endif
                    @elseif ($inscripcion->status_registro === 'Completo')
                        <div class="alert-box alert-gray">
                            <p class="font-semibold">Equipo completo</p>
                            <p class="text-sm mt-1">Este equipo ya alcanzó el número máximo de miembros.</p>
                        </div>
                    @else
                        <div class="alert-box alert-gray">
                            <p class="font-semibold">Inscripciones no disponibles</p>
                            <p class="text-sm mt-1">El evento aún no está activo.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection