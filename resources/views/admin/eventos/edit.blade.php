@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="{{ route('admin.eventos.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                {{ __('Editar Evento') }}
            </h2>
        </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <strong>¡Ups!</strong> Hubo algunos problemas con tus datos.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.eventos.update', $evento) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre del Evento -->
                            <div>
                                <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre del Evento</label>
                                <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nombre', $evento->nombre) }}" required>
                            </div>

                            <!-- Cupo Máximo de Equipos -->
                            <div>
                                <label for="cupo_max_equipos" class="block font-medium text-sm text-gray-700">Cupo Máximo de Equipos</label>
                                <input type="number" name="cupo_max_equipos" id="cupo_max_equipos" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('cupo_max_equipos', $evento->cupo_max_equipos) }}" required min="1">
                            </div>

                            <!-- Fecha de Inicio -->
                            <div>
                                <label for="fecha_inicio" class="block font-medium text-sm text-gray-700">Fecha de Inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('fecha_inicio', $evento->fecha_inicio->format('Y-m-d')) }}" required>
                            </div>

                            <!-- Fecha de Fin -->
                            <div>
                                <label for="fecha_fin" class="block font-medium text-sm text-gray-700">Fecha de Fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('fecha_fin', $evento->fecha_fin->format('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mt-6">
                            <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('descripcion', $evento->descripcion) }}</textarea>
                        </div>

                        <!-- Imagen del Evento -->
                        <div class="mt-6">
                            <label for="ruta_imagen" class="block font-medium text-sm text-gray-700">Nueva Imagen del Evento (Opcional)</label>
                            <input type="file" name="ruta_imagen" id="ruta_imagen" class="mt-1 block w-full">
                        </div>

                        <!-- Imagen Actual -->
                        <div class="mt-4">
                            <label class="block font-medium text-sm text-gray-700">Imagen Actual</label>
                            @if ($evento->ruta_imagen)
                                <img src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen actual" class="mt-2 h-32 w-auto rounded">
                            @else
                                <p class="text-sm text-gray-500 mt-2">No hay imagen actualmente.</p>
                            @endif
                        </div>

                        <!-- Botón de Envío -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800">
                                Actualizar Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
