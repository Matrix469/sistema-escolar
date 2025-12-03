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
            <h1 class="text-2xl font-bold" style="color: #4B4B4B;">Evaluación Final del Proyecto</h1>
            <p class="mt-1" style="color: #A4AEB7;">{{ $equipo->nombre }} - {{ $proyecto->nombre ?? 'Sin proyecto' }}</p>
        </div>

        {{-- Alerta de éxito --}}
        @if(session('success'))
            <div class="rounded-2xl p-4 mb-6 flex items-center gap-3" style="background-color: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                <svg class="w-6 h-6 flex-shrink-0" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="font-medium" style="color: #059669;">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Alerta de evaluación finalizada --}}
        @if($evaluacion->estado == 'Finalizada')
            <div class="rounded-2xl p-4 mb-6 flex items-center gap-3" style="background-color: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3);">
                <svg class="w-6 h-6 flex-shrink-0" style="color: #2563EB;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold" style="color: #1D4ED8;">Esta evaluación ya ha sido finalizada</p>
                    <p class="text-sm" style="color: #3B82F6;">No es posible realizar más modificaciones</p>
                </div>
            </div>
        @endif

        <form action="{{ route('jurado.evaluaciones.store', $inscripcion) }}" method="POST">
            @csrf

            {{-- Criterios de Evaluación --}}
            <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #FFEFDC;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: #CE894D;">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold" style="color: #4B4B4B;">Criterios de Evaluación</h2>
                    <span class="text-sm px-3 py-1 rounded-full" style="background-color: rgba(206, 137, 77, 0.2); color: #CE894D;">0-100 pts cada uno</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Innovación --}}
                    <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #F0BC7B;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <label for="calificacion_innovacion" class="block font-semibold text-sm" style="color: #4B4B4B;">Innovación y Creatividad</label>
                                <p class="text-xs" style="color: #A4AEB7;">Originalidad, uso creativo de tecnologías</p>
                            </div>
                        </div>
                        <input type="number" name="calificacion_innovacion" id="calificacion_innovacion"
                               value="{{ old('calificacion_innovacion', $evaluacion->calificacion_innovacion) }}"
                               min="0" max="100" step="0.5"
                               class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2"
                               style="background-color: #FFFDF4; border: 1px solid #E5E7EB; color: #4B4B4B;"
                               placeholder="0-100"
                               {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                        @error('calificacion_innovacion')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Funcionalidad --}}
                    <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #F0BC7B;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <label for="calificacion_funcionalidad" class="block font-semibold text-sm" style="color: #4B4B4B;">Funcionalidad y Calidad Técnica</label>
                                <p class="text-xs" style="color: #A4AEB7;">Completitud, estabilidad, calidad del código</p>
                            </div>
                        </div>
                        <input type="number" name="calificacion_funcionalidad" id="calificacion_funcionalidad"
                               value="{{ old('calificacion_funcionalidad', $evaluacion->calificacion_funcionalidad) }}"
                               min="0" max="100" step="0.5"
                               class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2"
                               style="background-color: #FFFDF4; border: 1px solid #E5E7EB; color: #4B4B4B;"
                               placeholder="0-100"
                               {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                        @error('calificacion_funcionalidad')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Presentación --}}
                    <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #F0BC7B;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <label for="calificacion_presentacion" class="block font-semibold text-sm" style="color: #4B4B4B;">Presentación y UX</label>
                                <p class="text-xs" style="color: #A4AEB7;">Interfaz, usabilidad, experiencia de usuario</p>
                            </div>
                        </div>
                        <input type="number" name="calificacion_presentacion" id="calificacion_presentacion"
                               value="{{ old('calificacion_presentacion', $evaluacion->calificacion_presentacion) }}"
                               min="0" max="100" step="0.5"
                               class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2"
                               style="background-color: #FFFDF4; border: 1px solid #E5E7EB; color: #4B4B4B;"
                               placeholder="0-100"
                               {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                        @error('calificacion_presentacion')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Impacto --}}
                    <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #F0BC7B;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <label for="calificacion_impacto" class="block font-semibold text-sm" style="color: #4B4B4B;">Impacto y Aplicabilidad</label>
                                <p class="text-xs" style="color: #A4AEB7;">Relevancia, utilidad práctica, escalabilidad</p>
                            </div>
                        </div>
                        <input type="number" name="calificacion_impacto" id="calificacion_impacto"
                               value="{{ old('calificacion_impacto', $evaluacion->calificacion_impacto) }}"
                               min="0" max="100" step="0.5"
                               class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2"
                               style="background-color: #FFFDF4; border: 1px solid #E5E7EB; color: #4B4B4B;"
                               placeholder="0-100"
                               {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>
                        @error('calificacion_impacto')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Calificación Final Preview --}}
                @if($evaluacion->calificacion_final)
                    <div class="mt-6 pt-6" style="border-top: 1px solid rgba(206, 137, 77, 0.3);">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" style="color: #CE894D;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                                <span class="font-semibold" style="color: #4B4B4B;">Calificación Final:</span>
                            </div>
                            <span class="text-3xl font-bold" style="color: #CE894D;">{{ number_format($evaluacion->calificacion_final, 2) }}/100</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Retroalimentación --}}
            <div class="rounded-2xl p-6 shadow-sm mb-6" style="background-color: #FFEFDC;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: #CE894D;">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold" style="color: #4B4B4B;">Retroalimentación</h2>
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
                            <label for="comentarios_fortalezas" class="font-semibold text-sm" style="color: #4B4B4B;">Fortalezas del Proyecto</label>
                        </div>
                        <textarea name="comentarios_fortalezas" id="comentarios_fortalezas" rows="4"
                                  class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2 resize-none"
                                  style="background-color: #FFFDF4; border: 1px solid #E5E7EB; color: #4B4B4B;"
                                  placeholder="¿Qué aspectos destacan positivamente?"
                                  {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_fortalezas', $evaluacion->comentarios_fortalezas) }}</textarea>
                        @error('comentarios_fortalezas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Áreas de Mejora --}}
                    <div class="rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #F59E0B;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <label for="comentarios_areas_mejora" class="font-semibold text-sm" style="color: #4B4B4B;">Áreas de Mejora</label>
                        </div>
                        <textarea name="comentarios_areas_mejora" id="comentarios_areas_mejora" rows="4"
                                  class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2 resize-none"
                                  style="background-color: #FFFDF4; border: 1px solid #E5E7EB; color: #4B4B4B;"
                                  placeholder="¿Qué podría mejorar el equipo?"
                                  {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_areas_mejora', $evaluacion->comentarios_areas_mejora) }}</textarea>
                        @error('comentarios_areas_mejora')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Comentarios Generales (full width) --}}
                    <div class="lg:col-span-2 rounded-xl p-4" style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB;">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #6B7280;">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <label for="comentarios_generales" class="font-semibold text-sm" style="color: #4B4B4B;">Comentarios Generales</label>
                        </div>
                        <textarea name="comentarios_generales" id="comentarios_generales" rows="3"
                                  class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2 resize-none"
                                  style="background-color: #FFFDF4; border: 1px solid #E5E7EB; color: #4B4B4B;"
                                  placeholder="Cualquier otro comentario u observación..."
                                  {{ $evaluacion->estado == 'Finalizada' ? 'disabled' : '' }}>{{ old('comentarios_generales', $evaluacion->comentarios_generales) }}</textarea>
                        @error('comentarios_generales')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            @if($evaluacion->estado != 'Finalizada')
                <div class="flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('jurado.eventos.equipo_evento', [$inscripcion->evento, $equipo]) }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-semibold transition-colors"
                       style="background-color: rgba(255, 255, 255, 0.5); border: 1px solid #E5E7EB; color: #4B4B4B;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" name="finalizar" value="0"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-semibold transition-colors hover:opacity-90"
                            style="background-color: #A4AEB7; color: white;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Guardar Borrador
                    </button>
                    <button type="submit" name="finalizar" value="1"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-semibold text-white transition-colors hover:opacity-90"
                            style="background-color: #F0BC7B;"
                            onclick="return confirm('¿Finalizar evaluación? No podrás editarla después.')">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Finalizar Evaluación
                    </button>
                </div>
            @else
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
            @endif
        </form>
    </div>
</div>
@endsection
