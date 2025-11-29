@extends('layouts.app')

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="font-semibold text-xl text-gray-800 mb-6">
            {{ __('Gestión de Usuarios') }}
        </h2>

            <!-- Contadores -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">Administradores</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalAdmins }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">Jurados</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalJurados }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500">Estudiantes</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalEstudiantes }}</p>
                </div>
            </div>

            <!-- Filtros y Búsqueda -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-8">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" name="search" placeholder="Buscar por nombre, apellido o email..." value="{{ request('search') }}" class="block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <select name="rol" class="block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Todos los roles</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id_rol_sistema }}" {{ request('rol') == $rol->id_rol_sistema ? 'selected' : '' }}>
                                        {{ ucfirst($rol->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="submit" class="w-full justify-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-black">Filtrar</button>
                            <a href="{{ route('admin.users.index') }}" class="w-full text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Limpiar</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                                <th scope="col" class="relative px-6 py-3"><span class="sr-only">Editar</span></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($usuarios as $usuario)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $usuario->nombre }} {{ $usuario->app_paterno }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $usuario->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($usuario->rolSistema->nombre == 'admin') bg-red-200 text-red-800
                                            @elseif($usuario->rolSistema->nombre == 'jurado') bg-yellow-200 text-yellow-800
                                            @else bg-blue-200 text-blue-800 @endif">
                                            {{ ucfirst($usuario->rolSistema->nombre) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.users.edit', $usuario) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        No se encontraron usuarios con los criterios seleccionados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $usuarios->appends(request()->query())->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
