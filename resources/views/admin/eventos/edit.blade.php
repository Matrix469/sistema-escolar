@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .evento-edit-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .evento-edit-page h2 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .evento-edit-page p,
    .evento-edit-page label {
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
        padding: 2rem;
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
    
    .alert-error strong {
        font-weight: 700;
    }
    
    .alert-error ul {
        list-style: disc;
        margin-left: 1.5rem;
        margin-top: 0.5rem;
    }
    
    .alert-error li {
        font-family: 'Poppins', sans-serif;
        color: #991b1b;
    }
    
    /* Labels */
    .form-label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 0.875rem;
        font-weight: 500;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    /* Inputs y textareas */
    .neuro-input,
    .neuro-textarea,
    .neuro-file {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        box-shadow: inset 4px 4px 8px #e6d5c9, inset -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        backdrop-filter: blur(10px);
        color: #2c2c2c;
        width: 100%;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        margin-top: 0.25rem;
    }
    
    .neuro-input:focus,
    .neuro-textarea:focus,
    .neuro-file:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Image preview */
    .image-preview {
        margin-top: 1rem;
    }
    
    .image-preview img {
        height: 8rem;
        width: auto;
        border-radius: 15px;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        margin-top: 0.5rem;
    }
    
    .image-preview p {
        font-size: 0.875rem;
        color: #9ca3af;
        margin-top: 0.5rem;
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

<div class="evento-edit-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.eventos.index') }}" class="back-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl ml-2">
                {{ __('Editar Evento') }}
            </h2>
        </div>
        
        <div class="main-card">
            @if ($errors->any())
                <div class="alert-error">
                    <strong>¡Ups!</strong> Hubo algunos problemas con tus datos.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.eventos.update', $evento) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre del Evento -->
                    <div>
                        <label for="nombre" class="form-label">Nombre del Evento</label>
                        <input type="text" name="nombre" id="nombre" class="neuro-input" value="{{ old('nombre', $evento->nombre) }}" required>
                    </div>

                    <!-- Cupo Máximo de Equipos -->
                    <div>
                        <label for="cupo_max_equipos" class="form-label">Cupo Máximo de Equipos</label>
                        <input type="number" name="cupo_max_equipos" id="cupo_max_equipos" class="neuro-input" value="{{ old('cupo_max_equipos', $evento->cupo_max_equipos) }}" required min="1">
                    </div>

                    <!-- Fecha de Inicio -->
                    <div>
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="neuro-input" value="{{ old('fecha_inicio', $evento->fecha_inicio->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Fecha de Fin -->
                    <div>
                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="neuro-input" value="{{ old('fecha_fin', $evento->fecha_fin->format('Y-m-d')) }}" required>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mt-6">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="neuro-textarea">{{ old('descripcion', $evento->descripcion) }}</textarea>
                </div>

                <!-- Imagen del Evento -->
                <div class="mt-6">
                    <label for="ruta_imagen" class="form-label">Nueva Imagen del Evento (Opcional)</label>
                    <input type="file" name="ruta_imagen" id="ruta_imagen" class="neuro-file">
                </div>

                <!-- Imagen Actual -->
                <div class="image-preview">
                    <label class="form-label">Imagen Actual</label>
                    @if ($evento->ruta_imagen)
                        <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen actual">
                    @else
                        <p>No hay imagen actualmente.</p>
                    @endif
                </div>

                <!-- Botón de Envío -->
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="submit-button">
                        Actualizar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection