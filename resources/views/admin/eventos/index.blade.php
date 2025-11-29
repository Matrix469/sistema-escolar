@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                {{ __('Gestión de Eventos') }}
            </h2>
            <a href="{{ route('admin.eventos.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Crear Nuevo Evento
            </a>
        </div>
            
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Éxito</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Filtros y Búsqueda -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-8">
                <form action="{{ route('admin.eventos.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <label for="search" class="sr-only">Buscar</label>
                            <input type="text" name="search" id="search" placeholder="Buscar por nombre de evento..." value="{{ request('search') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="status" class="sr-only">Estado</label>
                            <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos los estados</option>
                                <option value="Próximo" {{ request('status') == 'Próximo' ? 'selected' : '' }}>Próximo</option>
                                <option value="Activo" {{ request('status') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Cerrado" {{ request('status') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                <option value="Finalizado" {{ request('status') == 'Finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="submit" class="w-full justify-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-black">Filtrar</button>
                            <a href="{{ route('admin.eventos.index') }}" class="w-full text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Limpiar</a>
                        </div>
                    </div>
                </form>
            </div>

            @php
                $statusOrder = ['Activo', 'Próximo', 'Cerrado', 'Finalizado'];
            @endphp

            @foreach ($statusOrder as $status)
                @if (isset($eventosAgrupados[$status]) && $eventosAgrupados[$status]->isNotEmpty())
                    <h3 class="font-bold text-2xl mb-4 mt-8">{{ $status }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                        @foreach ($eventosAgrupados[$status] as $evento)
                            <div class="bg-white overflow-hidden shadow-lg rounded-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                                <a href="{{ route('admin.eventos.show', $evento) }}">
                                    @if ($evento->ruta_imagen)
                                        <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento: {{ $evento->nombre }}">
                                    @else
                                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-bold text-xl mb-2 text-gray-800">{{ $evento->nombre }}</h3>
                                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full flex items-center 
                                            @if ($evento->estado == 'Activo') bg-black text-white @elseif ($evento->estado == 'Cerrado') bg-yellow-100 text-yellow-800 @elseif ($evento->estado == 'Próximo') bg-blue-100 text-blue-800 @else bg-gray-200 text-gray-800 @endif">
                                            @if ($evento->estado == 'Activo')
                                                <span class="w-2 h-2 mr-1 rounded-full bg-white"></span>
                                            @endif
                                            {{ $evento->estado }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mb-4">
                                        {{ $evento->fecha_inicio->format('d M, Y') }} - {{ $evento->fecha_fin->format('d M, Y') }}
                                    </p>
                                    
                                    <div class="border-t border-gray-200 pt-4 flex items-center justify-end space-x-3">
                                        <a href="{{ route('admin.eventos.edit', $evento) }}" class="inline-flex items-center px-2 py-1 bg-black text-white rounded-md hover:bg-gray-800 transition-colors duration-200" title="Editar Evento">
                                            <svg class="w-5 h-5" fill="none" stroke="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.eventos.destroy', $evento->id_evento) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este evento? Esta acción es irreversible.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors duration-200" title="Eliminar Evento">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h3 class="font-bold text-2xl mb-4 mt-8">{{ $status }}</h3>
                    <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                        <p class="text-gray-500">No hay eventos con estado "{{ $status }}".</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
