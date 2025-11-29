@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 mb-6">{{ __('Gestión de Equipos') }}</h2>
            
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Éxito</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse ($equipos as $equipo)
                        <div class="flex items-center justify-between border-b border-gray-200 py-4">
                            <div class="flex items-center space-x-4">
                                @if ($equipo->ruta_imagen)
                                    <img class="h-16 w-16 object-cover rounded-full" src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen del equipo">
                                @else
                                    <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.equipos.show', $equipo) }}" class="text-lg font-semibold text-gray-800 hover:text-indigo-600 hover:underline">
                                        {{ $equipo->nombre }}
                                    </a>
                                    @if($equipo->inscripciones->first() && $equipo->inscripciones->first()->evento)
                                        <p class="text-sm text-gray-600">
                                            Evento: <a href="{{ route('admin.eventos.show', $equipo->inscripciones->first()->evento) }}" class="text-indigo-600 hover:underline">{{ $equipo->inscripciones->first()->evento->nombre }}</a>
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-600">No inscrito en evento activo.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.equipos.edit', $equipo) }}" class="inline-flex items-center px-3 py-1 bg-gray-800 text-white rounded-md hover:bg-gray-700 text-xs font-semibold">
                                    Editar
                                </a>
                                <form action="{{ route('admin.equipos.destroy', $equipo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este equipo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 text-xs font-semibold">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No hay equipos registrados en el sistema.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
