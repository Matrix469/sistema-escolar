@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            <h2 class="font-semibold text-xl text-gray-800 mb-6">Eventos Disponibles</h2>

            @if (session('info'))
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                    <p>{{ session('info') }}</p>
                </div>
            @endif

            <!-- Sección Mis Eventos Inscritos -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Mis Eventos Inscritos</h3>
                @if($misEventosInscritos->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($misEventosInscritos as $evento)
                            <div class="relative bg-white overflow-hidden shadow-lg rounded-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                                <div class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-10">
                                    Inscrito
                                </div>
                                <a href="{{ route('estudiante.eventos.show', $evento) }}">
                                    <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                                </a>
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-xl text-gray-800">{{ $evento->nombre }}</h4>
                                        <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                            @if ($evento->estado == 'Activo') bg-black text-white @else bg-gray-200 text-gray-800 @endif">
                                            {{ $evento->estado }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Finaliza: {{ $evento->fecha_fin->format('d M, Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 p-6 rounded-lg text-center">
                        <p class="text-gray-500">Aún no estás inscrito en ningún evento.</p>
                    </div>
                @endif
            </div>

            <!-- Sección Eventos Activos Disponibles -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Eventos Activos Disponibles</h3>
                @if($eventosActivos->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($eventosActivos as $evento)
                            <div class="bg-white overflow-hidden shadow-lg rounded-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                                <a href="{{ route('estudiante.eventos.show', $evento) }}">
                                    <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                                </a>
                                <div class="p-6">
                                    <h4 class="font-bold text-xl text-gray-800">{{ $evento->nombre }}</h4>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Finaliza: {{ $evento->fecha_fin->format('d M, Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 p-6 rounded-lg text-center">
                        <p class="text-gray-500">No hay otros eventos activos en este momento.</p>
                    </div>
                @endif
            </div>

            <!-- Sección Próximos Eventos -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Próximos Eventos</h3>
                @if($eventosProximos->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($eventosProximos as $evento)
                            <div class="bg-white overflow-hidden shadow-lg rounded-lg transform hover:scale-105 transition-transform duration-300 ease-in-out">
                                <a href="{{ route('estudiante.eventos.show', $evento) }}">
                                    <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $evento->ruta_imagen) }}" alt="Imagen del evento">
                                </a>
                                <div class="p-6">
                                    <h4 class="font-bold text-xl text-gray-800">{{ $evento->nombre }}</h4>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Inicia: {{ $evento->fecha_inicio->format('d M, Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 p-6 rounded-lg text-center">
                        <p class="text-gray-500">No hay eventos próximos anunciados.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
