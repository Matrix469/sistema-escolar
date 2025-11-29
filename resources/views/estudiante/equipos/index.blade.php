@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="{{ route('estudiante.eventos.show', $evento) }}" class="text-gray-800 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div class="flex-grow flex justify-between items-center ml-2">
                <h2 class="font-semibold text-xl text-gray-800 mb-6">
                    Equipos para: {{ $evento->nombre }}
                </h2>
                @if(!$miInscripcionDeEquipoId)
                <a href="{{ route('estudiante.eventos.equipos.create', $evento) }}" class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 font-semibold text-xs uppercase">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Crear Equipo
                </a>
                @endif
            </div>
        </div>

            <!-- Filtros y Búsqueda -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-8">
                <form action="{{ route('estudiante.eventos.equipos.index', $evento) }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" name="search" placeholder="Buscar por nombre de equipo..." value="{{ request('search') }}" class="block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Todos los equipos</option>
                                <option value="Incompleto" {{ request('status') == 'Incompleto' ? 'selected' : '' }}>Con lugares disponibles</option>
                                <option value="Completo" {{ request('status') == 'Completo' ? 'selected' : '' }}>Equipos llenos</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="submit" class="w-full justify-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-black">Filtrar</button>
                            <a href="{{ route('estudiante.eventos.equipos.index', $evento) }}" class="w-full text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Limpiar</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Lista de Equipos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($inscripciones as $inscripcion)
                    <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                        <div class="p-4 flex flex-col justify-between h-full">
                            <a href="{{ route('estudiante.eventos.equipos.show', [$evento, $inscripcion->equipo]) }}" class="hover:opacity-80 transition">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="flex-shrink-0">
                                        @if ($inscripcion->equipo->ruta_imagen)
                                            <img class="h-16 w-16 rounded-full object-cover" src="{{ asset('storage/' . $inscripcion->equipo->ruta_imagen) }}" alt="Imagen del equipo">
                                        @else
                                            <span class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-lg text-gray-800 truncate">{{ $inscripcion->equipo->nombre }}</h4>
                                        <p class="text-sm text-gray-500">{{ $inscripcion->equipo->miembros->count() }} Miembros</p>
                                    </div>
                                </div>
                            </a>

                            <!-- Botón de Solicitud de Unión -->
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                @if ($evento->estado === 'Activo' && $inscripcion->status_registro !== 'Completo')
                                
                                    @if ($miInscripcionDeEquipoId)
                                        {{-- El usuario YA es miembro de un equipo en este evento --}}
                                        @if ($miInscripcionDeEquipoId === $inscripcion->equipo->id_equipo)
                                            <span class="w-full text-center px-4 py-2 bg-green-200 text-green-800 rounded-md font-semibold text-sm">✔ Estás en este equipo</span>
                                        @else
                                            <span class="text-xs text-gray-500 font-semibold">Ya eres miembro de otro equipo.</span>
                                        @endif

                                    @else
                                        {{-- El usuario NO es miembro de ningún equipo, revisamos sus solicitudes --}}
                                        @if ($solicitudesDelEstudiante->has($inscripcion->equipo->id_equipo))
                                            @php
                                                $solicitudActual = $solicitudesDelEstudiante[$inscripcion->equipo->id_equipo];
                                            @endphp
                                            @if ($solicitudActual->status === 'pendiente')
                                                <span class="text-xs text-yellow-600 font-semibold">Solicitud enviada (pendiente).</span>
                                            @elseif ($solicitudActual->status === 'rechazada')
                                                <div class="text-center">
                                                    <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold text-sm">
                                                            Volver a solicitar
                                                        </button>
                                                    </form>
                                                    <p class="text-xs text-red-500 mt-1">Tu solicitud anterior fue rechazada.</p>
                                                </div>
                                            @endif
                                        @else
                                            {{-- No es miembro y no hay solicitud, puede unirse --}}
                                            <form action="{{ route('estudiante.solicitudes.store', $inscripcion->equipo) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold text-sm">
                                                    Solicitar Unirme
                                                </button>
                                            </form>
                                        @endif
                                    @endif

                                @elseif ($inscripcion->status_registro === 'Completo')
                                    <span class="text-xs text-red-600 font-semibold">Equipo completo.</span>
                                @else
                                    <span class="text-xs text-gray-500">Inscripciones no disponibles aún.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <p class="text-gray-500">No hay equipos inscritos para este evento todavía. ¡Sé el primero!</p>
                    </div>
                @endforelse
            </div>

             <div class="mt-8">
                {{ $inscripciones->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection
