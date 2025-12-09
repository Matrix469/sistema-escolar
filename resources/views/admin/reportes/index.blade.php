@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ Vite::asset('resources/css/admin/reportes/reportes.css') }}">
@endpush

@section('content')
<div class="reportes-page">
    <div class="reportes-container">
        <!-- Header -->
        <div class="reportes-header">
            <h1>Generador de Reportes</h1>
            <p>Exporta información detallada del sistema en diferentes formatos</p>
        </div>

        <!-- Alertas de sesión -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Se encontraron errores:</strong>
                    <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Tarjetas de exportación -->
        <div class="export-cards-grid">
            <!-- Reporte Eventos -->
            <div class="export-card">
                <div class="export-card-icon excel">
                    <i class="fas fa-calendar-days"></i>
                </div>
                <h3>Reporte de Eventos</h3>
                <p>Exporta información completa sobre eventos, fechas, participantes y jurados asignados.</p>

                <form action="{{ route('admin.reportes.eventos') }}" method="GET">
                    <div style="margin-bottom: 1rem;">
                        <label for="fecha_inicio_eventos" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--admin-text-primary);">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio_eventos" max="{{ date('Y-m-d') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.95rem;">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label for="fecha_fin_eventos" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--admin-text-primary);">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin_eventos" max="{{ date('Y-m-d') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.95rem;">
                    </div>
                    <div class="export-buttons">
                        <button type="submit" class="btn-export btn-export-excel">
                            <i class="fas fa-file-excel"></i>
                            Exportar Excel
                        </button>
                        <button type="submit" formaction="{{ route('admin.reportes.eventos.pdf') }}" class="btn-export btn-export-pdf">
                            <i class="fas fa-file-pdf"></i>
                            Exportar PDF
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reporte Proyectos -->
            <div class="export-card">
                <div class="export-card-icon excel">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3>Reporte de Proyectos</h3>
                <p>Obtén un listado completo de proyectos inscritos, equipos, categorías y estado actual.</p>

                <form action="{{ route('admin.reportes.proyectos') }}" method="GET">
                    <div style="margin-bottom: 1rem;">
                        <label for="fecha_inicio_proyectos" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--admin-text-primary);">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio_proyectos" max="{{ date('Y-m-d') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.95rem;">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label for="fecha_fin_proyectos" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--admin-text-primary);">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin_proyectos" max="{{ date('Y-m-d') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.95rem;">
                    </div>
                    <div class="export-buttons">
                        <button type="submit" class="btn-export btn-export-excel">
                            <i class="fas fa-file-excel"></i>
                            Exportar Excel
                        </button>
                        <button type="submit" formaction="{{ route('admin.reportes.proyectos.pdf') }}" class="btn-export btn-export-pdf">
                            <i class="fas fa-file-pdf"></i>
                            Exportar PDF
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reporte Equipos -->
            <div class="export-card">
                <div class="export-card-icon excel">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Reporte de Equipos</h3>
                <p>Información detallada de equipos registrados, integrantes, líderes y proyectos asignados.</p>

                <form action="{{ route('admin.reportes.equipos') }}" method="GET">
                    <div style="margin-bottom: 1rem;">
                        <label for="fecha_inicio_equipos" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--admin-text-primary);">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio_equipos" max="{{ date('Y-m-d') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.95rem;">
                    </div>
                    <div style="margin-bottom: 1.5rem;">
                        <label for="fecha_fin_equipos" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--admin-text-primary);">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin_equipos" max="{{ date('Y-m-d') }}" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid var(--admin-border); border-radius: 8px; font-size: 0.95rem;">
                    </div>
                    <div class="export-buttons">
                        <button type="submit" class="btn-export btn-export-excel">
                            <i class="fas fa-file-excel"></i>
                            Exportar Excel
                        </button>
                        <button type="submit" formaction="{{ route('admin.reportes.equipos.pdf') }}" class="btn-export btn-export-pdf">
                            <i class="fas fa-file-pdf"></i>
                            Exportar PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sección de información -->
        <div class="alert alert-info" style="margin-top: 2rem;">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Nota importante:</strong>
                Para asegurar la relevancia de los datos, todos los reportes requieren seleccionar un rango de fechas de <strong>mínimo una semana</strong> (7 días). Los reportes incluirán todos los registros creados dentro del período seleccionado.
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingOverlay = document.getElementById('loadingOverlay');

    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            loadingOverlay.classList.add('active');

            setTimeout(() => {
                loadingOverlay.classList.remove('active');
            }, 5000); // 5 segundos como máximo
        });
    });
});
</script>
@endsection