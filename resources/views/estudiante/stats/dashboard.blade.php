@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header con Stats de Usuario -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold">¡Hola, {{ Auth::user()->nombre }}!</h2>
                    <p class="mt-2 text-indigo-100">Panel de Estadísticas y Progreso</p>
                </div>
                
                <!-- XP y Nivel -->
                <div class="text-right">
                    <div class="text-5xl font-bold">Nivel {{ $stats->nivel ?? 1 }}</div>
                    <div class="text-sm text-indigo-100 mt-1">{{ number_format($stats->total_xp ?? 0) }} XP Total</div>
                </div>
            </div>
            
            <!-- Barra de Progreso del Nivel -->
            <div class="mt-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium">Progreso al Nivel {{ ($stats->nivel ?? 1) + 1 }}</span>
                    <span class="text-sm">{{ number_format($stats->total_xp ?? 0) }} / {{ number_format($stats->xp_siguiente_nivel ?? 100) }} XP</span>
                </div>
                <div class="w-full bg-indigo-800 rounded-full h-3">
                    <div class="bg-yellow-400 h-3 rounded-full transition-all duration-500" style="width: {{ $stats->progreso_nivel ?? 0 }}%"></div>
                </div>
            </div>
        </div>

        <!-- Tarjetas de Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Eventos Participados -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Eventos Participados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats->eventos_participados ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Proyectos Completados -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Proyectos Completados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats->proyectos_completados ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Veces Líder -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Veces Líder</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats->veces_lider ?? 0 }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Logros Obtenidos -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Logros Desbloqueados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $logrosCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Gráfica de Progreso (Placeholder para Chart.js) -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Progreso Mensual</h3>
                <div class="h-64 flex items-center justify-center bg-gray-50 rounded">
                    <p class="text-gray-400">Gráfica de XP por mes (Chart.js pendiente)</p>
                </div>
            </div>
            
            <!-- Logros Recientes -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Logros Recientes</h3>
                    <a href="{{ route('estudiante.habilidades.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Ver todos →</a>
                </div>
                
                @if($logrosRecientes->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-400">Aún no has desbloqueado logros</p>
                        <p class="text-xs text-gray-400 mt-1">Participa en eventos para obtener logros</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($logrosRecientes as $usuarioLogro)
                            <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-indigo-300 transition">
                                <span class="text-3xl mr-3">{{ $usuarioLogro->logro->icono }}</span>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $usuarioLogro->logro->nombre }}</h4>
                                    <p class="text-xs text-gray-500">{{ $usuarioLogro->logro->descripcion }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $usuarioLogro->fecha_obtencion->diffForHumans() }}</p>
                                </div>
                                <span class="text-sm font-bold text-indigo-600">+{{ $usuarioLogro->logro->puntos_xp }} XP</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Habilidades Destacadas -->
        <div class="bg-white rounded-lg shadow-sm p-6 mt-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Mis Habilidades</h3>
                <a href="{{ route('estudiante.habilidades.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">Gestionar →</a>
            </div>
            
            <div class="flex flex-wrap gap-2">
                @forelse($habilidades as $habilidad)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $habilidad->color }};">
                        {{ $habilidad->nombre }}
                        <span class="ml-1 text-xs opacity-75">({{ $habilidad->pivot->nivel }})</span>
                    </span>
                @empty
                    <p class="text-gray-400 text-sm">No has agregado habilidades aún</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
