@extends('layouts.app')

@section('content')

<div class="evento-edit-page py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('admin.eventos.index') }}" class="back-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Volver a Gestión de Eventos
        </a>
        <div class="flex items-center mb-6">
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

            <form action="{{ route('admin.eventos.update', $evento) }}" method="POST" enctype="multipart/form-data"
                  x-data="{
                      criterios: {{ json_encode($evento->criteriosEvaluacion->map(fn($c) => ['nombre' => $c->nombre, 'descripcion' => $c->descripcion ?? '', 'ponderacion' => $c->ponderacion])->values()->toArray()) }},
                      get totalPonderacion() {
                          return this.criterios.reduce((sum, c) => sum + (parseFloat(c.ponderacion) || 0), 0);
                      },
                      agregarCriterio() {
                          this.criterios.push({ nombre: '', descripcion: '', ponderacion: 0 });
                      },
                      eliminarCriterio(index) {
                          if (this.criterios.length > 1) {
                              this.criterios.splice(index, 1);
                          }
                      }
                  }">
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

                <!-- Imagen Actual -->
                @if ($evento->ruta_imagen)
                <div class="image-preview-current">
                    <label class="form-label">Imagen Actual del Evento</label>
                    <div class="current-image-container">
                        <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen actual del evento">
                        <p class="current-image-label">Esta imagen se mantendrá si no subes una nueva</p>
                    </div>
                </div>
                @endif

                <!-- Criterios de Evaluación -->
                <div class="criterios-section">
                    <div class="criterios-header">
                        <h3 class="criterios-title">📋 Criterios de Evaluación</h3>
                        @if($evento->puedeCambiarCriterios())
                            <div class="ponderacion-counter">
                                <span>Total:</span>
                                <span class="ponderacion-value" 
                                      :class="{
                                          'ponderacion-ok': Math.abs(totalPonderacion - 100) < 0.01,
                                          'ponderacion-warning': totalPonderacion > 0 && totalPonderacion < 100,
                                          'ponderacion-error': totalPonderacion > 100
                                      }"
                                      x-text="totalPonderacion.toFixed(0) + '%'">0%</span>
                            </div>
                        @endif
                    </div>

                    @if($evento->puedeCambiarCriterios())
                        <div class="info-box">
                            <p><strong>💡 Ponderación:</strong> Cada criterio tiene un porcentaje que indica su peso en la calificación final. La suma de todos los criterios debe ser exactamente <strong>100%</strong>.</p>
                        </div>

                        <!-- Lista de criterios dinámicos -->
                        <template x-for="(criterio, index) in criterios" :key="index">
                            <div class="criterio-item">
                                <div class="criterio-header">
                                    <span class="criterio-number" x-text="'Criterio #' + (index + 1)"></span>
                                    <button type="button" 
                                            class="remove-criterio-btn" 
                                            x-show="criterios.length > 1"
                                            @click="eliminarCriterio(index)">
                                        ✕ Eliminar
                                    </button>
                                </div>
                                <div class="criterio-row">
                                    <div>
                                        <label class="form-label">Nombre *</label>
                                        <input type="text" 
                                               :name="'criterios[' + index + '][nombre]'"
                                               x-model="criterio.nombre"
                                               class="neuro-input"
                                               placeholder="Ej: Innovación"
                                               required>
                                    </div>
                                    <div>
                                        <label class="form-label">Descripción</label>
                                        <input type="text" 
                                               :name="'criterios[' + index + '][descripcion]'"
                                               x-model="criterio.descripcion"
                                               class="neuro-input"
                                               placeholder="Descripción opcional del criterio">
                                    </div>
                                    <div>
                                        <label class="form-label">Pond. %</label>
                                        <input type="number" 
                                               :name="'criterios[' + index + '][ponderacion]'"
                                               x-model.number="criterio.ponderacion"
                                               class="neuro-input"
                                               min="1"
                                               max="100"
                                               step="1"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Botón agregar criterio -->
                        <button type="button" 
                                class="add-criterio-btn"
                                @click="agregarCriterio()">
                            + Agregar Criterio
                        </button>

                        <!-- Validación visual -->
                        <div x-show="totalPonderacion !== 100" class="mt-4">
                            <p class="text-sm" :class="totalPonderacion > 100 ? 'text-red-600' : 'text-amber-600'" style="font-family: 'Poppins', sans-serif;">
                                <span x-show="totalPonderacion < 100">⚠️ Faltan <span x-text="(100 - totalPonderacion).toFixed(0)"></span>% para completar el 100%</span>
                                <span x-show="totalPonderacion > 100">❌ Excediste por <span x-text="(totalPonderacion - 100).toFixed(0)"></span>% el límite del 100%</span>
                            </p>
                        </div>
                        <div x-show="totalPonderacion === 100" class="mt-4">
                            <p class="text-sm text-green-600" style="font-family: 'Poppins', sans-serif;">✅ ¡Perfecto! Los criterios suman exactamente 100%</p>
                        </div>
                    @else
                        <div class="warning-box">
                            <p><strong>⚠️ Criterios bloqueados:</strong> No se pueden modificar los criterios porque el evento ya no está en estado "Próximo". Solo se pueden editar criterios cuando el evento aún no ha comenzado.</p>
                        </div>

                        <div class="readonly-criterios">
                            @forelse($evento->criteriosEvaluacion as $criterio)
                                <div class="readonly-criterio">
                                    <div>
                                        <span class="readonly-criterio-name">{{ $criterio->nombre }}</span>
                                        @if($criterio->descripcion)
                                            <span class="text-gray-500 text-sm ml-2">- {{ $criterio->descripcion }}</span>
                                        @endif
                                    </div>
                                    <span class="readonly-criterio-pond">{{ $criterio->ponderacion }}%</span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4" style="font-family: 'Poppins', sans-serif;">No hay criterios definidos para este evento.</p>
                            @endforelse
                        </div>
                    @endif
                </div>

                <!-- Botón de Envío -->
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="submit-button"
                            @if($evento->puedeCambiarCriterios())
                            :disabled="Math.abs(totalPonderacion - 100) >= 0.01"
                            :class="{ 'opacity-50 cursor-not-allowed': Math.abs(totalPonderacion - 100) >= 0.01 }"
                            @endif>
                        Actualizar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Elementos del DOM
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
</script>
@endsection