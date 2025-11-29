@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center">
            <a href="{{ route('admin.users.index') }}" class="text-gray-800 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 mb-6">
                Editar Usuario: {{ $user->nombre }}
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
                            <p class="font-bold">¡Ups! Hubo algunos problemas con tus datos.</p>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-6">Datos Personales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre(s)</label>
                                <input type="text" name="nombre" id="nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('nombre', $user->nombre) }}" required>
                            </div>
                            <div>
                                <label for="app_paterno" class="block font-medium text-sm text-gray-700">Apellido Paterno</label>
                                <input type="text" name="app_paterno" id="app_paterno" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('app_paterno', $user->app_paterno) }}" required>
                            </div>
                            <div>
                                <label for="app_materno" class="block font-medium text-sm text-gray-700">Apellido Materno</label>
                                <input type="text" name="app_materno" id="app_materno" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('app_materno', $user->app_materno) }}">
                            </div>
                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700">Correo Electrónico</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mt-10 mb-6">Rol del Sistema</h3>
                        <div>
                            <label for="id_rol_sistema" class="block font-medium text-sm text-gray-700">Rol</label>
                            <select name="id_rol_sistema" id="id_rol_sistema" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id_rol_sistema }}" {{ $user->id_rol_sistema == $rol->id_rol_sistema ? 'selected' : '' }}>
                                        {{ ucfirst($rol->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        @if($user->estudiante)
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mt-10 mb-6">Datos de Estudiante</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="numero_control" class="block font-medium text-sm text-gray-700">Número de Control</label>
                                    <input type="text" name="numero_control" id="numero_control" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('numero_control', $user->estudiante->numero_control) }}">
                                </div>
                                <div>
                                    <label for="semestre" class="block font-medium text-sm text-gray-700">Semestre</label>
                                    <input type="number" name="semestre" id="semestre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('semestre', $user->estudiante->semestre) }}">
                                </div>
                                <div>
                                    <label for="carrera" class="block font-medium text-sm text-gray-700">Carrera</label>
                                    <input type="text" id="carrera" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100" value="{{ $user->estudiante->carrera->nombre ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        @elseif($user->jurado)
                             <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mt-10 mb-6">Datos de Jurado</h3>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="especialidad" class="block font-medium text-sm text-gray-700">Especialidad</label>
                                    <input type="text" name="especialidad" id="especialidad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('especialidad', $user->jurado->especialidad) }}">
                                </div>
                             </div>
                        @endif

                        <div class="flex items-center justify-end mt-8">
                            <button type="submit" class="px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 font-semibold">
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
