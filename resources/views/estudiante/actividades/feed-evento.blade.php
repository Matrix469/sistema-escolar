@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Feed de Actividad</h2>
            <p class="mt-2 text-gray-600">{{ $evento->nombre }}</p>
        </div>

        <!-- Timeline de Actividades -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            @if($actividades->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-4 text-gray-500">Aún no hay actividades</p>
                </div>
            @else
                <div class="flow-root">
                    <ul class="-mb-8">
                        @foreach($actividades as $actividad)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    
                                    <div class="relative flex space-x-3">
                                        <!-- Icono -->
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center ring-8 ring-white">
                                                <span class="text-lg">{{ $actividad->icono }}</span>
                                            </span>
                                        </div>
                                        
                                        <!-- Contenido -->
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-700">
                                                    <span class="font-semibold text-gray-900">{{ $actividad->usuario->nombre }}</span>
                                                    {{ $actividad->descripcion }}
                                                </p>
                                                @if($actividad->equipo)
                                                    <p class="mt-0.5 text-xs text-gray-500">
                                                        Equipo: {{ $actividad->equipo->nombre }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                <time datetime="{{ $actividad->created_at }}">{{ $actividad->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
