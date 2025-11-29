<x-guest-layout>
    <div x-data="{ role: 'estudiante' }">
        
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">
                Registro de <span x-text="role === 'estudiante' ? 'Estudiante' : 'Jurado'" class="text-indigo-600"></span>
            </h2>

            <div class="flex justify-center mb-6">
                <div class="bg-gray-200 p-1 rounded-lg flex">
                    <label class="cursor-pointer px-4 py-2 rounded-md transition-all"
                           :class="role === 'estudiante' ? 'bg-white shadow text-indigo-600 font-bold' : 'text-gray-500'">
                        <input type="radio" name="tipo_registro" value="estudiante" x-model="role" class="hidden">
                        Estudiante
                    </label>

                    <label class="cursor-pointer px-4 py-2 rounded-md transition-all"
                           :class="role === 'jurado' ? 'bg-white shadow text-indigo-600 font-bold' : 'text-gray-500'">
                        <input type="radio" name="tipo_registro" value="jurado" x-model="role" class="hidden">
                        Jurado
                    </label>
                </div>
            </div>

            <div>
                <x-input-label for="nombre" :value="__('Nombre(s)')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <div class="flex gap-2 mt-4">
                <div class="w-1/2">
                    <x-input-label for="app_paterno" :value="__('Apellido Paterno')" />
                    <x-text-input id="app_paterno" class="block mt-1 w-full" type="text" name="app_paterno" :value="old('app_paterno')" required />
                    <x-input-error :messages="$errors->get('app_paterno')" class="mt-2" />
                </div>
                <div class="w-1/2">
                    <x-input-label for="app_materno" :value="__('Apellido Materno')" />
                    <x-text-input id="app_materno" class="block mt-1 w-full" type="text" name="app_materno" :value="old('app_materno')" />
                </div>
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div x-show="role === 'estudiante'" x-transition class="mt-4 border-t pt-4 border-gray-200">
                <h3 class="text-sm text-gray-500 font-bold mb-3 uppercase">Datos Escolares</h3>
                
                <div>
                    <x-input-label for="numero_control" :value="__('Número de Control')" />
                    <x-text-input id="numero_control" class="block mt-1 w-full" type="text" name="numero_control" :value="old('numero_control')" />
                    <x-input-error :messages="$errors->get('numero_control')" class="mt-2" />
                </div>

                <div class="flex gap-2 mt-4">
                    <div class="w-1/3">
                        <x-input-label for="semestre" :value="__('Semestre')" />
                        <select name="semestre" id="semestre" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @for ($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}">{{ $i }}°</option>
                            @endfor
                        </select>
                        <x-input-error :messages="$errors->get('semestre')" class="mt-2" />
                    </div>

                    <div class="w-2/3">
                        <x-input-label for="id_carrera" :value="__('Carrera')" />
                        <select name="id_carrera" id="id_carrera" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="" disabled selected>Selecciona tu carrera</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id_carrera }}">{{ $carrera->nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('id_carrera')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div x-show="role === 'jurado'" x-transition class="mt-4 border-t pt-4 border-gray-200" style="display: none;">
                <h3 class="text-sm text-indigo-500 font-bold mb-3 uppercase">Acceso de Jurado</h3>
                
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Ingrese el código de invitación proporcionado por la administración del evento.
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="token_acceso" :value="__('Código de Invitación (Token)')" />
                    <x-text-input id="token_acceso" class="block mt-1 w-full font-mono tracking-widest uppercase" type="text" name="token_acceso" :value="old('token_acceso')" placeholder="XXXX-XXXX" />
                    <x-input-error :messages="$errors->get('token_acceso')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="especialidad" :value="__('Especialidad Técnica')" />
                    <x-text-input id="especialidad" class="block mt-1 w-full" type="text" name="especialidad" :value="old('especialidad')" placeholder="Ej. Inteligencia Artificial, Redes..." />
                    <x-input-error :messages="$errors->get('especialidad')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="empresa_institucion" :value="__('Empresa o Institución')" />
                    <x-text-input id="empresa_institucion" class="block mt-1 w-full" type="text" name="empresa_institucion" :value="old('empresa_institucion')" />
                </div>
            </div>

            <div class="mt-4 border-t pt-4 border-gray-200">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>