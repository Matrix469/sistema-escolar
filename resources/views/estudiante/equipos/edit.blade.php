@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="{{ route('estudiante.equipo.index') }}" class="text-gray-800 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                Editar Equipo: {{ $equipo->nombre }}
            </h2>
        </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                            <p class="font-bold">¡Ups! Hubo algunos problemas.</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('estudiante.equipo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nombre del Equipo -->
                        <div>
                            <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre del Equipo</label>
                            <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('nombre', $equipo->nombre) }}" required autofocus>
                            <p class="text-xs text-gray-500 mt-1">Este es el nombre con el que tu equipo será identificado en el evento.</p>
                        </div>

                        <!-- Descripción del Equipo -->
                        <div class="mt-4">
                            <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción del Equipo (Opcional)</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe tu equipo, proyecto o lo que buscan lograr...">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Máximo 1000 caracteres. Esta descripción ayudará a otros estudiantes a conocer tu equipo.</p>
                        </div>

                        <!-- Imagen del Equipo -->
                        <div class="mt-6">
                            <label for="ruta_imagen" class="block font-medium text-sm text-gray-700">
                                Cambiar Imagen del Equipo (Opcional)
                            </label>
                            
                            @if ($equipo->ruta_imagen)
                                <div class="my-4">
                                    <p class="font-medium text-sm text-gray-500 mb-2">Imagen Actual:</p>
                                    <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen actual del equipo" class="h-40 w-40 object-cover rounded-lg shadow-md border-2 border-gray-200">
                                </div>
                            @else
                                <div class="my-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                    <p class="text-sm text-gray-500 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        No hay imagen cargada. Puedes subir una para personalizar tu equipo.
                                    </p>
                                </div>
                            @endif

                            <input type="file" name="ruta_imagen" id="ruta_imagen" accept="image/jpeg,image/png,image/jpg,image/gif" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-500 mt-1">Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB.</p>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('estudiante.equipo.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-semibold transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold transition shadow-sm">
                                Actualizar Equipo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
