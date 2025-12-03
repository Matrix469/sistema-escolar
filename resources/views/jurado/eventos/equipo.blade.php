@extends('jurado.layouts.app')

@section('content')
<div class="py-8 px-6 lg:px-12" style="background-color: #FFFDF4; min-height: 100vh;">
    <div class="max-w-7xl mx-auto">
        {{-- Sección Superior: Detalles del Equipo e Integrantes --}}
        <div class="flex flex-col lg:flex-row gap-8 mb-8">
            
            {{-- Detalles del Equipo/Proyecto --}}
            <div class="lg:w-1/3">
                <h2 class="text-xl font-semibold mb-4" style="color: #4B4B4B;">Nombre del equipo</h2>
                <div class="rounded-2xl overflow-hidden shadow-md" style="background-color: #FFEFDC;">
                    {{-- Imagen del equipo --}}
                    <div class="h-48 overflow-hidden">
                        @if($equipo->ruta_imagen)
                            <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/team-default.jpg') }}" alt="Imagen del equipo" class="w-full h-full object-cover">
                        @endif
                    </div>
                    {{-- Nombre del proyecto --}}
                    <div class="px-4 py-3" style="background-color: #CE894D;">
                        <h3 class="text-white font-semibold text-lg">{{ $proyecto->nombre ?? 'Sin proyecto' }}</h3>
                    </div>
                    {{-- Información del proyecto --}}
                    <div class="p-4">
                        <p class="text-sm mb-3" style="color: #4B4B4B;">
                            <span class="font-medium">Creación:</span> 
                            <span style="color: #A4AEB7;">{{ $equipo->created_at->translatedFormat('d \\d\\e F \\d\\e\\l Y') }}</span>
                        </p>
                        <div class="rounded-xl p-3" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                            <p class="text-sm" style="color: #4B4B4B;">{{ $proyecto->descripcion_tecnica ?? 'Objetivo del proyecto' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Integrantes --}}
            <div class="lg:w-2/3">
                <h2 class="text-xl font-semibold mb-4" style="color: #4B4B4B;">Integrantes :</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($miembros as $index => $miembro)
                        @php
                            $isLastAndOdd = ($loop->last && $miembros->count() % 2 != 0);
                        @endphp
                        <div class="flex items-center gap-4 rounded-2xl p-4 shadow-sm {{ $isLastAndOdd ? 'md:col-span-2 md:w-1/2 md:mx-auto' : '' }}" style="background-color: #FFEFDC;">
                            <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0" style="background-color: #FFFDF4;">
                                <img src="{{ $miembro->user->foto_perfil_url }}" alt="Foto de {{ $miembro->user->nombre }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-base" style="color: #4B4B4B;">{{ $miembro->user->nombre }} {{ $miembro->user->app_paterno }}</h4>
                                <h4 class="font-semibold text-base mb-2" style="color: #4B4B4B;">{{ $miembro->user->app_materno }}</h4>
                                <p class="text-sm" style="color: #4B4B4B;">
                                    <span class="font-medium">Rol :</span> 
                                    <span style="color: #A4AEB7;">{{ $miembro->rol->nombre ?? 'Sin rol asignado' }}</span>
                                </p>
                                <p class="text-sm" style="color: #4B4B4B;">
                                    <span class="font-medium">Carrera :</span> 
                                    <span style="color: #A4AEB7;">{{ $miembro->user->estudiante->carrera->nombre ?? 'Sin carrera' }}</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-2 text-center py-8">
                            <p style="color: #A4AEB7;">No hay miembros registrados en este equipo para este evento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sección Avances --}}
        <div>
            <h2 class="text-xl font-semibold mb-4" style="color: #4B4B4B;">Avances</h2>
            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Estadísticas de Avances --}}
                <div class="lg:w-2/3">
                    <div class="rounded-2xl p-6 shadow-sm" style="background-color: #FFEFDC;">
                        <div class="grid grid-cols-4 gap-4">
                            {{-- Avances --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #4B4B4B;">{{ $totalAvances }}</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #A4AEB7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span style="color: #4B4B4B;" class="font-medium">Avances</span>
                                </div>
                            </div>
                            {{-- Avances Calificados --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #4B4B4B;">{{ $avancesCalificados }}</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #A4AEB7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span style="color: #4B4B4B;" class="font-medium text-sm">Calificados</span>
                                </div>
                            </div>
                            {{-- Progreso --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #4B4B4B;">{{ $progreso }}%</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #A4AEB7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span style="color: #4B4B4B;" class="font-medium">Porcentaje de tareas</span>
                                </div>
                            </div>
                            {{-- Tareas --}}
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2" style="color: #4B4B4B;">{{ $totalTareas }}</div>
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" style="color: #A4AEB7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    <span style="color: #4B4B4B;" class="font-medium">Tareas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Botón Evaluar Proyecto --}}
                    <div class="mt-4">
                        @if($yaEvaluoProyecto)
                            {{-- Ya evaluado (Finalizada) - mostrar botón ver evaluación --}}
                            <a href="{{ route('jurado.evaluaciones.show', $evaluacionFinalExistente->id_evaluacion) }}" 
                               class="block w-full rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90 text-center"
                               style="background-color: #10B981;">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Ver Mi Evaluación
                                </span>
                            </a>
                            <p class="text-center text-sm mt-2" style="color: #10B981;">
                                Ya has evaluado este proyecto ({{ number_format($evaluacionFinalExistente->calificacion_final, 1) }}/100)
                            </p>
                        @elseif($evaluacionEnBorrador)
                            {{-- Evaluación en borrador - mostrar botón retomar --}}
                            <a href="{{ route('jurado.evaluaciones.create', $inscripcion->id_inscripcion) }}" 
                               class="block w-full rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90 text-center"
                               style="background-color: #F59E0B;">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Retomar Evaluación
                                </span>
                            </a>
                            <p class="text-center text-sm mt-2" style="color: #F59E0B;">
                                Tienes una evaluación en borrador pendiente de finalizar
                            </p>
                        @else
                            <button type="button" 
                                    id="btn-evaluar-proyecto"
                                    onclick="mostrarModalEvaluarProyecto()"
                                    class="w-full rounded-full py-3 text-white font-semibold transition-colors {{ $todosCalificados ? 'hover:opacity-90' : 'opacity-50 cursor-not-allowed' }}"
                                    style="background-color: #F0BC7B;"
                                    {{ $todosCalificados ? '' : 'disabled' }}>
                                Evaluar Proyecto
                            </button>
                            @if(!$todosCalificados && $totalAvances > 0)
                                <p class="text-center text-sm mt-2" style="color: #A4AEB7;">
                                    Debes calificar todos los avances ({{ $avancesCalificados }}/{{ $totalAvances }}) antes de evaluar el proyecto
                                </p>
                            @elseif($totalAvances == 0)
                                <p class="text-center text-sm mt-2" style="color: #A4AEB7;">
                                    No hay avances registrados para este proyecto
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Ver Avances Disponibles --}}
                <div class="lg:w-1/3">
                    <div class="rounded-2xl p-6 shadow-sm" style="background-color: #FFEFDC;">
                        <h3 class="text-base font-semibold text-center mb-4" style="color: #4B4B4B;">Ver Avances Disponibles</h3>
                        
                        @if($yaEvaluoProyecto)
                            {{-- Mensaje de bloqueo cuando ya se evaluó --}}
                            <div class="rounded-xl p-4 mb-4" style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                                <div class="flex items-center gap-3">
                                    <svg class="w-6 h-6 flex-shrink-0" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-sm" style="color: #059669;">Evaluación Finalizada</p>
                                        <p class="text-xs" style="color: #10B981;">Los avances ya no pueden ser modificados</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Selector deshabilitado --}}
                            <div class="mb-4 opacity-60">
                                <div class="relative">
                                    <select disabled class="w-full rounded-xl px-4 py-3 appearance-none cursor-not-allowed" style="background-color: rgba(255, 255, 255, 0.3); border: 1px solid #E5E7EB; color: #A4AEB7;">
                                        <option>{{ $totalAvances }} avance(s) calificado(s)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5" style="color: #A4AEB7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            {{-- Botones deshabilitados --}}
                            <div class="flex gap-2">
                                <button type="button" disabled class="flex-1 rounded-full py-3 text-white font-semibold opacity-50 cursor-not-allowed" style="background-color: #A4AEB7;">
                                    Calificar
                                </button>
                                <button type="button" disabled class="flex-1 rounded-full py-3 font-semibold opacity-50 cursor-not-allowed" style="background-color: #A4AEB7; color: white;">
                                    Reevaluar
                                </button>
                            </div>
                        @else
                            <div class="mb-4">
                                <div class="relative">
                                    <select id="avance-selector" class="w-full rounded-xl px-4 py-3 appearance-none focus:outline-none focus:ring-2" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB; color: #4B4B4B;">
                                        <option value="">Seleccionar avance...</option>
                                        @foreach($avances as $avance)
                                            @php
                                                $yaCalificado = in_array($avance->id_avance, $avancesCalificadosIds);
                                            @endphp
                                            <option value="{{ $avance->id_avance }}" data-calificado="{{ $yaCalificado ? 'true' : 'false' }}">
                                                {!! $avance->titulo ?? 'Avance #' . $loop->iteration !!} {!! $yaCalificado ? ' (Calificado)' : '' !!}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5" style="color: #F0BC7B;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" id="btn-calificar" class="flex-1 rounded-full py-3 text-white font-semibold transition-colors hover:opacity-90" style="background-color: #F0BC7B;">
                                    Calificar
                                </button>
                                <button type="button" id="btn-reevaluar" class="flex-1 rounded-full py-3 font-semibold transition-colors hover:opacity-90 opacity-50 cursor-not-allowed" style="background-color: #CE894D; color: white;" disabled>
                                    Reevaluar
                                </button>
                            </div>
                            <p id="hint-calificar" class="text-center text-xs mt-2 hidden" style="color: #A4AEB7;">
                                Este avance aún no ha sido calificado
                            </p>
                            <p id="hint-reevaluar" class="text-center text-xs mt-2 hidden" style="color: #CE894D;">
                                Este avance ya fue calificado, puedes reevaluarlo
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    @if(!$yaEvaluoProyecto)
    const avancesCalificadosIds = @json($avancesCalificadosIds);
    const selector = document.getElementById('avance-selector');
    const btnCalificar = document.getElementById('btn-calificar');
    const btnReevaluar = document.getElementById('btn-reevaluar');
    const hintCalificar = document.getElementById('hint-calificar');
    const hintReevaluar = document.getElementById('hint-reevaluar');

    // Función para actualizar estado de botones según avance seleccionado
    function actualizarBotones() {
        const avanceId = parseInt(selector.value);
        const yaCalificado = avancesCalificadosIds.includes(avanceId);

        // Ocultar hints primero
        hintCalificar.classList.add('hidden');
        hintReevaluar.classList.add('hidden');

        if (!avanceId) {
            // Sin selección - ambos deshabilitados
            btnCalificar.disabled = true;
            btnCalificar.classList.add('opacity-50', 'cursor-not-allowed');
            btnReevaluar.disabled = true;
            btnReevaluar.classList.add('opacity-50', 'cursor-not-allowed');
        } else if (yaCalificado) {
            // Ya calificado - solo Reevaluar activo
            btnCalificar.disabled = true;
            btnCalificar.classList.add('opacity-50', 'cursor-not-allowed');
            btnReevaluar.disabled = false;
            btnReevaluar.classList.remove('opacity-50', 'cursor-not-allowed');
            hintReevaluar.classList.remove('hidden');
        } else {
            // No calificado - solo Calificar activo
            btnCalificar.disabled = false;
            btnCalificar.classList.remove('opacity-50', 'cursor-not-allowed');
            btnReevaluar.disabled = true;
            btnReevaluar.classList.add('opacity-50', 'cursor-not-allowed');
            hintCalificar.classList.remove('hidden');
        }
    }

    // Escuchar cambios en el selector
    selector.addEventListener('change', actualizarBotones);

    // Inicializar estado al cargar
    actualizarBotones();

    // Función para ir a calificar/reevaluar
    function irACalificar() {
        const avanceId = selector.value;
        if (!avanceId) {
            mostrarModalAlerta('Sin selección', 'Por favor selecciona un avance antes de continuar.');
            return;
        }
        const url = "{{ route('jurado.eventos.calificar_avance', [$evento->id_evento, $equipo->id_equipo, ':avanceId']) }}".replace(':avanceId', avanceId);
        window.location.href = url;
    }

    btnCalificar.addEventListener('click', function() {
        if (!this.disabled) irACalificar();
    });

    btnReevaluar.addEventListener('click', function() {
        if (!this.disabled) {
            mostrarModalConfirmar(
                'Reevaluar Avance',
                '¿Estás seguro de que deseas reevaluar este avance? La calificación anterior será reemplazada.',
                'Sí, reevaluar',
                irACalificar
            );
        }
    });

    function mostrarModalEvaluarProyecto() {
        @if($todosCalificados)
            mostrarModalConfirmar(
                'Evaluar Proyecto',
                '¿Estás seguro de que deseas evaluar el proyecto completo? Ya has calificado todos los avances ({{ $avancesCalificados }}/{{ $totalAvances }}).',
                'Sí, evaluar proyecto',
                function() {
                    window.location.href = "{{ route('jurado.evaluaciones.create', $inscripcion->id_inscripcion ?? 0) }}";
                }
            );
        @else
            mostrarModalAlerta(
                'Avances pendientes',
                'Debes calificar todos los avances antes de poder evaluar el proyecto.\n\nAvances calificados: {{ $avancesCalificados }}/{{ $totalAvances }}'
            );
        @endif
    }
    @endif

    // ========== FUNCIONES DE MODALES ==========

    function mostrarModalAlerta(titulo, mensaje) {
        const modal = crearModal(titulo, mensaje, false);
        document.body.appendChild(modal);
        setTimeout(() => modal.classList.remove('opacity-0'), 10);
    }

    function mostrarModalConfirmar(titulo, mensaje, textoConfirmar, onConfirm) {
        const modal = crearModal(titulo, mensaje, true, textoConfirmar, onConfirm);
        document.body.appendChild(modal);
        setTimeout(() => modal.classList.remove('opacity-0'), 10);
    }

    function crearModal(titulo, mensaje, esConfirmacion, textoConfirmar = 'Confirmar', onConfirm = null) {
        // Contenedor del modal
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 z-50 flex items-center justify-center p-4 opacity-0 transition-opacity duration-300';
        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        overlay.onclick = function(e) {
            if (e.target === overlay) cerrarModal(overlay);
        };

        // Contenido del modal
        const modalContent = document.createElement('div');
        modalContent.className = 'rounded-2xl shadow-xl max-w-md w-full transform scale-95 transition-transform duration-300';
        modalContent.style.backgroundColor = '#FFEFDC';

        // Header
        const header = document.createElement('div');
        header.className = 'px-6 py-4 border-b';
        header.style.borderColor = 'rgba(206, 137, 77, 0.3)';
        header.innerHTML = `
            <div class="flex items-center gap-3">
                ${esConfirmacion ? 
                    `<div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: rgba(240, 188, 123, 0.3);">
                        <svg class="w-5 h-5" style="color: #CE894D;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>` : 
                    `<div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: rgba(240, 188, 123, 0.3);">
                        <svg class="w-5 h-5" style="color: #CE894D;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>`
                }
                <h3 class="text-lg font-semibold" style="color: #4B4B4B;">${titulo}</h3>
            </div>
        `;

        // Body
        const body = document.createElement('div');
        body.className = 'px-6 py-4';
        body.innerHTML = `<p style="color: #4B4B4B; white-space: pre-line;">${mensaje}</p>`;

        // Footer
        const footer = document.createElement('div');
        footer.className = 'px-6 py-4 flex gap-3 justify-end';

        if (esConfirmacion) {
            // Botón Cancelar
            const btnCancelar = document.createElement('button');
            btnCancelar.className = 'px-5 py-2 rounded-full font-semibold transition-colors';
            btnCancelar.style.cssText = 'background-color: rgba(164, 174, 183, 0.3); color: #4B4B4B;';
            btnCancelar.textContent = 'Cancelar';
            btnCancelar.onclick = () => cerrarModal(overlay);
            btnCancelar.onmouseover = () => btnCancelar.style.backgroundColor = 'rgba(164, 174, 183, 0.5)';
            btnCancelar.onmouseout = () => btnCancelar.style.backgroundColor = 'rgba(164, 174, 183, 0.3)';

            // Botón Confirmar
            const btnConfirmar = document.createElement('button');
            btnConfirmar.className = 'px-5 py-2 rounded-full font-semibold text-white transition-colors';
            btnConfirmar.style.backgroundColor = '#F0BC7B';
            btnConfirmar.textContent = textoConfirmar;
            btnConfirmar.onclick = () => {
                cerrarModal(overlay);
                if (onConfirm) onConfirm();
            };
            btnConfirmar.onmouseover = () => btnConfirmar.style.backgroundColor = '#CE894D';
            btnConfirmar.onmouseout = () => btnConfirmar.style.backgroundColor = '#F0BC7B';

            footer.appendChild(btnCancelar);
            footer.appendChild(btnConfirmar);
        } else {
            // Solo botón Aceptar
            const btnAceptar = document.createElement('button');
            btnAceptar.className = 'px-5 py-2 rounded-full font-semibold text-white transition-colors';
            btnAceptar.style.backgroundColor = '#F0BC7B';
            btnAceptar.textContent = 'Aceptar';
            btnAceptar.onclick = () => cerrarModal(overlay);
            btnAceptar.onmouseover = () => btnAceptar.style.backgroundColor = '#CE894D';
            btnAceptar.onmouseout = () => btnAceptar.style.backgroundColor = '#F0BC7B';

            footer.appendChild(btnAceptar);
        }

        modalContent.appendChild(header);
        modalContent.appendChild(body);
        modalContent.appendChild(footer);
        overlay.appendChild(modalContent);

        // Animación de entrada
        setTimeout(() => modalContent.classList.remove('scale-95'), 10);

        return overlay;
    }

    function cerrarModal(overlay) {
        overlay.classList.add('opacity-0');
        const content = overlay.querySelector('div');
        if (content) content.classList.add('scale-95');
        setTimeout(() => overlay.remove(), 300);
    }
</script>
@endsection