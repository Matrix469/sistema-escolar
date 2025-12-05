@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .user-edit-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .user-edit-page h2,
    .user-edit-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .user-edit-page p,
    .user-edit-page label {
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
        padding: 2rem;
    }
    
    /* Alerts */
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
    .alert-error ul li {
        font-family: 'Poppins', sans-serif;
        color: #991b1b;
    }
    
    .alert-error .font-bold {
        font-weight: 700;
    }
    
    /* Section headers */
    .section-header {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 1.125rem;
        font-weight: 600;
        border-bottom: 2px solid rgba(232, 154, 60, 0.3);
        padding-bottom: 0.5rem;
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-header:first-of-type {
        margin-top: 0;
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
    
    /* Inputs y selects */
    .neuro-input,
    .neuro-select {
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
    }
    
    .neuro-input:focus,
    .neuro-select:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    .neuro-input:read-only {
        background: rgba(229, 231, 235, 0.5);
        cursor: not-allowed;
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

<div class="user-edit-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.users.index') }}" class="back-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver a Usuarios
            </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Editar Usuario: {{ $user->nombre }}
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
                    <p class="font-bold">¡Ups! Hubo algunos problemas con tus datos.</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')

                <h3 class="section-header">Datos Personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="form-label">Nombre(s)</label>
                        <input type="text" name="nombre" id="nombre" class="neuro-input" value="{{ old('nombre', $user->nombre) }}" required>
                    </div>
                    <div>
                        <label for="app_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" name="app_paterno" id="app_paterno" class="neuro-input" value="{{ old('app_paterno', $user->app_paterno) }}" required>
                    </div>
                    <div>
                        <label for="app_materno" class="form-label">Apellido Materno</label>
                        <input type="text" name="app_materno" id="app_materno" class="neuro-input" value="{{ old('app_materno', $user->app_materno) }}">
                    </div>
                    <div>
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" id="email" class="neuro-input" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <h3 class="section-header">Rol del Sistema</h3>
                <div>
                    <label for="id_rol_sistema" class="form-label">Rol</label>
                    <select name="id_rol_sistema" id="id_rol_sistema" class="neuro-select">
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id_rol_sistema }}" {{ $user->id_rol_sistema == $rol->id_rol_sistema ? 'selected' : '' }}>
                                {{ ucfirst($rol->nombre) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                @if($user->estudiante)
                    <h3 class="section-header">Datos de Estudiante</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="numero_control" class="form-label">Número de Control</label>
                            <input type="text" name="numero_control" id="numero_control" class="neuro-input" value="{{ old('numero_control', $user->estudiante->numero_control) }}">
                        </div>
                        <div>
                            <label for="semestre" class="form-label">Semestre</label>
                            <input type="number" name="semestre" id="semestre" class="neuro-input" value="{{ old('semestre', $user->estudiante->semestre) }}">
                        </div>
                        <div>
                            <label for="carrera" class="form-label">Carrera</label>
                            <input type="text" id="carrera" class="neuro-input" value="{{ $user->estudiante->carrera->nombre ?? 'N/A' }}" readonly>
                        </div>
                    </div>
                @elseif($user->jurado)
                     <h3 class="section-header">Datos de Jurado</h3>
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" name="especialidad" id="especialidad" class="neuro-input" value="{{ old('especialidad', $user->jurado->especialidad) }}">
                        </div>
                     </div>
                @endif

                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="submit-button">
                        Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection