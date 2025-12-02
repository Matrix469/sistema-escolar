{{-- resources/views/modals/evento-modal.blade.php --}}

<!-- Modal para Agregar/Editar Evento -->
<div class="modal fade event-modal" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">#SomosTecNM - Agregar/Editar evento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="eventForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="eventId" name="id">
                <input type="hidden" name="imagen_actual" id="imagenActual">
                
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="fecha_inicio" class="form-label">Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="fecha_fin" class="form-label">Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="cupo_max_equipos" class="form-label">Cupo máximo de equipos</label>
                            <input type="number" class="form-control" id="cupo_max_equipos" name="cupo_max_equipos" min="1" value="10" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <div class="textarea-container">
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describe el evento..."></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Imagen del evento</label>
                            <div class="image-upload-container" id="imageUploadContainer">
                                <div class="image-upload-icon">
                                    <i class="bi bi-image"></i>
                                </div>
                                <div class="image-upload-text">SELECCIONAR IMAGEN</div>
                                <div class="image-upload-subtext">Haz clic para seleccionar una imagen</div>
                                <input type="file" id="imagen" name="ruta_imagen" accept="image/*" style="display: none;">
                                <img id="imagePreview" class="image-preview" src="" alt="Vista previa">
                            </div>
                        </div>
                    </div>
                    
                    <div class="tec-footer">
                        TECNOLÓGICO NACIONAL DE MÉXICO.
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn-modal-save">GUARDAR</button>
                </div>
            </form>
        </div>
    </div>
</div>