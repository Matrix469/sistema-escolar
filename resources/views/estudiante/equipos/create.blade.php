@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            @isset($evento)
            <a href="{{ route('estudiante.eventos.show', $evento) }}" class="text-gray-800 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            @endisset
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                @isset($equipo)
                    Editar Equipo
                @else
                    Inscribir Nuevo Equipo para: {{ $evento->nombre }}
                @endisset
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

                    <form action="{{ isset($equipo) ? route('estudiante.equipo.update') : route('estudiante.eventos.equipos.store', $evento) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($equipo)
                            @method('PUT')
                        @endisset

                        <!-- Nombre del Equipo -->
                        <div>
                            <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre del Equipo</label>
                            <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nombre', $equipo->nombre ?? '') }}" required autofocus>
                        </div>

                        <!-- Descripción del Equipo -->
                        <div class="mt-4">
                            <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción del Equipo (Opcional)</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe tu equipo, proyecto o lo que buscan lograr...">{{ old('descripcion', $equipo->descripcion ?? '') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Máximo 1000 caracteres. Esta descripción ayudará a otros estudiantes a conocer tu equipo.</p>
                        </div>

                        <!-- Imagen del Equipo -->
                        <div class="mt-6">
                            <label for="ruta_imagen" class="block font-medium text-sm text-gray-700">
                                @isset($equipo)
                                    Cambiar Imagen del Equipo (Opcional)
                                @else
                                    Imagen del Equipo (Opcional)
                                @endisset
                            </label>
                            
                            @isset($equipo)
                                @if ($equipo->ruta_imagen)
                                    <div class="my-4">
                                        <p class="font-medium text-sm text-gray-500 mb-2">Imagen Actual:</p>
                                        <img src="{{ asset('storage/' . $equipo->ruta_imagen) }}" alt="Imagen actual del equipo" class="h-32 w-32 object-cover rounded-md">
                                    </div>
                                @endif
                            @endisset

                            <input type="file" name="ruta_imagen" id="ruta_imagen" class="mt-1 block w-full">
                        </div>

                        <!-- Botón de Envío -->
                        <div class="flex items-center justify-end mt-8">
                            <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 font-semibold">
                                @isset($equipo)
                                    Actualizar Equipo
                                @else
                                    Crear e Inscribir Equipo
                                @endisset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
