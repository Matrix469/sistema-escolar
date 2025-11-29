@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="{{ route('admin.eventos.show', $evento) }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                Asignar Jurados a: {{ $evento->nombre }}
            </h2>
        </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                            <p class="font-bold">Éxito</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                            <p class="font-bold">¡Ups!</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.eventos.actualizar_asignacion', $evento) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <p class="mb-4 text-gray-600">Selecciona los jurados para este evento (mínimo 3, máximo 5).</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @forelse ($juradosDisponibles as $jurado)
                                <label class="flex items-center space-x-3 bg-gray-50 p-4 rounded-lg shadow-sm hover:bg-gray-100 cursor-pointer">
                                    <input type="checkbox" name="jurados[]" value="{{ $jurado->id_usuario }}" 
                                        {{ in_array($jurado->id_usuario, $juradosAsignadosIds) ? 'checked' : '' }} 
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="text-gray-900 font-medium">
                                        {{ $jurado->user->nombre }} {{ $jurado->user->app_paterno }}
                                    </span>
                                </label>
                            @empty
                                <p class="col-span-full text-gray-600">No hay jurados disponibles en el sistema.</p>
                            @endforelse
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 font-semibold">
                                Guardar Asignación
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection