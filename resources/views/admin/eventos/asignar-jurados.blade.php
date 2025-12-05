@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .asignar-jurados-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .asignar-jurados-page h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .asignar-jurados-page p {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back button */
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
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        overflow: hidden;
        padding: 2rem;
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
    
    /* Alert error */
    .alert-error {
        background: rgba(254, 226, 226, 0.8);
        border-left: 4px solid #ef4444;
        color: #991b1b;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .alert-error p,
    .alert-error li {
        font-family: 'Poppins', sans-serif;
        color: #991b1b;
    }
    
    .alert-error .font-bold {
        font-weight: 700;
    }
    
    .alert-error ul {
        list-style: disc;
        margin-left: 1.5rem;
        margin-top: 0.5rem;
    }
    
    /* Instruction text */
    .instruction-text {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        margin-bottom: 1rem;
    }
    
    /* Checkbox card */
    .checkbox-card {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        cursor: pointer;
        backdrop-filter: blur(10px);
    }
    
    .checkbox-card:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .checkbox-card input[type="checkbox"] {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 0.375rem;
        border: 2px solid #d1d5db;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .checkbox-card input[type="checkbox"]:checked {
        background: #e89a3c;
        border-color: #e89a3c;
    }
    
    .checkbox-card input[type="checkbox"]:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(232, 154, 60, 0.2);
    }
    
    .checkbox-card span {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-weight: 500;
    }
    
    /* Empty state */
    .empty-state {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        grid-column: 1 / -1;
        text-align: center;
        padding: 2rem;
    }
    
    /* Submit button */
    .submit-button {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        border: none;
    }
    
    .submit-button:hover {
        box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.3);
        transform: translateY(-2px);
    }
</style>

<div class="asignar-jurados-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.show', $evento) }}" class="back-link">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Volver al evento
    </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Asignar Jurados a: {{ $evento->nombre }}
            </h2>
        </div>
        
        <div class="main-card">
            @if (session('success'))
                <div class="alert-success" role="alert">
                    <p class="font-bold">Éxito</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <p class="font-bold">¡Ups!</p>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.eventos.actualizar_asignacion', $evento) }}" method="POST">
                @csrf
                @method('PATCH')

                <p class="instruction-text">Selecciona los jurados para este evento (mínimo 3, máximo 5).</p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($juradosDisponibles as $jurado)
                        <label class="checkbox-card flex items-center space-x-3">
                            <input type="checkbox" name="jurados[]" value="{{ $jurado->id_usuario }}" 
                                {{ in_array($jurado->id_usuario, $juradosAsignadosIds) ? 'checked' : '' }}>
                            <span>
                                {{ $jurado->user->nombre }} {{ $jurado->user->app_paterno }}
                            </span>
                        </label>
                    @empty
                        <p class="empty-state">No hay jurados disponibles en el sistema.</p>
                    @endforelse
                </div>

                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="submit-button">
                        Guardar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection