<?php

namespace App\Http\Requests\Estudiante;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UnirseEquipoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Verificar que el usuario es estudiante
        return Auth::check() && Auth::user()->hasRole('Estudiante');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_equipo' => [
                'required',
                'exists:equipos,id_equipo',
                // El equipo debe tener inscripciones activas
                function ($attribute, $value, $fail) {
                    $equipo = \App\Models\Equipo::find($value);
                    if ($equipo && !$equipo->tieneInscripcionesActivas()) {
                        $fail('El equipo no acepta nuevos miembros en este momento.');
                    }
                },
            ],
            'mensaje' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id_equipo.required' => 'Debe seleccionar un equipo.',
            'id_equipo.exists' => 'El equipo seleccionado no es válido.',
            'mensaje.max' => 'El mensaje no puede exceder los 500 caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id_equipo' => 'equipo',
            'mensaje' => 'mensaje de solicitud',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validarConflictoFechas($validator);
            $this->validarSolicitudPendiente($validator);
            $this->validarMiembroExistente($validator);
        });
    }

    /**
     * Validar que no haya conflicto de fechas con otros eventos
     */
    private function validarConflictoFechas($validator)
    {
        $equipo = \App\Models\Equipo::find($this->id_equipo);

        if ($equipo && $equipo->evento) {
            $estudiante = Auth::user()->estudiante;

            if (\App\Helpers\EventoHelper::verificarConflictoFechas(
                $estudiante,
                $equipo->evento
            )) {
                $validator->errors()->add('id_equipo',
                    'Tienes un conflicto de fechas con otro evento al que estás inscrito.'
                );
            }
        }
    }

    /**
     * Validar que no haya una solicitud pendiente previa
     */
    private function validarSolicitudPendiente($validator)
    {
        $solicitudExistente = \App\Models\Solicitud::where('id_equipo', $this->id_equipo)
            ->where('id_estudiante', Auth::user()->estudiante->id_estudiante)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitudExistente) {
            $validator->errors()->add('id_equipo',
                'Ya tienes una solicitud pendiente para este equipo.'
            );
        }
    }

    /**
     * Validar que el estudiante no sea ya miembro del equipo
     */
    private function validarMiembroExistente($validator)
    {
        $esMiembro = \App\Models\MiembroEquipo::where('id_equipo', $this->id_equipo)
            ->where('id_estudiante', Auth::user()->estudiante->id_estudiante)
            ->exists();

        if ($esMiembro) {
            $validator->errors()->add('id_equipo',
                'Ya eres miembro de este equipo.'
            );
        }
    }
}