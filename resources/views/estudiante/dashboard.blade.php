@extends('layouts.prueba')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 mb-6">Mi Panel</h2>

            {{-- * Resumen de Mi Progreso --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                {{-- ! Nivel del Estudiante --}}
                <div class="bg-white rounded-lg p-4 text-center shadow-sm border border-gray-200 transform hover:scale-105 transition-transform duration-200">
                    <div class="text-gray-900">
                        <p class="text-4xl font-bold">Nivel {{ Auth::user()->stats->nivel ?? 1 }}</p>
                        <p class="text-xs mt-2 text-gray-600">{{ number_format(Auth::user()->stats->total_xp ?? 0) }} XP Total</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ Auth::user()->stats->progreso_nivel ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                {{-- ? Eventos Participados --}}
                <div class="bg-white rounded-lg p-4 text-center shadow-sm border border-gray-200 transform hover:scale-105 transition-transform duration-200">
                    <div class="text-gray-900">
                        <svg class="w-8 h-8 mx-auto mb-1 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-3xl font-bold">{{ Auth::user()->stats->eventos_participados ?? 0 }}</p>
                        <p class="text-xs mt-1 text-gray-600">Eventos Participados</p>
                    </div>
                </div>
                
                {{-- ? Habilidades Registradas --}}
                <div class="bg-white rounded-lg p-4 text-center shadow-sm border border-gray-200 transform hover:scale-105 transition-transform duration-200">
                    <div class="text-gray-900">
                        <svg class="w-8 h-8 mx-auto mb-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <p class="text-3xl font-bold">{{ Auth::user()->habilidades->count() }}</p>
                        <p class="text-xs mt-1 text-gray-600">Habilidades</p>
                    </div>
                </div>
                
                {{-- ! Logros Desbloqueados --}}
                <div class="bg-white rounded-lg p-4 text-center shadow-sm border border-gray-200 transform hover:scale-105 transition-transform duration-200">
                    <div class="text-gray-900">
                        <svg class="w-8 h-8 mx-auto mb-1 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        <p class="text-3xl font-bold">{{ Auth::user()->logros->count() }}</p>
                        <p class="text-xs mt-1 text-gray-600">Logros Desbloqueados</p>
                    </div>
                </div>
            </div>

            {{-- ! Widget de Próximas Fechas Importantes --}}
            @if($miInscripcion)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8 transform hover:scale-[1.02] transition-transform duration-200">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-800">Próximas Fechas Importantes</h3>
                    </div>
                    
                    <div class="space-y-3">
                        {{-- ? Fecha de Fin del Evento --}}
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800 text-lg">{{ $miInscripcion->evento->nombre }}</p>
                                    <p class="text-sm text-gray-600">Finaliza el {{ $miInscripcion->evento->fecha_fin->format('d/m/Y') }}</p>
                                </div>
                                @php
                                    $diasRestantes = now()->diffInDays($miInscripcion->evento->fecha_fin, false);
                                    $badgeColor = 'bg-gray-200 text-gray-800'; // Default neutral color
                                    if ($diasRestantes <= 7 && $diasRestantes > 0) {
                                        $badgeColor = 'bg-red-100 text-red-800'; // Upcoming soon
                                    } elseif ($diasRestantes <= 14 && $diasRestantes > 7) {
                                        $badgeColor = 'bg-yellow-100 text-yellow-800'; // Medium urgency
                                    } elseif ($diasRestantes == 0) {
                                        $badgeColor = 'bg-green-100 text-green-800'; // Today
                                    } elseif ($diasRestantes < 0) {
                                        $badgeColor = 'bg-red-200 text-red-800'; // Past due
                                    }
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-bold {{ $badgeColor }}">
                                    @if($diasRestantes > 0)
                                        En {{ $diasRestantes }} {{ $diasRestantes == 1 ? 'día' : 'días' }}
                                    @elseif($diasRestantes == 0)
                                        ¡HOY!
                                    @else
                                        Finalizado
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- TODO Agregar fechas de hitos cuando estén implementados --}}
                        @if($miInscripcion->proyecto && $miInscripcion->proyecto->hitos->where('completado', false)->count() > 0)
                            @php
                                $proximoHito = $miInscripcion->proyecto->hitos->where('completado', false)->sortBy('fecha_limite')->first();
                            @endphp
                            @if($proximoHito && $proximoHito->fecha_limite)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold text-gray-800">Hito: {{ $proximoHito->nombre }}</p>
                                            <p class="text-sm text-gray-600">Fecha límite: {{ $proximoHito->fecha_limite->format('d/m/Y') }}</p>
                                        </div>
                                        @php
                                            $diasHito = now()->diffInDays($proximoHito->fecha_limite, false);
                                            $badgeHito = 'bg-gray-200 text-gray-800'; // Default neutral color
                                            if ($diasHito <= 3 && $diasHito > 0) {
                                                $badgeHito = 'bg-red-100 text-red-800'; // Very urgent
                                            } elseif ($diasHito <= 7 && $diasHito > 3) {
                                                $badgeHito = 'bg-yellow-100 text-yellow-800'; // Urgent
                                            } elseif ($diasHito == 0) {
                                                $badgeHito = 'bg-green-100 text-green-800'; // Today
                                            } elseif ($diasHito < 0) {
                                                $badgeHito = 'bg-red-200 text-red-800'; // Past due
                                            }
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-sm font-bold {{ $badgeHito }}">
                                            @if($diasHito > 0)
                                                En {{ $diasHito }} {{ $diasHito == 1 ? 'día' : 'días' }}
                                            @elseif($diasHito == 0)
                                                ¡HOY!
                                            @else
                                                Vencido
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            {{-- * Sección Principal: Evento Activo y Equipo --}}
            @if ($miInscripcion)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                    
                    <!-- Card de Evento Activo -->
                    <div class="lg:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Mi Evento Activo</h3>
                        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                            <a href="{{ route('estudiante.eventos.show', $miInscripcion->evento) }}">
                                <img class="h-56 w-full object-cover" src="{{ asset('storage/' . $miInscripcion->evento->ruta_imagen) }}" alt="Imagen del evento">
                            </a>
                            <div class="p-6">
                                <h4 class="font-bold text-xl text-gray-800">{{ $miInscripcion->evento->nombre }}</h4>
                                <!-- Aquí podrías añadir la gráfica de avance en el futuro -->
                            </div>
                        </div>
                    </div>

                    <!-- Card de Mi Equipo -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Mi Equipo</h3>
                        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                            @if($miInscripcion->equipo->ruta_imagen)
                                <a href="{{ route('estudiante.equipo.index') }}">
                                    <img class="h-40 w-full object-cover" src="{{ asset('storage/' . $miInscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                                </a>
                            @endif
                            <div class="p-6">
                                <a href="{{ route('estudiante.equipo.index') }}" class="font-bold text-xl text-gray-800 hover:text-indigo-600 transition">
                                    {{ $miInscripcion->equipo->nombre }}
                                </a>
                                
                                @if($miInscripcion->equipo->descripcion)
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ $miInscripcion->equipo->descripcion }}</p>
                                @endif

                                <!-- Barra de Progreso del Proyecto -->
                                <div class="mt-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-semibold text-gray-600">Progreso del Proyecto</span>
                                        <span class="text-xs font-semibold text-indigo-600">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-500" style="width: 0%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 italic">La lógica de progreso se implementará con el sistema de avances</p>
                                </div>

                                <a href="{{ route('estudiante.equipo.index') }}" class="mt-4 inline-flex items-center text-sm text-indigo-600 font-semibold hover:text-indigo-800 transition">
                                    Ver Detalles del Equipo →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 mb-12 rounded-md shadow-sm">
                    <h3 class="font-bold text-lg">¡Bienvenido!</h3>
                    <p class="mt-2">Parece que no estás participando en ningún evento activo en este momento. ¡Explora los próximos eventos para unirte a la acción!</p>
                </div>
            @endif


            <!-- Sección de Eventos Disponibles -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Eventos Disponibles</h3>
                <div class="flex overflow-x-auto space-x-6 pb-4">
                    @forelse ($eventosDisponibles as $evento)
                        <div class="flex-shrink-0 w-80 bg-white overflow-hidden shadow-lg rounded-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                            <a href="{{ route('estudiante.eventos.show', $evento) }}">
                                <img class="h-40 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                            </a>
                            <div class="p-4">
                                <h4 class="font-semibold text-lg text-gray-800 truncate">{{ $evento->nombre }}</h4>
                                <p class="text-gray-500 text-sm mt-1">
                                    Inicia: {{ $evento->fecha_inicio->format('d M, Y') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 text-center py-10 w-full">
                            <p class="text-gray-500">No hay eventos disponibles en este momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sección de Constancias (Estructura para implementación futura) -->
            @if ($miInscripcion)
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Mis Constancias</h3>
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg p-8">
                        <div class="text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Constancias no disponibles aún</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Las constancias se generarán automáticamente cuando se complete el proyecto y se realice la evaluación final por los jurados.
                            </p>
                            <p class="mt-1 text-xs text-gray-400 italic">
                                Esta funcionalidad se implementará con el sistema de evaluaciones y proyectos.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
