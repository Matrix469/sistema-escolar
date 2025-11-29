@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="{{ route('admin.eventos.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                Detalle del Evento
            </h2>
        </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                @if ($evento->ruta_imagen)
                    <img class="h-64 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento: {{ $evento->nombre }}">
                @endif
                
                <div class="p-6 sm:p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="font-bold text-3xl text-gray-800">{{ $evento->nombre }}</h1>
                            <p class="text-gray-500 text-sm mt-1">
                                Del {{ $evento->fecha_inicio->format('d/m/Y') }} al {{ $evento->fecha_fin->format('d/m/Y') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                            @if ($evento->estado == 'Activo') bg-black text-white
                            @elseif ($evento->estado == 'Próximo') bg-blue-200 text-blue-800
                            @elseif ($evento->estado == 'Cerrado') bg-yellow-200 text-yellow-800
                            @else bg-red-200 text-red-800 @endif">
                            {{ $evento->estado }}
                        </span>
                    </div>

                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Descripción del Evento</h3>
                        <p class="mt-2 text-gray-600">
                            {{ $evento->descripcion ?: 'No hay descripción disponible.' }}
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Columna de Jurados -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Jurados Asignados ({{ $evento->jurados->count() }})
                            </h3>
                            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                <ul class="space-y-3">
                                    @forelse($evento->jurados as $jurado)
                                        <li class="flex items-center space-x-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <a href="{{ route('admin.users.edit', $jurado->user) }}" class="text-gray-700 hover:text-indigo-600 hover:underline">
                                                {{ $jurado->user->nombre }} {{ $jurado->user->app_paterno }}
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-gray-500 text-sm">No hay jurados asignados a este evento.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <!-- Columna de Equipos -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Equipos Inscritos ({{ $evento->inscripciones->count() }} / {{ $evento->cupo_max_equipos }})
                            </h3>
                            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                                <ul class="space-y-3">
                                    @forelse($evento->inscripciones as $inscripcion)
                                        <li class="flex items-center space-x-3">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <a href="{{ route('admin.equipos.show', $inscripcion->equipo) }}" class="text-gray-700 hover:text-indigo-600 hover:underline">
                                                <span class="{{ $inscripcion->puesto_ganador ? 'font-bold' : '' }}">
                                                    @if($inscripcion->puesto_ganador == 1) 🥇 @endif
                                                    @if($inscripcion->puesto_ganador == 2) 🥈 @endif
                                                    @if($inscripcion->puesto_ganador == 3) 🥉 @endif
                                                    {{ $inscripcion->equipo->nombre }}
                                                </span>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="text-gray-500 text-sm">No hay equipos inscritos en este evento.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones de Administrador -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Acciones de Administrador</h3>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <a href="{{ route('admin.eventos.asignar', $evento) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold">
                                Gestionar Jurados
                            </a>

                            @if($evento->estado === 'Próximo')
                                <form action="{{ route('admin.eventos.activar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres activar este evento? Los usuarios podrán inscribirse.');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-semibold">
                                        Activar Evento
                                    </button>
                                </form>
                            @elseif($evento->estado === 'Activo')
                                <form action="{{ route('admin.eventos.finalizar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres finalizar este evento?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                                        Finalizar Evento
                                    </button>
                                </form>
                                <form action="{{ route('admin.eventos.desactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres mover este evento a Próximos? Se cerrarán las inscripciones.');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 font-semibold">
                                        Mover a Próximos
                                    </button>
                                </form>
                            @elseif($evento->estado === 'Finalizado')
                                <form action="{{ route('admin.eventos.reactivar', $evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres reactivar este evento?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold">
                                        Reactivar Evento
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
