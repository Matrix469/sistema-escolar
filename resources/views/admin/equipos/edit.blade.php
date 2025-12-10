@extends('layouts.app')

@section('title', 'Editar Equipo')

@section('content')

<div class="edit-equipo-modern">
    <div class="container-edit">
        
        {{-- Back Link --}}
        @if($evento)
            <a href="{{ route('admin.eventos.show', $evento) }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver al Evento
            </a>
        @else
            <a href="{{ route('admin.equipos.show', $equipo) }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver al Equipo
            </a>
        @endif

        {{-- Header --}}
        <div class="page-header">
            <div class="header-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="header-text">
                <h1>Editar Equipo</h1>
                <p>{{ $equipo->nombre }}</p>
            </div>
        </div>
        
        {{-- Main Form Card --}}
        <div class="form-card">
            @if (session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>¡Ups! Hubo algunos problemas:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.equipos.update', $equipo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nombre del Equipo --}}
                <div class="form-group">
                    <label for="nombre" class="form-label">
                        <i class="fas fa-users"></i> Nombre del Equipo
                    </label>
                    <input type="text" 
                           name="nombre" 
                           id="nombre" 
                           class="form-input" 
                           value="{{ old('nombre', $equipo->nombre) }}" 
                           maxlength="85"
                           placeholder="Nombre del equipo"
                           required>
                    <span class="input-hint">Máximo 85 caracteres</span>
                </div>

                {{-- Imagen del Equipo --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-image"></i> Imagen del Equipo (Opcional)
                    </label>
                    
                    {{-- Imagen actual --}}
                    @if($equipo->ruta_imagen)
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="{{ $equipo->nombre }}">
                            <span class="image-label">Imagen actual</span>
                        </div>
                    @endif
                    
                    {{-- Área de subida --}}
                    <div class="file-upload-area" id="fileUploadArea">
                        <div class="upload-content">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p><strong>Arrastra una imagen aquí</strong></p>
                            <p class="upload-hint">o haz clic para seleccionar</p>
                            <span class="upload-formats">JPG, PNG, GIF - Máximo 2MB</span>
                        </div>
                        <input type="file" 
                               name="ruta_imagen" 
                               id="ruta_imagen" 
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               onchange="handleFileSelect(this)">
                    </div>
                    
                    {{-- Preview del archivo --}}
                    <div id="filePreview" class="file-preview">
                        <div class="preview-info">
                            <i class="fas fa-image"></i>
                            <span id="fileName"></span>
                            <span id="fileSize" class="file-size"></span>
                        </div>
                        <button type="button" class="remove-file" onclick="removeFile()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="form-actions">
                    @if($evento)
                        <a href="{{ route('admin.eventos.show', $evento) }}" class="btn btn-cancel">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    @else
                        <a href="{{ route('admin.equipos.show', $equipo) }}" class="btn btn-cancel">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    @endif
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

.edit-equipo-modern {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 2rem 1rem;
    font-family: 'Inter', -apple-system, sans-serif;
}

.container-edit {
    max-width: 700px;
    margin: 0 auto;
}

/* Back Link */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #475569;
    font-size: 0.9rem;
    font-weight: 500;
    text-decoration: none;
    margin-bottom: 1.5rem;
    padding: 0.5rem 1rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.2s;
}
.back-link:hover {
    color: #1e40af;
    background: #eff6ff;
    transform: translateX(-3px);
}

/* Header */
.page-header {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    margin-bottom: 2rem;
    padding: 1.5rem 2rem;
    background: linear-gradient(135deg, #1e3a5f, #1e40af);
    border-radius: 16px;
    color: white;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.15);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.header-text h1 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}
.header-text p {
    margin: 0.35rem 0 0;
    opacity: 0.85;
    font-size: 0.95rem;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

/* Alerts */
.alert {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}
.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}
.alert-error i {
    color: #dc2626;
    margin-top: 0.15rem;
}
.alert ul {
    margin: 0.5rem 0 0 1.25rem;
    padding: 0;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.75rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.75rem;
}
.form-label i {
    color: #3b82f6;
}

.form-input {
    width: 100%;
    padding: 0.875rem 1rem;
    font-size: 1rem;
    color: #111827;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.2s;
}
.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
.form-input::placeholder {
    color: #94a3b8;
}

.input-hint {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: #64748b;
}

/* Current Image */
.current-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f1f5f9;
    border-radius: 12px;
}
.current-image img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    border: 3px solid white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.image-label {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 500;
}

/* File Upload */
.file-upload-area {
    position: relative;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: #fafbfc;
}
.file-upload-area:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}
.file-upload-area.dragover {
    border-color: #3b82f6;
    background: #dbeafe;
}

.upload-content i {
    font-size: 2.5rem;
    color: #94a3b8;
    margin-bottom: 0.75rem;
}
.upload-content p {
    margin: 0;
    color: #334155;
}
.upload-hint {
    color: #64748b !important;
    font-size: 0.875rem !important;
}
.upload-formats {
    display: block;
    margin-top: 0.75rem;
    font-size: 0.75rem;
    color: #94a3b8;
    background: #e2e8f0;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    display: inline-block;
}

.file-upload-area input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}

/* File Preview */
.file-preview {
    display: none;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem;
    background: #f0fdf4;
    border: 1px solid #86efac;
    border-radius: 10px;
    margin-top: 1rem;
}
.file-preview.show {
    display: flex;
}

.preview-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #166534;
}
.preview-info i {
    font-size: 1.25rem;
}
.file-size {
    font-size: 0.8rem;
    color: #22c55e;
}

.remove-file {
    background: #fef2f2;
    border: none;
    color: #dc2626;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.remove-file:hover {
    background: #fee2e2;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel {
    background: #f1f5f9;
    color: #475569;
}
.btn-cancel:hover {
    background: #e2e8f0;
}

.btn-submit {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
}

/* Responsive */
@media (max-width: 640px) {
    .page-header {
        flex-direction: column;
        text-align: center;
    }
    .form-actions {
        flex-direction: column;
    }
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
const fileUploadArea = document.getElementById('fileUploadArea');
const fileInput = document.getElementById('ruta_imagen');
const filePreview = document.getElementById('filePreview');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    fileUploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    fileUploadArea.addEventListener(eventName, () => fileUploadArea.classList.add('dragover'), false);
});

['dragleave', 'drop'].forEach(eventName => {
    fileUploadArea.addEventListener(eventName, () => fileUploadArea.classList.remove('dragover'), false);
});

fileUploadArea.addEventListener('drop', function(e) {
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFileSelect(fileInput);
    }
}, false);

function handleFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const size = (file.size / 1024 / 1024).toFixed(2);
        
        if (parseFloat(size) > 2) {
            alert('El archivo excede el tamaño máximo de 2MB');
            removeFile();
            return;
        }
        
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Solo se permiten archivos JPG, PNG o GIF');
            removeFile();
            return;
        }
        
        fileName.textContent = file.name;
        fileSize.textContent = `(${size} MB)`;
        filePreview.classList.add('show');
        fileUploadArea.style.display = 'none';
    }
}

function removeFile() {
    fileInput.value = '';
    filePreview.classList.remove('show');
    fileUploadArea.style.display = 'block';
}
</script>

@endsection