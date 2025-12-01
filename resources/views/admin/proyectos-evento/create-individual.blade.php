@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
    
    /* Fondo degradado */
    .proyecto-individual-page {
        background: linear-gradient(to bottom, #FFFDF4, #FFEEE2);
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Textos */
    .proyecto-individual-page h2,
    .proyecto-individual-page h3 {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
    }
    
    .proyecto-individual-page p,
    .proyecto-individual-page label {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
    }
    
    /* Back link */
    .back-link {
        font-family: 'Poppins', sans-serif;
        color: #e89a3c;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    
    .back-link:hover {
        color: #d98a2c;
    }
    
    /* Info box equipo */
    .equipo-info-box {
        background: linear-gradient(135deg, rgba(224, 231, 255, 0.5), rgba(237, 233, 254, 0.5));
        border: 1px solid rgba(99, 102, 241, 0.2);
        border-radius: 15px;
        padding: 1rem;
        margin-top: 1rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        backdrop-filter: blur(10px);
    }
    
    .equipo-info-box h3 {
        font-family: 'Poppins', sans-serif;
        color: #312e81;
        font-weight: 600;
    }
    
    .equipo-info-box p {
        font-family: 'Poppins', sans-serif;
        color: #4338ca;
        font-size: 0.875rem;
    }
    
    .equipo-info-box .codigo-label {
        font-size: 0.875rem;
        color: #4f46e5;
    }
    
    .equipo-info-box .codigo-value {
        font-family: 'Courier New', monospace;
        font-size: 1.125rem;
        font-weight: 700;
        color: #312e81;
    }
    
    /* Main card */
    .main-card {
        background: #FFEEE2;
        border-radius: 20px;
        box-shadow: 8px 8px 16px #e6d5c9, -8px -8px 16px #ffffff;
        padding: 2rem;
    }
    
    /* Labels */
    .form-label {
        font-family: 'Poppins', sans-serif;
        color: #2c2c2c;
        font-size: 0.875rem;
        font-weight: 600;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .required-asterisk {
        color: #ef4444;
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
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
    }
    
    .neuro-input::placeholder,
    .neuro-textarea::placeholder {
        color: #9ca3af;
    }
    
    .neuro-input:focus,
    .neuro-textarea:focus,
    .neuro-file:focus {
        outline: none;
        box-shadow: inset 6px 6px 12px #e6d5c9, inset -6px -6px 12px #ffffff;
    }
    
    /* Helper text */
    .helper-text {
        font-family: 'Poppins', sans-serif;
        color: #6b6b6b;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
    
    /* Error messages */
    .error-message {
        font-family: 'Poppins', sans-serif;
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    /* Divider */
    .section-divider {
        border-top: 1px solid rgba(232, 154, 60, 0.2);
        margin: 2rem 0;
    }
    
    /* Buttons */
    .button-secondary {
        font-family: 'Poppins', sans-serif;
        background: rgba(255, 255, 255, 0.5);
        color: #2c2c2c;
        font-weight: 500;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 4px 4px 8px #e6d5c9, -4px -4px 8px #ffffff;
        transition: all 0.3s ease;
        border: none;
        backdrop-filter: blur(10px);
    }
    
    .button-secondary:hover {
        box-shadow: 6px 6px 12px #e6d5c9, -6px -6px 12px #ffffff;
        transform: translateY(-2px);
    }
    
    .button-primary {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #ffffff;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 4px 4px 8px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
        border: none;
    }
    
    .button-primary:hover {
        box-shadow: 6px 6px 12px rgba(99, 102, 241, 0.4);
        transform: translateY(-2px);
    }
</style>

<div class="proyecto-individual-page py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="back-link mb-2 inline-block">
                ← Volver a Asignaciones
            </a>
            <h2 class="font-semibold text-2xl">
                Asignar Proyecto Individual
            </h2>
            <p class="mt-1">{{ $evento->nombre }}</p>
            
            {{-- Info del equipo --}}
            <div class="equipo-info-box">
                <div class="flex items-center justify-between">
                    <div>
                        <h3>{{ $inscripcion->equipo->nombre }}</h3>
                        <p class="mt-1">
                            {{ $inscripcion->equipo->miembros->count() }} integrantes
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="codigo-label">Código de equipo:</span>
                        <div class="codigo-value">{{ $inscripcion->codigo_acceso_equipo }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-card">
            <form action="{{ route('admin.proyectos-evento.store-individual', [$evento, $inscripcion]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Título --}}
                <div class="mb-6">
                    <label for="titulo" class="form-label">
                        Título del Proyecto <span class="required-asterisk">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo" 
                           value="{{ old('titulo') }}"
                           class="neuro-input"
                           required maxlength="200"
                           placeholder="Ej: Desarrollar sistema de gestión de inventario">
                    @error('titulo')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción Completa --}}
                <div class="mb-6">
                    <label for="descripcion_completa" class="form-label">
                        Descripción Completa
                    </label>
                    <textarea name="descripcion_completa" id="descripcion_completa" rows="6"
                              class="neuro-textarea"
                              placeholder="Describe detalladamente el proyecto específico para este equipo...">{{ old('descripcion_completa') }}</textarea>
                    <p class="helper-text">Puedes usar Markdown para formatear el texto</p>
                    @error('descripcion_completa')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Objetivo --}}
                <div class="mb-6">
                    <label for="objetivo" class="form-label">
                        Objetivo del Proyecto
                    </label>
                    <textarea name="objetivo" id="objetivo" rows="3"
                              class="neuro-textarea"
                              placeholder="¿Qué debe lograr este equipo con este proyecto?">{{ old('objetivo') }}</textarea>
                    @error('objetivo')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Requisitos --}}
                <div class="mb-6">
                    <label for="requisitos" class="form-label">
                        Requisitos Técnicos
                    </label>
                    <textarea name="requisitos" id="requisitos" rows="4"
                              class="neuro-textarea"
                              placeholder="Tecnologías, herramientas, conocimientos específicos para este proyecto...">{{ old('requisitos') }}</textarea>
                    @error('requisitos')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Premios --}}
                <div class="mb-6">
                    <label for="premios" class="form-label">
                        Premios y Reconocimientos
                    </label>
                    <textarea name="premios" id="premios" rows="3"
                              class="neuro-textarea"
                              placeholder="Premios si este equipo gana...">{{ old('premios') }}</textarea>
                    @error('premios')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="section-divider">

                {{-- Archivo de Bases --}}
                <div class="mb-6">
                    <label for="archivo_bases" class="form-label">
                        📄 Archivo de Bases (PDF)
                    </label>
                    <input type="file" name="archivo_bases" id="archivo_bases" 
                           accept=".pdf,.doc,.docx"
                           class="neuro-file">
                    <p class="helper-text">PDF, DOC o DOCX - Máximo 20MB</p>
                    @error('archivo_bases')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Archivo de Recursos --}}
                <div class="mb-6">
                    <label for="archivo_recursos" class="form-label">
                        📦 Recursos Específicos (ZIP)
                    </label>
                    <input type="file" name="archivo_recursos" id="archivo_recursos" 
                           accept=".zip,.rar,.pdf"
                           class="neuro-file">
                    <p class="helper-text">ZIP, RAR o PDF - Máximo 50MB</p>
                    @error('archivo_recursos')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL Externa --}}
                <div class="mb-6">
                    <label for="url_externa" class="form-label">
                        🔗 URL a Recursos Externos
                    </label>
                    <input type="url" name="url_externa" id="url_externa" 
                           value="{{ old('url_externa') }}"
                           class="neuro-input"
                           placeholder="https://drive.google.com/...">
                    <p class="helper-text">Google Drive, Dropbox, etc.</p>
                    @error('url_externa')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex justify-end space-x-3 pt-6" style="border-top: 1px solid rgba(232, 154, 60, 0.2);">
                    <a href="{{ route('admin.proyectos-evento.asignar', $evento) }}" class="button-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="button-primary">
                        Asignar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection