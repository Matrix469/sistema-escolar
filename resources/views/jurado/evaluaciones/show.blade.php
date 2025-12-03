@extends('jurado.layouts.app')

@section('content')
<div class="py-8 px-6 lg:px-12" style="background-color: #FFFDF4; min-height: 100vh;">
    <div class="max-w-6xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}" 
               class="inline-flex items-center gap-2 text-sm font-medium mb-4" style="color: #CE894D;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver al Equipo
            </a>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold" style="color: #4B4B4B;">Mi Evaluación del Proyecto</h1>
                    <p class="mt-1" style="color: #A4AEB7;">{{ $equipo->nombre }} - {{ $proyecto->nombre ?? 'Sin proyecto' }}</p>
                </div>
                {{-- Badge de estado --}}
                <div class="flex items-center gap-2 px-4 py-2 rounded-full" style="background-color: rgba(16, 185, 129, 0.15);">
                    <svg class="w-5 h-5" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold" style="color: #059669;">Evaluación Finalizada</span>
                </div>
            </div>
        </div>

        {{-- Calificación Final Destacada --}}
        <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #CE894D;">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background-color: rgba(255, 255, 255, 0.2);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm opacity-80">Calificación Final Otorgada</p>
                        <p class="text-white text-4xl font-bold">{{ number_format($evaluacion->calificacion_final, 1) }}<span class="text-2xl opacity-80">/100</span></p>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-white text-sm opacity-80">Fecha de evaluación</p>
                    <p class="text-white font-semibold">{{ $evaluacion->updated_at->translatedFormat('d \\d\\e F \\d\\e\\l Y') }}</p>
                    <p class="text-white text-sm opacity-80">{{ $evaluacion->updated_at->format('h:i A') }}</p>
                </div>
            </div>
        </div>

        {{-- Criterios de Evaluación --}}
        <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #FFEFDC;">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: #CE894D;">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold" style="color: #4B4B4B;">Desglose de Calificaciones</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Innovación --}}
                <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0BC7B;">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold" style="color: #4B4B4B;">Innovación y Creatividad</p>
                                <p class="text-xs" style="color: #A4AEB7;">Originalidad y uso creativo</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold" style="color: #CE894D;">{{ number_format($evaluacion->calificacion_innovacion, 1) }}</p>
                            <p class="text-xs" style="color: #A4AEB7;">/100</p>
                        </div>
                    </div>
                    {{-- Barra de progreso --}}
                    <div class="mt-3 h-2 rounded-full overflow-hidden" style="background-color: rgba(206, 137, 77, 0.2);">
                        <div class="h-full rounded-full" style="background-color: #F0BC7B; width: {{ $evaluacion->calificacion_innovacion }}%;"></div>
                    </div>
                </div>

                {{-- Funcionalidad --}}
                <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0BC7B;">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold" style="color: #4B4B4B;">Funcionalidad Técnica</p>
                                <p class="text-xs" style="color: #A4AEB7;">Completitud y calidad</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold" style="color: #CE894D;">{{ number_format($evaluacion->calificacion_funcionalidad, 1) }}</p>
                            <p class="text-xs" style="color: #A4AEB7;">/100</p>
                        </div>
                    </div>
                    {{-- Barra de progreso --}}
                    <div class="mt-3 h-2 rounded-full overflow-hidden" style="background-color: rgba(206, 137, 77, 0.2);">
                        <div class="h-full rounded-full" style="background-color: #F0BC7B; width: {{ $evaluacion->calificacion_funcionalidad }}%;"></div>
                    </div>
                </div>

                {{-- Presentación --}}
                <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0BC7B;">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold" style="color: #4B4B4B;">Presentación y UX</p>
                                <p class="text-xs" style="color: #A4AEB7;">Interfaz y usabilidad</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold" style="color: #CE894D;">{{ number_format($evaluacion->calificacion_presentacion, 1) }}</p>
                            <p class="text-xs" style="color: #A4AEB7;">/100</p>
                        </div>
                    </div>
                    {{-- Barra de progreso --}}
                    <div class="mt-3 h-2 rounded-full overflow-hidden" style="background-color: rgba(206, 137, 77, 0.2);">
                        <div class="h-full rounded-full" style="background-color: #F0BC7B; width: {{ $evaluacion->calificacion_presentacion }}%;"></div>
                    </div>
                </div>

                {{-- Impacto --}}
                <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: #F0BC7B;">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold" style="color: #4B4B4B;">Impacto y Aplicabilidad</p>
                                <p class="text-xs" style="color: #A4AEB7;">Relevancia y utilidad</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold" style="color: #CE894D;">{{ number_format($evaluacion->calificacion_impacto, 1) }}</p>
                            <p class="text-xs" style="color: #A4AEB7;">/100</p>
                        </div>
                    </div>
                    {{-- Barra de progreso --}}
                    <div class="mt-3 h-2 rounded-full overflow-hidden" style="background-color: rgba(206, 137, 77, 0.2);">
                        <div class="h-full rounded-full" style="background-color: #F0BC7B; width: {{ $evaluacion->calificacion_impacto }}%;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Retroalimentación --}}
        <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #FFEFDC;">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: #CE894D;">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold" style="color: #4B4B4B;">Retroalimentación Proporcionada</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                {{-- Fortalezas --}}
                <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #10B981;">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="font-semibold" style="color: #4B4B4B;">Fortalezas del Proyecto</p>
                    </div>
                    @if($evaluacion->comentarios_fortalezas)
                        <p style="color: #4B4B4B; white-space: pre-line;">{{ $evaluacion->comentarios_fortalezas }}</p>
                    @else
                        <p class="italic" style="color: #A4AEB7;">No se proporcionaron comentarios sobre fortalezas.</p>
                    @endif
                </div>

                {{-- Áreas de Mejora --}}
                <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #F59E0B;">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <p class="font-semibold" style="color: #4B4B4B;">Áreas de Mejora</p>
                    </div>
                    @if($evaluacion->comentarios_areas_mejora)
                        <p style="color: #4B4B4B; white-space: pre-line;">{{ $evaluacion->comentarios_areas_mejora }}</p>
                    @else
                        <p class="italic" style="color: #A4AEB7;">No se proporcionaron comentarios sobre áreas de mejora.</p>
                    @endif
                </div>

                {{-- Comentarios Generales --}}
                @if($evaluacion->comentarios_generales)
                    <div class="lg:col-span-2 rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #6B7280;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <p class="font-semibold" style="color: #4B4B4B;">Comentarios Generales</p>
                        </div>
                        <p style="color: #4B4B4B; white-space: pre-line;">{{ $evaluacion->comentarios_generales }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Botón Volver --}}
        <div class="flex justify-end">
            <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-semibold text-white transition-colors hover:opacity-90"
               style="background-color: #F0BC7B;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver al Equipo
            </a>
        </div>
    </div>
</div>
@endsection
