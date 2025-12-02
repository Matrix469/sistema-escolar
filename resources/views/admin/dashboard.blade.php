<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Somos TecNM - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --light-bg: #f8f9fa;
            --border-color: #dee2e6;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .main-content {
            padding: 20px;
            padding-top: 30px;
        }
        
        /* Encabezado azul */
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.2s;
        }
        
        .menu-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .header-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }
        
        .header-logo {
            height: 40px;
            width: auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 5px 10px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .header-logo img {
            max-height: 30px;
            width: auto;
        }
        
        /* Espacio para compensar el header fijo */
        .content-wrapper {
            margin-top: 80px;
        }
        
        .page-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .event-counter {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        
        /* Contenedor de eventos con scroll */
        .events-container {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }
        
        .events-container::-webkit-scrollbar {
            width: 8px;
        }
        
        .events-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .events-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .events-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        .event-card {
            border-left: 5px solid var(--primary-color);
            margin-bottom: 15px;
        }
        
        .event-card .card-body {
            padding: 15px;
        }
        
        .event-date {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .event-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        /* Contenedor de equipos con scroll */
        .teams-container {
            max-height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }
        
        .teams-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .team-card {
            background-color: var(--light-bg);
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .team-name {
            font-weight: 600;
        }
        
        .team-status {
            font-size: 0.9rem;
            color: var(--success-color);
        }
        
        .btn-action {
            padding: 5px 12px;
            font-size: 0.85rem;
            margin-right: 5px;
            border-radius: 5px;
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: #000;
            border: none;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        
        .btn-add {
            background-color: var(--success-color);
            color: white;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .secondary-btn {
            background-color: var(--secondary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .filter-section {
            margin-top: 25px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .status-badge {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .status-active {
            background-color: var(--success-color);
        }
        
        /* Indicador de scroll para eventos */
        .scroll-indicator {
            text-align: center;
            padding: 10px;
            color: var(--secondary-color);
            font-size: 0.9rem;
            display: none;
        }
        
        /* Modal para Agregar/Editar Evento */
        .event-modal .modal-dialog {
            max-width: 700px;
        }
        
        .event-modal .modal-content {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }
        
        .event-modal .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-bottom: none;
            padding: 25px 30px;
        }
        
        .event-modal .modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .event-modal .modal-body {
            padding: 30px;
        }
        
        .event-modal .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .event-modal .form-control,
        .event-modal .form-select {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            transition: border-color 0.3s;
        }
        
        .event-modal .form-control:focus,
        .event-modal .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .textarea-container {
            position: relative;
        }
        
        .textarea-container textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .image-upload-container {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s, background-color 0.3s;
            margin-top: 20px;
        }
        
        .image-upload-container:hover {
            border-color: var(--primary-color);
            background-color: rgba(13, 110, 253, 0.05);
        }
        
        .image-upload-icon {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }
        
        .image-upload-text {
            color: var(--secondary-color);
            font-weight: 500;
            margin-bottom: 5px;
        }
        
        .image-upload-subtext {
            color: #999;
            font-size: 0.9rem;
        }
        
        .image-preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 15px;
            border-radius: 8px;
            display: none;
        }
        
        .tec-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .modal-footer {
            border-top: none;
            padding: 25px 30px;
            gap: 15px;
        }
        
        .btn-modal-cancel {
            background-color: #6c757d;
            color: white;
            padding: 10px 30px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
        }
        
        .btn-modal-save {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 30px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
        }
        
        .btn-modal-cancel:hover {
            background-color: #5a6268;
        }
        
        .btn-modal-save:hover {
            background-color: #0b5ed7;
        }
        
        /* Estado personalizado */
        .estado-container {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        
        .estado-option {
            flex: 1;
            text-align: center;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .estado-option:hover {
            border-color: var(--primary-color);
            background-color: rgba(13, 110, 253, 0.05);
        }
        
        .estado-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(13, 110, 253, 0.1);
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .estado-option i {
            font-size: 1.5rem;
            margin-bottom: 8px;
            display: block;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }
            
            .header-title {
                font-size: 1.2rem;
            }
            
            .content-wrapper {
                margin-top: 70px;
            }
            
            .events-container {
                max-height: 500px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .action-buttons > div {
                display: flex;
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }
            
            .btn-add, .secondary-btn {
                width: 100%;
                justify-content: center;
            }
            
            .event-modal .modal-dialog {
                margin: 10px;
            }
            
            .estado-container {
                flex-direction: column;
            }
        }
        
        @media (max-width: 576px) {
            .events-container {
                max-height: 450px;
            }
            
            .event-modal .modal-body {
                padding: 20px;
            }
        }
    </style>
    @include('admin.styles.evento-style')
</head>
<body>
    <!-- Encabezado azul -->
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="header-title">Somos TecNM - Inicio</h1>
        </div>
        
        <div class="header-logo" id="headerLogo">
            <img src="{{ asset('images/logito.png') }}" alt="Logo Tec">
        </div>
    </header>

    <!-- Contenido principal -->
    <div class="content-wrapper">
        <div class="main-content">
            
            <!-- Eventos en curso -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            Eventos en curso
                            @if($eventosEnCursoCount > 0)
                                <span class="event-counter">{{ $eventosEnCursoCount }} evento(s)</span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($eventosEnCursoCount > 0)
                                <div class="events-container" id="eventsContainer">
                                    @foreach($eventosDashboard as $evento)
                                    <div class="card event-card">
                                        <div class="card-body">
                                            <h5 class="event-title">{{ $evento->nombre }}</h5>
                                            <div class="event-date">
                                                <strong>Inicio:</strong> {{ date('d - m - Y', strtotime($evento->fecha_inicio)) }}
                                            </div>
                                            <div class="event-date">
                                                <strong>Fin:</strong> {{ date('d - m - Y', strtotime($evento->fecha_fin)) }}
                                            </div>
                                            <div class="mt-3">
                                                <button class="btn btn-action btn-edit edit-event-btn" 
                                                        data-id="{{ $evento->id }}"
                                                        data-nombre="{{ $evento->nombre }}"
                                                        data-inicio="{{ $evento->fecha_inicio }}"
                                                        data-fin="{{ $evento->fecha_fin }}"
                                                        data-descripcion="{{ $evento->descripcion ?? '' }}"
                                                        data-cupo="{{ $evento->cupo_max_equipos ?? 10 }}"
                                                        data-imagen="{{ $evento->ruta_imagen ?? '' }}">
                                                    <i class="bi bi-pencil"></i> EDITAR
                                                </button>
                                                <button class="btn btn-action btn-delete" data-event-id="{{ $evento->id }}"><i class="bi bi-trash"></i> ELIMINAR</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if($eventosEnCursoCount > 3)
                                    <div class="scroll-indicator" id="scrollIndicator">
                                        <i class="bi bi-chevron-down"></i> Desliza para ver más eventos
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <p class="text-muted">No hay eventos en curso actualmente.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Equipos activos -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            Equipos activos
                            @if($equiposRegistradosCount > 0)
                                <span class="event-counter">{{ $equiposRegistradosCount }} equipo(s)</span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($equiposRegistradosCount > 0)
                                <div class="teams-container">
                                    @foreach($equiposRegistrados as $equipo)
                                    <div class="team-card">
                                        <div>
                                            <div class="team-name">{{ $equipo->nombre }}</div>
                                            <div class="team-status">
                                                <span class="status-badge status-active"></span>
                                                @if(isset($equipo->miembros_count))
                                                    {{ $equipo->miembros_count }} miembro(s)
                                                @else
                                                    miembros
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-light text-dark">
                                                @if(isset($equipo->evento_nombre))
                                                    {{ $equipo->evento_nombre }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-muted">No hay equipos activos.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="action-buttons">
                <div>
                    <button class="btn-add" id="btnAddEvent"><i class="bi bi-plus-circle"></i> AGREGAR EVENTO</button>
                </div>
                <div>
                    <button class="secondary-btn" id="btnProximosEventos"><i class="bi bi-calendar-week"></i> PRÓXIMOS EVENTOS</button>
                    <button class="secondary-btn" id="btnVerCalendario"><i class="bi bi-calendar-month"></i> VER CALENDARIO</button>
                </div>
            </div>
            
            <!-- Sección de filtros -->
            <div class="filter-section">
                <h5><i class="bi bi-funnel"></i> FILTRAR POR</h5>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="filter-event" class="form-label">Tipo de evento</label>
                        <select class="form-select" id="filter-event">
                            <option selected>Todos los eventos</option>
                            <option value="hackaton">Hackatón</option>
                            <option value="conferencia">Conferencia</option>
                            <option value="taller">Taller</option>
                            <option value="competencia">Competencia</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-status" class="form-label">Estado</label>
                        <select class="form-select" id="filter-status">
                            <option selected>Todos</option>
                            <option value="activo">Activo</option>
                            <option value="proximo">Próximo</option>
                            <option value="finalizado">Finalizado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-team" class="form-label">Equipo</label>
                        <select class="form-select" id="filter-team">
                            <option selected>Todos los equipos</option>
                            <option value="completo">Completos</option>
                            <option value="incompleto">Con cupo disponible</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 text-end">
                        <button class="btn btn-primary" id="btnAplicarFiltros">Aplicar filtros</button>
                        <button class="btn btn-outline-secondary" id="btnLimpiarFiltros">Limpiar filtros</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir el modal desde archivo externo -->
    @include('admin.modals.evento-modal')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JavaScript principal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        });
    </script>
    
    <!-- Incluir scripts del modal -->
    @include('admin.script.evento-scripts')
</body>
</html>