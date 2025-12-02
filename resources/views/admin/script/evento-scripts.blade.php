{{-- resources/views/partials/evento-scripts.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
        const eventForm = document.getElementById('eventForm');
        const modalTitle = document.getElementById('modalTitle');
        const imageUploadContainer = document.getElementById('imageUploadContainer');
        const imagenInput = document.getElementById('imagen');
        const imagePreview = document.getElementById('imagePreview');
        
        // Botón agregar evento
        document.getElementById('btnAddEvent').addEventListener('click', function() {
            resetForm();
            modalTitle.textContent = '#SomosTecNM - Agregar evento';
            eventForm.action = "{{ route('admin.eventos.store') }}";
            eventForm.method = "POST";
            eventModal.show();
        });
        
        // Botón editar evento
        document.addEventListener('click', function(e) {
            if (e.target.closest('.edit-event-btn')) {
                const button = e.target.closest('.edit-event-btn');
                const eventId = button.getAttribute('data-id');
                const nombre = button.getAttribute('data-nombre');
                const inicio = button.getAttribute('data-inicio');
                const fin = button.getAttribute('data-fin');
                const descripcion = button.getAttribute('data-descripcion');
                const cupoMaxEquipos = button.getAttribute('data-cupo') || 10;
                const imagen = button.getAttribute('data-imagen');
                
                // Rellenar el formulario
                document.getElementById('eventId').value = eventId;
                document.getElementById('nombre').value = nombre;
                document.getElementById('fecha_inicio').value = inicio.split(' ')[0];
                document.getElementById('fecha_fin').value = fin.split(' ')[0];
                document.getElementById('descripcion').value = descripcion;
                document.getElementById('cupo_max_equipos').value = cupoMaxEquipos;
                
                // Configurar acción del formulario para actualizar
                eventForm.action = `/admin/eventos/${eventId}`;
                eventForm.method = "POST";
                
                // Agregar campo _method para PUT
                let methodInput = document.getElementById('_method');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.id = '_method';
                    eventForm.appendChild(methodInput);
                }
                methodInput.value = 'PUT';
                
                // Mostrar imagen si existe
                if (imagen) {
                    document.getElementById('imagenActual').value = imagen;
                    imagePreview.src = '/storage/' + imagen;
                    imagePreview.style.display = 'block';
                }
                
                modalTitle.textContent = '#SomosTecNM - Editar evento';
                eventModal.show();
            }
        });
        
        // Subida de imagen
        imageUploadContainer.addEventListener('click', function() {
            imagenInput.click();
        });
        
        imagenInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Botón eliminar evento
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-delete')) {
                const button = e.target.closest('.btn-delete');
                const eventId = button.getAttribute('data-event-id');
                const eventName = button.closest('.event-card').querySelector('.event-title').textContent;
                
                if (confirm(`¿Estás seguro de que deseas eliminar el evento "${eventName}"?`)) {
                    // Crear formulario para eliminar
                    const deleteForm = document.createElement('form');
                    deleteForm.method = 'POST';
                    deleteForm.action = `/admin/eventos/${eventId}`;
                    
                    // Agregar CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    deleteForm.appendChild(csrfInput);
                    
                    // Agregar método DELETE
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    deleteForm.appendChild(methodInput);
                    
                    // Enviar formulario
                    document.body.appendChild(deleteForm);
                    deleteForm.submit();
                }
            }
        });
        
        // Envío del formulario
        eventForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const saveBtn = this.querySelector('.btn-modal-save');
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
            saveBtn.disabled = true;
            
            // Crear FormData
            const formData = new FormData(this);
            
            // Enviar petición
            fetch(this.action, {
                method: this.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    const eventId = document.getElementById('eventId').value;
                    alert(eventId ? 'Evento actualizado exitosamente.' : 'Evento creado exitosamente.');
                    eventModal.hide();
                    
                    // Recargar la página para ver los cambios
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.eventos.index') }}";
                    }, 1500);
                } else {
                    // Mostrar error de validación
                    let errorMessage = 'Ocurrió un error: ';
                    if (data.errors) {
                        Object.values(data.errors).forEach(err => {
                            errorMessage += err.join(', ') + ' ';
                        });
                    } else if (data.message) {
                        errorMessage += data.message;
                    }
                    alert(errorMessage);
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'Ocurrió un error al guardar el evento.';
                if (error.errors) {
                    Object.values(error.errors).forEach(err => {
                        errorMessage += err.join(', ') + ' ';
                    });
                } else if (error.message) {
                    errorMessage += ' ' + error.message;
                }
                alert(errorMessage);
                saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
            });
        });
        
        // Función para resetear el formulario
        function resetForm() {
            eventForm.reset();
            document.getElementById('eventId').value = '';
            document.getElementById('imagenActual').value = '';
            imagePreview.src = '';
            imagePreview.style.display = 'none';
            
            // Remover input _method si existe
            const methodInput = document.getElementById('_method');
            if (methodInput) {
                methodInput.remove();
            }
            
            // Establecer valores por defecto
            const today = new Date().toISOString().split('T')[0];
            const nextWeek = new Date();
            nextWeek.setDate(nextWeek.getDate() + 7);
            const nextWeekStr = nextWeek.toISOString().split('T')[0];
            
            document.getElementById('fecha_inicio').value = today;
            document.getElementById('fecha_fin').value = nextWeekStr;
            document.getElementById('cupo_max_equipos').value = 10;
        }
        
        // Configurar validación de fechas
        const fechaInicioInput = document.getElementById('fecha_inicio');
        const fechaFinInput = document.getElementById('fecha_fin');
        
        if (fechaInicioInput && fechaFinInput) {
            fechaInicioInput.addEventListener('change', function() {
                const fechaInicio = new Date(this.value);
                const fechaFin = new Date(fechaFinInput.value);
                
                // Si la fecha de fin es anterior a la de inicio, ajustarla
                if (fechaFin < fechaInicio) {
                    fechaFinInput.value = this.value;
                }
                
                // Establecer fecha mínima para fecha_fin
                fechaFinInput.min = this.value;
            });
        }
    });
</script>