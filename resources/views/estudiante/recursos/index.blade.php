@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Recursos de {{ $equipo->nombre }}</h2>
                <p class="mt-2 text-gray-600">Biblioteca de recursos compartidos del equipo</p>
            </div>
            <a href="{{ route('estudiante.equipo.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                ← Volver a Mi Equipo
            </a>
        </div>

        <!-- Formulario para Agregar Recurso -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Compartir Nuevo Recurso</h3>
            
            <form action="{{ route('estudiante.recursos.store', $equipo) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Recurso</label>
                    <input type="text" name="nombre" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: Documentación de la API">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                    <select name="tipo" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="link">🔗 Link</option>
                        <option value="documento">📄 Documento</option>
                        <option value="video">🎥 Video</option>
                        <option value="imagen">🖼️ Imagen</option>
                        <option value="otro">📎 Otro</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL</label>
                    <input type="url" name="url" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://...">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción (Opcional)</label>
                    <textarea name="descripcion" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Breve descripción del recurso"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-semibold transition">
                        Compartir Recurso
                    </button>
                </div>
            </form>
        </div>

        <!-- Lista de Recursos -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Recursos Compartidos ({{ $recursos->count() }})</h3>
            
            @if($recursos->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-4 text-gray-500">Aún no hay recursos compartidos</p>
                    <p class="text-sm text-gray-400">Comparte links, documentos y más con tu equipo</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recursos as $recurso)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-300 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <span class="text-2xl">{{ $recurso->icono }}</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 line-clamp-1">{{ $recurso->nombre }}</h4>
                                        <p class="text-xs text-gray-500">{{ $recurso->tipo }}</p>
                                    </div>
                                </div>
                                
                                <form action="{{ route('estudiante.recursos.destroy', $recurso) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('¿Eliminar este recurso?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            
                            @if($recurso->descripcion)
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $recurso->descripcion }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <img src="{{ $recurso->subidoPor->foto_perfil_url }}" alt="{{ $recurso->subidoPor->nombre }}" class="w-6 h-6 rounded-full">
                                    <p class="text-xs text-gray-500">{{ $recurso->subidoPor->nombre }}</p>
                                </div>
                                
                                <a href="{{ $recurso->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                                    Abrir →
                                </a>
                            </div>
                            
                            <p class="text-xs text-gray-400 mt-2">{{ $recurso->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
