@extends('layouts.app')

@section('content')

<div class="editar-equipo-page py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('estudiante.equipo.show-detalle', $equipo) }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a {{ $equipo->nombre }}
        </a>
        <div class="flex items-center mb-6">
            <h2 class="font-semibold text-xl ml-2">
                Editar Equipo: {{ $equipo->nombre }}
            </h2>
        </div>
        
        <div class="main-card">
            @if (session('error'))
                <div class="alert-error" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error" role="alert">
                    <p class="font-bold">¡Ups! Hubo algunos problemas.</p>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('estudiante.equipo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Imagen del Equipo -->
                <div class="mb-6">
                    <label class="form-label mb-3">Imagen del Equipo</label>
                    
                    <div class="image-upload-container" id="dropZone">
                        <input type="file" name="ruta_imagen" id="ruta_imagen" accept="image/jpeg,image/png,image/jpg,image/gif" class="hidden-input">
                        
                        <div class="upload-preview" id="previewContainer">
                            @if($equipo->ruta_imagen)
                                <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen actual" id="previewImage">
                                <div class="preview-overlay">
                                    <span>Click o arrastra para cambiar</span>
                                </div>
                            @else
                                <div class="upload-placeholder" id="uploadPlaceholder">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p>Click o arrastra una imagen aquí</p>
                                    <span>JPG, PNG, GIF - Máx 2MB</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <p class="help-text mt-2">La imagen representa visualmente a tu equipo en el sistema.</p>
                </div>

                <!-- Nombre del Equipo -->
                <div>
                    <label for="nombre" class="form-label">
                        Nombre del Equipo
                        <span class="character-count">
                            <span id="nombre-count">{{ strlen(old('nombre', $equipo->nombre)) }}</span>/100
                        </span>
                    </label>
                    <input type="text" name="nombre" id="nombre" class="neuro-input"
                           value="{{ old('nombre', $equipo->nombre) }}" required maxlength="100" autofocus
                           oninput="updateCharCount('nombre', 100)">
                    <p class="help-text">Este es el nombre con el que tu equipo será identificado en el evento.</p>
                </div>

                <!-- Descripción del Equipo -->
                <div class="mt-4">
                    <label for="descripcion" class="form-label">
                        Descripción del Equipo (Opcional)
                        <span class="character-count">
                            <span id="descripcion-count">{{ strlen(old('descripcion', $equipo->descripcion ?? '')) }}</span>/500
                        </span>
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="neuro-textarea"
                              placeholder="Describe tu equipo, proyecto o lo que buscan lograr..."
                              maxlength="500" oninput="updateCharCount('descripcion', 500)">{{ old('descripcion', $equipo->descripcion ?? '') }}</textarea>
                    <p class="help-text">Máximo 500 caracteres. Esta descripción ayudará a otros estudiantes a conocer tu equipo.</p>
                </div>

                <!-- Botones de Acción -->
                <div class="action-buttons">
                    <a href="{{ route('estudiante.equipo.index') }}" class="btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-submit">
                        Actualizar Equipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateCharCount(fieldId, maxLength) {
    const field = document.getElementById(fieldId);
    const countElement = document.getElementById(fieldId + '-count');
    const currentLength = field.value.length;

    countElement.textContent = currentLength;

    if (currentLength > maxLength) {
        countElement.style.color = '#ef4444';
    } else if (currentLength > maxLength * 0.9) {
        countElement.style.color = '#f59e0b';
    } else {
        countElement.style.color = '#6b7280';
    }
}

// Initialize character counts on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCharCount('nombre', 100);
    updateCharCount('descripcion', 500);
    
    // Drag and drop functionality
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('ruta_imagen');
    const previewContainer = document.getElementById('previewContainer');
    
    // Click to upload
    dropZone.addEventListener('click', () => fileInput.click());
    
    // Drag events
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
    });
    
    // Handle drop
    dropZone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFile(files[0]);
        }
    });
    
    // Handle file input change
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });
    
    function handleFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('Por favor selecciona un archivo de imagen.');
            return;
        }
        
        if (file.size > 2 * 1024 * 1024) {
            alert('La imagen no debe superar los 2MB.');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = (e) => {
            previewContainer.innerHTML = `
                <img src="${e.target.result}" alt="Preview" id="previewImage">
                <div class="preview-overlay">
                    <span>Click o arrastra para cambiar</span>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
});
</script>

<style>
.character-count {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: normal;
    margin-left: 0.5rem;
}

.form-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#nombre-count, #descripcion-count {
    font-weight: 600;
    transition: color 0.2s ease;
}

/* Image Upload Styles */
.image-upload-container {
    position: relative;
    width: 100%;
    min-height: 200px;
    border: 2px dashed rgba(232, 154, 60, 0.3);
    border-radius: 16px;
    background: rgba(232, 154, 60, 0.03);
    cursor: pointer;
    transition: all 0.3s ease;
    overflow: hidden;
}

.image-upload-container:hover {
    border-color: #e89a3c;
    background: rgba(232, 154, 60, 0.08);
}

.image-upload-container.dragover {
    border-color: #e89a3c;
    background: rgba(232, 154, 60, 0.15);
    transform: scale(1.01);
}

.hidden-input {
    position: absolute;
    width: 0;
    height: 0;
    opacity: 0;
}

.upload-preview {
    position: relative;
    width: 100%;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-preview img {
    max-width: 100%;
    max-height: 280px;
    object-fit: contain;
    border-radius: 12px;
}

.preview-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 12px;
}

.upload-preview:hover .preview-overlay {
    opacity: 1;
}

.preview-overlay span {
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 0.75rem 1.5rem;
    background: rgba(232, 154, 60, 0.9);
    border-radius: 8px;
}

.upload-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    text-align: center;
}

.upload-placeholder svg {
    width: 60px;
    height: 60px;
    color: #e89a3c;
    margin-bottom: 1rem;
    opacity: 0.7;
}

.upload-placeholder p {
    font-weight: 600;
    color: #2c2c2c;
    margin: 0 0 0.5rem 0;
}

.upload-placeholder span {
    font-size: 0.8rem;
    color: #9ca3af;
}
</style>

@endsection