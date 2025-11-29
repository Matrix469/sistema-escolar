@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 mb-6">
            {{ __('Panel de Jurado') }}
        </h2>

            <!-- Sección: Mis Eventos Asignados -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Mis Eventos Asignados</h3>
                @if($misEventosAsignados->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($misEventosAsignados as $evento)
                            <div class="bg-white overflow-hidden shadow-lg rounded-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                                <a href="#"> <!-- Enlace a la vista de detalle de evento para Jurados -->
                                    @if ($evento->ruta_imagen)
                                        <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                                    @else
                                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-xl text-gray-800 truncate">{{ $evento->nombre }}</h4>
                                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                            @if ($evento->estado == 'Activo') bg-black text-white @else bg-blue-200 text-blue-800 @endif">
                                            {{ $evento->estado }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Del: {{ $evento->fecha_inicio->format('d M, Y') }}
                                    </p>
                                    <p class="text-gray-600 text-sm">
                                        Al: {{ $evento->fecha_fin->format('d M, Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-sm">
                        <p>No tienes eventos asignados para evaluar en este momento.</p>
                    </div>
                @endif
            </div>

            <!-- Sección: Otros Eventos Disponibles (No asignados al jurado) -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Otros Eventos Disponibles</h3>
                @php
                    $asignadosIds = $misEventosAsignados->pluck('id_evento')->toArray();
                    $otrosEventos = $eventosPublicos->filter(function($evento) use ($asignadosIds) {
                        return !in_array($evento->id_evento, $asignadosIds);
                    });
                @endphp

                @if($otrosEventos->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($otrosEventos as $evento)
                            <div class="bg-white overflow-hidden shadow-lg rounded-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                                <a href="{{ route('estudiante.eventos.show', $evento) }}"> <!-- Enlace a la vista pública de detalle (solo info) -->
                                    @if ($evento->ruta_imagen)
                                        <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                                    @else
                                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-xl text-gray-800 truncate">{{ $evento->nombre }}</h4>
                                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                            @if ($evento->estado == 'Activo') bg-black text-white @else bg-blue-200 text-blue-800 @endif">
                                            {{ $evento->estado }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Inicia: {{ $evento->fecha_inicio->format('d M, Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500">No hay otros eventos disponibles en este momento.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
