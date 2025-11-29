@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Mis Habilidades</h2>
            <p class="mt-2 text-gray-600">Gestiona tu perfil de habilidades técnicas</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Mis Habilidades -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Mis Habilidades</h3>
                    
                    @if($misHabilidades->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="mt-4 text-gray-500">Aún no has agregado habilidades a tu perfil</p>
                            <p class="text-sm text-gray-400">Agrega tus habilidades para que los equipos te encuentren</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($misHabilidades as $habilidad)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-indigo-300 transition">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold" style="background-color: {{ $habilidad->color }};">
                                            {{ strtoupper(substr($habilidad->nombre, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $habilidad->nombre }}</h4>
                                            <p class="text-sm text-gray-500">{{ $habilidad->categoria }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <!-- Selector de Nivel -->
                                        <form action="{{ route('estudiante.habilidades.update', $habilidad->id_habilidad) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="nivel" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="Básico" {{ $habilidad->pivot->nivel == 'Básico' ? 'selected' : '' }}>Básico</option>
                                                <option value="Intermedio" {{ $habilidad->pivot->nivel == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                                                <option value="Avanzado" {{ $habilidad->pivot->nivel == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                                                <option value="Experto" {{ $habilidad->pivot->nivel == 'Experto' ? 'selected' : '' }}>Experto</option>
                                            </select>
                                        </form>
                                        
                                        <!-- Eliminar -->
                                        <form action="{{ route('estudiante.habilidades.destroy', $habilidad->id_habilidad) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('¿Eliminar esta habilidad?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Agregar Habilidad -->
            <div>
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Agregar Habilidad</h3>
                    
                    <form action="{{ route('estudiante.habilidades.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Selecciona una habilidad</label>
                            <select name="id_habilidad" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Selecciona --</option>
                                @foreach($habilidadesDisponibles as $categoria => $habilidades)
                                    <optgroup label="{{ $categoria }}">
                                        @foreach($habilidades as $habilidad)
                                            <option value="{{ $habilidad->id_habilidad }}">{{ $habilidad->nombre }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nivel de dominio</label>
                            <div class="space-y-2">
                                @foreach(['Básico', 'Intermedio', 'Avanzado', 'Experto'] as $nivel)
                                    <label class="flex items-center">
                                        <input type="radio" name="nivel" value="{{ $nivel }}" {{ $loop->first ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">{{ $nivel }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold transition">
                            Agregar Habilidad
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
