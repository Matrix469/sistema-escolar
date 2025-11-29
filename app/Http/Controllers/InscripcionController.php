<?php

namespace App\Http\Controllers;

use App\Models\InscripcionEvento;
use App\Models\MiembroEquipo;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InscripcionController extends Controller
{
    /**
     * Permite a un estudiante unirse a un equipo de una inscripción a un evento.
     * Valida que el estudiante no esté en otro evento con fechas superpuestas.
     */
    public function unirse(Request $request, InscripcionEvento $inscripcion)
    {
        $user = Auth::user();

        //? Verificamos que el usuario sea un estudiante
        if (!$user->esEstudiante()) {
            return back()->with('error', 'Solo los estudiantes pueden unirse a un equipo.');
        }

        $idEstudiante = $user->id_usuario;
        $eventoNuevo = $inscripcion->evento;

        //? El estudiante no esté en otro evento con fechas superpuestas
        $eventosPrevios = Evento::whereHas('inscripciones.miembros', function ($query) use ($idEstudiante) {
            $query->where('id_estudiante', $idEstudiante);
        })->get();

        foreach ($eventosPrevios as $eventoPrevio) {
            $seSuperponen = ($eventoNuevo->fecha_inicio <= $eventoPrevio->fecha_fin) && 
                              ($eventoNuevo->fecha_fin >= $eventoPrevio->fecha_inicio);

            if ($seSuperponen) {
                // Lanzar una excepción de validación o redirigir con error
                throw ValidationException::withMessages([
                   'evento' => "No puedes unirte a este equipo porque las fechas del evento '{$eventoNuevo->nombre}' se superponen con el evento '{$eventoPrevio->nombre}' en el que ya estás registrado.",
                ]);
            }
        }
        
        //?Crear el miembro de equipo (si pasa la validación)
        // TODO: Obtener el id_rol_equipo de "Participante" desde la BD en lugar de hardcodear '4'.
        MiembroEquipo::create([
            'id_inscripcion' => $inscripcion->id_inscripcion,
            'id_estudiante' => $idEstudiante,
            'id_rol_equipo' => 4, // Asumimos 4 = Participante
            'es_lider' => false,
        ]);

        // Actualizar el estado del equipo 
        $inscripcion->actualizarEstadoCompletitud();
        return redirect()->back()->with('success', 'Te has unido al equipo exitosamente.');
    }


    public function index(){}
    public function create(){}
    public function store(Request $request){}
    public function show(string $id){}
    public function edit(string $id){}
    public function update(Request $request, string $id){}
    public function destroy(string $id){}
}