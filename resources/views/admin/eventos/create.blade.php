@extends('layouts.app')

@section('content')

<div class="evento-create-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Gestión de Eventos
        </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Crear Nuevo Evento
            </h2>
        </div>
        
        <div class="main-card">
            @if ($errors->any())
                <div class="alert-error">
                    <strong>¡Ups!</strong> Hubo algunos problemas con tus datos.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.eventos.store') }}" method="POST" enctype="multipart/form-data" id="eventoForm">
                @csrf

                {{-- SECCIÓN: Información del Evento --}}
                <div class="section-card" id="sol1" style="margin-top: 0;">
                    <div class="section-header-crear-evento" id="sol1-1">
                        <div class="section-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="section-title">Información del Evento</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="nombre" class="form-label">Nombre del Evento</label>
                            <input type="text" name="nombre" id="nombre" class="neuro-input" value="{{ old('nombre') }}" required placeholder="Ej: Hackathon 2025">
                        </div>

                        <div>
                            <label for="cupo_max_equipos" class="form-label">Cupo Máximo de Equipos</label>
                            <input type="number" name="cupo_max_equipos" id="cupo_max_equipos" class="neuro-input" value="{{ old('cupo_max_equipos') }}" required min="1" placeholder="Ej: 20">
                        </div>

                        <div>
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="neuro-input" value="{{ old('fecha_inicio') }}" required>
                        </div>

                        <div>
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" class="neuro-input" value="{{ old('fecha_fin') }}" required>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="3" class="neuro-textarea" placeholder="Describe brevemente el evento...">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="mt-5">
                        <label for="ruta_imagen" class="form-label">Imagen del Evento</label>
                        
                        {{-- Área de drag and drop --}}
                        <div class="file-upload-area" id="fileUploadArea">
                            <div class="file-upload-content">
                                <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="file-upload-text">
                                    <strong>Arrastra un archivo aquí o haz clic para seleccionar</strong>
                                </p>
                                <p class="file-upload-hint">
                                    JPG, PNG, GIF - Máximo 2MB
                                </p>
                            </div>
                            <input type="file" 
                                   name="ruta_imagen" 
                                   id="ruta_imagen" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   class="neuro-file"
                                   onchange="handleFileSelect(this)">
                        </div>
                        
                        {{-- Preview del archivo seleccionado --}}
                        <div id="filePreview" class="file-preview">
                            <div class="file-preview-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="file-preview-info">
                                <div class="file-preview-name" id="fileName"></div>
                                <div class="file-preview-size" id="fileSize"></div>
                            </div>
                            <button type="button" class="file-preview-remove" onclick="removeFile()">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: Criterios de Evaluación --}}
                <div class="section-card">
                    <div class="section-header-crear-evento">
                        <div class="section-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="section-title">Criterios de Evaluación</h3>
                    </div>

                    <div class="info-box">
                        <p>
                            <strong>¿Cómo funciona?</strong> Define los aspectos que los jurados evaluarán en cada proyecto. 
                            Cada criterio tiene un <strong>porcentaje</strong> que indica su importancia en la calificación final.
                        </p>
                        <p class="mt-2">
                            <strong>Importante:</strong> La suma de todos los porcentajes debe ser exactamente <strong>100%</strong>.
                            Por ejemplo: Innovación (30%) + Funcionalidad (25%) + Presentación (20%) + Impacto (25%) = 100%
                        </p>
                    </div>

                    <div id="criterios-container">
                        {{-- Criterio 1 (por defecto) --}}
                        <div class="criterio-card" data-criterio="1">
                            <span class="criterio-number">Criterio 1</span>
                            <div class="criterio-grid">
                                <div>
                                    <label class="form-label">Nombre del criterio</label>
                                    <input type="text" name="criterios[0][nombre]" class="neuro-input" required placeholder="Ej: Innovación y Creatividad">
                                </div>
                                <div>
                                    <label class="form-label">Descripción (opcional)</label>
                                    <input type="text" name="criterios[0][descripcion]" class="neuro-input" placeholder="Ej: Originalidad del proyecto">
                                </div>
                                <div>
                                    <label class="form-label">Porcentaje</label>
                                    <div class="ponderacion-input-wrapper">
                                        <input type="number" name="criterios[0][ponderacion]" class="neuro-input ponderacion-input" required min="1" max="100" placeholder="25" oninput="calcularTotal()">
                                        <span class="ponderacion-suffix">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn-add-criterio" onclick="agregarCriterio()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Agregar otro criterio
                    </button>

                    <div class="ponderacion-total">
                        <span class="ponderacion-total-label">Total de porcentajes:</span>
                        <div>
                            <span id="ponderacion-total-value" class="ponderacion-total-value incomplete">0%</span>
                            <span id="ponderacion-status" class="ponderacion-status text-red-500">(Debe ser 100%)</span>
                        </div>
                    </div>
                </div>

                {{-- Botón de Envío --}}
                <div class="flex items-center justify-end mt-8">
                    <button type="submit" class="submit-button" id="submitBtn">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Crear Evento
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let criterioCount = 1;

    // ========== FILE UPLOAD DRAG & DROP ==========
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('ruta_imagen');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    
    // Prevenir comportamiento por defecto en drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    // Highlight en drag over
    ['dragenter', 'dragover'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        fileUploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        fileUploadArea.classList.add('dragover');
    }
    
    function unhighlight() {
        fileUploadArea.classList.remove('dragover');
    }
    
    // Manejar el drop
    fileUploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect(fileInput);
        }
    }
    
    // Manejar selección de archivo
    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const size = (file.size / 1024 / 1024).toFixed(2); // Size in MB
            
            // Actualizar preview
            fileName.textContent = file.name;
            fileSize.textContent = `${size} MB`;
            filePreview.classList.add('show');
            
            // Ocultar área de upload
            fileUploadArea.style.display = 'none';
        }
    }
    
    // Remover archivo
    function removeFile() {
        fileInput.value = '';
        filePreview.classList.remove('show');
        fileUploadArea.style.display = 'block';
    }

    // ========== CRITERIOS DINÁMICOS ==========
    function agregarCriterio() {
        criterioCount++;
        const container = document.getElementById('criterios-container');
        
        const criterioHtml = `
            <div class="criterio-card" data-criterio="${criterioCount}">
                <span class="criterio-number">Criterio ${criterioCount}</span>
                <div class="criterio-grid">
                    <div>
                        <label class="form-label">Nombre del criterio</label>
                        <input type="text" name="criterios[${criterioCount - 1}][nombre]" class="neuro-input" required placeholder="Ej: Funcionalidad">
                    </div>
                    <div>
                        <label class="form-label">Descripción (opcional)</label>
                        <input type="text" name="criterios[${criterioCount - 1}][descripcion]" class="neuro-input" placeholder="Ej: Calidad del código">
                    </div>
                    <div>
                        <label class="form-label">Porcentaje</label>
                        <div class="ponderacion-input-wrapper">
                            <input type="number" name="criterios[${criterioCount - 1}][ponderacion]" class="neuro-input ponderacion-input" required min="1" max="100" placeholder="25" oninput="calcularTotal()">
                            <span class="ponderacion-suffix">%</span>
                        </div>
                    </div>
                    <button type="button" class="btn-remove-criterio" onclick="eliminarCriterio(this)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <p>Eliminar Criterio</p>
                    </button>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', criterioHtml);
        calcularTotal();
    }

    function eliminarCriterio(button) {
        const card = button.closest('.criterio-card');
        card.remove();
        renumerarCriterios();
        calcularTotal();
    }

    function renumerarCriterios() {
        const cards = document.querySelectorAll('.criterio-card');
        cards.forEach((card, index) => {
            card.querySelector('.criterio-number').textContent = `Criterio ${index + 1}`;
            card.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/criterios\[\d+\]/, `criterios[${index}]`));
                }
            });
        });
        criterioCount = cards.length;
    }

    function calcularTotal() {
        const inputs = document.querySelectorAll('.ponderacion-input');
        let total = 0;
        
        inputs.forEach(input => {
            const value = parseInt(input.value) || 0;
            total += value;
        });

        const totalElement = document.getElementById('ponderacion-total-value');
        const statusElement = document.getElementById('ponderacion-status');
        const submitBtn = document.getElementById('submitBtn');

        totalElement.textContent = total + '%';

        if (total === 100) {
            totalElement.className = 'ponderacion-total-value complete';
            statusElement.textContent = '✓ ¡Perfecto!';
            statusElement.className = 'ponderacion-status text-green-600';
            submitBtn.disabled = false;
        } else if (total > 100) {
            totalElement.className = 'ponderacion-total-value incomplete';
            statusElement.textContent = `(Excede por ${total - 100}%)`;
            statusElement.className = 'ponderacion-status text-red-500';
            submitBtn.disabled = true;
        } else {
            totalElement.className = 'ponderacion-total-value incomplete';
            statusElement.textContent = `(Faltan ${100 - total}%)`;
            statusElement.className = 'ponderacion-status text-red-500';
            submitBtn.disabled = true;
        }
    }

    // Calcular al cargar la página
    document.addEventListener('DOMContentLoaded', calcularTotal);
</script>
@endsection