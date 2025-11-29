@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 mb-6">Inicio</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg p-5 text-white shadow-lg flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-semibold">Estudiantes Activos</h4>
                        <p class="text-3xl font-bold">{{ $totalEstudiantesActivos }}</p>
                    </div>
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354V4a2 2 0 10-4 0v.354M15 15H3a3 3 0 013-3h12a3 3 0 013 3v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm12 0a3 3 0 00-3-3h-2a3 3 0 00-3 3v2a2 2 0 002 2h4a2 2 0 002-2v-2z"></path></svg>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg p-5 text-white shadow-lg flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-semibold">Eventos en Curso</h4>
                        <p class="text-3xl font-bold">{{ $eventosEnCursoCount }}</p>
                    </div>
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2zm7-2H7m7-4H7m7-4H7"></path></svg>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-lg p-5 text-white shadow-lg flex items-center justify-between">
                    <div>
                        <h4 class="text-lg font-semibold">Equipos Registrados</h4>
                        <p class="text-3xl font-bold">{{ $equiposRegistradosCount }}</p>
                    </div>
                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>

                                <div class="bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-lg p-5 text-white shadow-lg flex items-center justify-between">
                                    <div>
                                        <h4 class="text-lg font-semibold">Jurados Registrados</h4>
                                        <p class="text-3xl font-bold">{{ $juradosAsignadosCount }}</p>
                                    </div>
                                    <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-9 8h2m-2 4h2m4-4h2m-2 4h2m-6 2h6"></path></svg>
                                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Acciones Rápidas</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admin.eventos.create') }}" class="flex flex-col items-center justify-center p-4 bg-white text-gray-700 rounded-lg shadow-sm border border-gray-200 hover:border-indigo-600 transform hover:scale-105 transition duration-200 ease-in-out">
                        <svg class="w-8 h-8 mb-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <span class="font-semibold text-gray-800">Crear Evento</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center justify-center p-4 bg-white text-gray-700 rounded-lg shadow-sm border border-gray-200 hover:border-green-600 transform hover:scale-105 transition duration-200 ease-in-out">
                        <svg class="w-8 h-8 mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM12 14v.01M12 18v.01"></path></svg>
                        <span class="font-semibold text-gray-800">Gestionar Usuarios</span>
                    </a>
                    <a href="{{ route('admin.equipos.index') }}" class="flex flex-col items-center justify-center p-4 bg-white text-gray-700 rounded-lg shadow-sm border border-gray-200 hover:border-purple-600 transform hover:scale-105 transition duration-200 ease-in-out">
                        <svg class="w-8 h-8 mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="font-semibold text-gray-800">Ver Equipos</span>
                    </a>
                </div>
            </div>

            <!-- Eventos que Requieren Atención -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold mb-4 text-gray-800">Eventos que Requieren Atención ⚠️</h3>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Eventos por Iniciar -->
                        <div>
                            <h4 class="font-bold text-yellow-800 mb-2">Próximos a Iniciar</h4>
                            <ul class="text-sm space-y-2">
                                @forelse($eventosPorIniciar as $evento)
                                    <li><a href="{{ route('admin.eventos.show', $evento) }}" class="text-yellow-900 hover:underline">{{ $evento->nombre }} <span class="text-xs">({{ $evento->fecha_inicio->diffForHumans() }})</span></a></li>
                                @empty
                                    <li class="text-gray-500">No hay eventos iniciando pronto.</li>
                                @endforelse
                            </ul>
                        </div>
                        <!-- Eventos sin Jurados -->
                        <div>
                            <h4 class="font-bold text-yellow-800 mb-2">Activos sin Jurados</h4>
                            <ul class="text-sm space-y-2">
                                @forelse($eventosSinJurados as $evento)
                                    <li><a href="{{ route('admin.eventos.show', $evento) }}" class="text-yellow-900 hover:underline">{{ $evento->nombre }}</a></li>
                                @empty
                                    <li class="text-gray-500">Todos los eventos activos tienen jurados.</li>
                                @endforelse
                            </ul>
                        </div>
                        <!-- Eventos con Equipos Incompletos -->
                        <div>
                            <h4 class="font-bold text-yellow-800 mb-2">Con Equipos Incompletos</h4>
                            <ul class="text-sm space-y-2">
                                @forelse($eventosConEquiposIncompletos as $evento)
                                    <li><a href="{{ route('admin.eventos.show', $evento) }}" class="text-yellow-900 hover:underline">{{ $evento->nombre }} <span class="font-bold">({{ $evento->inscripciones_count }})</span></a></li>
                                @empty
                                    <li class="text-gray-500">No hay equipos incompletos en eventos activos.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-8">
                <h3 class="text-2xl font-bold mb-4">Próximos y Actuales Eventos</h3>
                <div class="bg-gray-50 p-6 rounded-lg shadow-md h-96 overflow-y-scroll">
                    <ul class="divide-y divide-gray-200">
                        @forelse ($eventosDashboard as $evento)
                            <li class="py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div class="mb-2 sm:mb-0">
                                    <p class="text-lg font-semibold text-gray-800">{{ $evento->nombre }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $evento->fecha_inicio->format('d/m/Y') }} - {{ $evento->fecha_fin->format('d/m/Y') }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if ($evento->estado == 'Activo') bg-black text-white
                                    @elseif ($evento->estado == 'Próximo') bg-blue-200 text-blue-800
                                    @else bg-gray-200 text-gray-800 @endif">
                                    {{ $evento->estado }}
                                </span>
                            </li>
                        @empty
                            <li class="py-4 text-gray-500 text-center">No hay eventos próximos o activos para mostrar.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>
@endsection
