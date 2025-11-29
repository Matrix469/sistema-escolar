@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            @if($equipo->inscripciones->first() && $equipo->inscripciones->first()->evento)
                <a href="{{ route('admin.eventos.show', $equipo->inscripciones->first()->evento) }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            @endif
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                Gestión de Equipo: {{ $equipo->nombre }}
            </h2>
        </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 sm:p-8">
                
                <!-- Detalles del Equipo -->
                <div class="border-b pb-6 flex items-center space-x-6">
                    @if ($equipo->ruta_imagen)
                        <img class="h-32 w-32 object-cover rounded-lg" src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo">
                    @else
                        <div class="h-32 w-32 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="font-bold text-3xl text-gray-800">{{ $equipo->nombre }}</h1>
                        @if($inscripcion = $equipo->inscripciones->first())
                            <p class="text-gray-600 text-sm mt-2">
                                Inscrito en: 
                                <a href="{{ route('admin.eventos.show', $inscripcion->evento) }}" class="text-indigo-600 hover:underline">
                                    {{ $inscripcion->evento->nombre }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Lista de Miembros -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900">
                        Miembros del Equipo ({{ $equipo->miembros->count() }})
                    </h3>
                    <div class="mt-4">
                        <ul class="divide-y divide-gray-200">
                            @forelse($equipo->miembros as $miembro)
                                <li class="py-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div>
                                            <p class="text-gray-800 font-semibold">{{ $miembro->user->nombre_completo }}</p>
                                            <p class="text-sm text-gray-500">{{ optional($miembro->user->estudiante)->carrera->nombre ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-xs text-white bg-gray-500 px-2 py-0.5 rounded-full">{{ $miembro->rol->nombre ?? 'Rol no asignado' }}</span>
                                        @if($miembro->es_lider)
                                            <span class="text-xs font-bold uppercase px-2 py-1 bg-yellow-400 text-yellow-900 rounded-full">Líder</span>
                                        @endif
                                        <!-- Botón para Eliminar Miembro -->
                                        <form action="{{ route('admin.miembros.destroy', $miembro) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este miembro del equipo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs">Quitar</button>
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <li class="py-4 text-gray-500">Este equipo no tiene miembros.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Acciones de Administrador -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-medium text-gray-900">Acciones de Administrador</h3>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="{{ route('admin.equipos.edit', $equipo) }}" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 font-semibold">
                            Editar Equipo
                        </a>
                        <form action="{{ route('admin.equipos.destroy', $equipo) }}" method="POST" onsubmit="return confirm('¡Acción irreversible! ¿Estás seguro de que quieres eliminar este equipo por completo? Se eliminará la inscripción y todos sus miembros quedarán libres.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-800 font-semibold">
                                Eliminar Equipo
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
