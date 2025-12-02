@extends('jurado.layouts.app')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    .evento-detail-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        padding: 40px 20px;
    }

    .evento-detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Header con imagen del evento */
    .evento-header {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 30px;
        margin-bottom: 40px;
    }

    .evento-imagen {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
    }

    .evento-imagen img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .status-badge-large {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: #2c2c2c;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* Descripción del evento */
    .descripcion-card {
        background: #FFF8F0;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }

    .descripcion-header {
        background: #DB8C57;
        color: white;
        padding: 12px 20px;
        border-radius: 12px;
        text-align: center;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .descripcion-body {
        color: #6b6b6b;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Sección de equipos */
    .equipos-section {
        margin-top: 30px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c2c2c;
        margin-bottom: 20px;
    }

    .equipos-header-card {
        background: #FFF8F0;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        margin-bottom: 15px;
    }

    .equipos-subtitle {
        font-weight: 600;
        font-size: 1.1rem;
        color: #2c2c2c;
        margin-bottom: 15px;
    }

    /* Lista de equipos */
    .equipo-item {
        background: #FCFCFC;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 2px 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }

    .equipo-item:hover {
        transform: translateY(-2px);
        box-shadow: 4px 4px 8px rgba(0,0,0,0.1);
    }

    .equipo-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .equipo-nombre {
        font-weight: 600;
        color: #2c2c2c;
        font-size: 1rem;
    }

    .equipo-leader {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #6b6b6b;
        font-size: 0.9rem;
    }

    .equipo-miembros {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #6b6b6b;
        font-size: 0.9rem;
    }

    .btn-explorar {
        background: #EBC08D;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-explorar:hover {
        background: #dca970;
    }

    .empty-equipos {
        text-align: center;
        padding: 40px;
        color: #6b6b6b;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .evento-header {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="evento-detail-page">
    <div class="evento-detail-container">
        
        <!-- Header con imagen y descripción -->
        <div class="evento-header">
            <!-- Imagen del evento -->
            <div class="evento-imagen">
                <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="{{ $evento->nombre }}">
                <span class="status-badge-large">{{ $evento->estado }}</span>
            </div>

            <!-- Descripción -->
            <div class="descripcion-card">
                <div class="descripcion-header">
                    Descripción
                </div>
                <div class="descripcion-header" style="background: #E77F30; margin-bottom: 15px;">
                    {{ $evento->nombre }}
                </div>
                <div class="descripcion-body">
                    {{ $evento->descripcion ?? 'Aquí debe de existir una descripción del evento' }}
                </div>
            </div>
        </div>

        <!-- Sección de Equipos -->
        <div class="equipos-section">
            <h3 class="section-title">Equipos</h3>
            
            <div class="equipos-header-card">
                <div class="equipos-subtitle">Equipos-Inscritos</div>
                
                @if($evento->inscripciones->isNotEmpty())
                    @foreach($evento->inscripciones as $inscripcion)
                        @if($inscripcion->equipo)
                            <div class="equipo-item">
                                <div class="equipo-info">
                                    <div style="flex: 1;">
                                        <div class="equipo-nombre">{{ $inscripcion->equipo->nombre }}</div>
                                    </div>
                                    
                                    <div class="equipo-leader">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 18px; height: 18px;">
                                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                        </svg>
                                        Líder del equipo
                                    </div>

                                    <div class="equipo-miembros">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 18px; height: 18px;">
                                            <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                                            <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                        </svg>
                                        Num de Miembros: {{ $inscripcion->equipo->miembros->count() }}
                                    </div>
                                </div>

                                <a href="{{ route('jurado.equipos.show', $inscripcion->equipo) }}" class="btn-explorar">
                                    Explorar
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 18px; height: 18px;">
                                        <path fill-rule="evenodd" d="M16.72 7.72a.75.75 0 0 1 1.06 0l3.75 3.75a.75.75 0 0 1 0 1.06l-3.75 3.75a.75.75 0 1 1-1.06-1.06l2.47-2.47H3a.75.75 0 0 1 0-1.5h16.19l-2.47-2.47a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="empty-equipos">
                        No hay equipos inscritos en este evento.
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection