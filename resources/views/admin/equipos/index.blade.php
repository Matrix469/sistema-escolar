@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .equipos-index-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .equipos-index-page h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .equipos-index-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Alert success */
    .alert-success {
        background: rgba(209, 250, 229, 0.8);
        border-left: 4px solid #10b981;
        color: #065f46;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .alert-success p {
        font-family: 'Poppins', sans-serif;
        color: #065f46;
    }
    
    .alert-success .font-bold {
        font-weight: 700;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
        padding: 1.5rem;
    }
    
    /* Team item */
    .team-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(232, 154, 60, 0.2);
        padding: 1rem 0;
    }
    
    .team-item:last-child {
        border-bottom: none;
    }
    
    /* Team image */
    .team-image {
        height: 4rem;
        width: 4rem;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
    }
    
    .team-placeholder {
        height: 4rem;
        width: 4rem;
        background: rgba(229, 231, 235, 0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 2px 2px 4px #e6d5c9, inset -2px -2px 4px #ffffff;
    }
    
    /* Team info */
    .team-name {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 600;
        font-size: 1.125rem;
        transition: all 0.2s ease;
    }
    
    .team-name:hover {
        color: #e89a3c;
        text-decoration: underline;
    }
    
    .team-evento {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.875rem;
    }
    
    .team-evento a {
        color: #e89a3c;
        transition: all 0.2s ease;
    }
    
    .team-evento a:hover {
        color: #d98a2c;
        text-decoration: underline;
    }
    
    /* Action buttons */
    .btn-edit {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-edit:hover {
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }
    
    .btn-delete {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #ffffff;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        box-shadow: 2px 2px 4px rgba(220, 38, 38, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn-delete:hover {
        box-shadow: 4px 4px 8px rgba(220, 38, 38, 0.4);
        transform: translateY(-2px);
    }
    
    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 2rem 0;
        color: #9ca3af;
        font-family: 'Poppins', sans-serif;
    }
</style>

<div class="equipos-index-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl mb-6">{{ __('Gestión de Equipos') }}</h2>
        
        @if (session('success'))
            <div class="alert-success" role="alert">
                <p class="font-bold">Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="main-card">
            @forelse ($equipos as $equipo)
                <div class="team-item">
                    <div class="flex items-center space-x-4">
                        @if ($equipo->ruta_imagen)
                            <img class="team-image" src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo">
                        @else
                            <div class="team-placeholder">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('admin.equipos.show', $equipo) }}" class="team-name">
                                {{ $equipo->nombre }}
                            </a>
                            @if($equipo->inscripciones->first() && $equipo->inscripciones->first()->evento)
                                <p class="team-evento">
                                    Evento: <a href="{{ route('admin.eventos.show', $equipo->inscripciones->first()->evento) }}">{{ $equipo->inscripciones->first()->evento->nombre }}</a>
                                </p>
                            @else
                                <p class="team-evento">No inscrito en evento activo.</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.equipos.edit', $equipo) }}" class="btn-edit inline-flex items-center">
                            Editar
                        </a>
                        <form action="{{ route('admin.equipos.destroy', $equipo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este equipo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="empty-state">No hay equipos registrados en el sistema.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection