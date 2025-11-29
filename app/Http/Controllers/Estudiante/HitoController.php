<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\HitoProyecto;
use App\Models\Proyecto;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HitoController extends Controller
{
    /**
     * Crear un hito para el proyecto del equipo
     */
    public function store(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'orden' => 'nullable|integer',
        ]);

        // Verificar que el usuario es del equipo
        $user = Auth::user();
        $esMiembro = $proyecto->inscripcion->equipo->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->exists();

        if (!$esMiembro) {
            return back()->with('error', 'No tienes permiso para crear hitos en este proyecto.');
        }

        $hito = HitoProyecto::create([
            'id_proyecto' => $proyecto->id_proyecto,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_limite' => $request->fecha_limite,
            'orden' => $request->orden ?? 0,
        ]);

        // Registrar actividad
        Actividad::create([
            'tipo' => 'hito_completado',
            'id_usuario' => $user->id_usuario,
            'id_equipo' => $proyecto->inscripcion->id_equipo,
            'id_evento' => $proyecto->inscripcion->id_evento,
            'descripcion' => "Creó el hito: {$hito->titulo}",
        ]);

        return back()->with('success', 'Hito creado correctamente.');
    }

    /**
     * Marcar un hito como completado
     */
    public function marcarCompletado(HitoProyecto $hito)
    {
        $user = Auth::user();

        $hito->marcarCompletado($user->id_usuario);

        // Registrar actividad
        Actividad::create([
            'tipo' => 'hito_completado',
            'id_usuario' => $user->id_usuario,
            'id_equipo' => $hito->proyecto->inscripcion->id_equipo,
            'id_evento' => $hito->proyecto->inscripcion->id_evento,
            'descripcion' => "Completó el hito: {$hito->titulo}",
        ]);

        return back()->with('success', 'Hito marcado como completado.');
    }

    /**
     * Actualizar un hito
     */
    public function update(Request $request, HitoProyecto $hito)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'nullable|date',
        ]);

        $hito->update($request->only(['titulo', 'descripcion', 'fecha_limite']));

        return back()->with('success', 'Hito actualizado correctamente.');
    }

    /**
     * Eliminar un hito
     */
    public function destroy(HitoProyecto $hito)
    {
        $hito->delete();
        return back()->with('success', 'Hito eliminado.');
    }
}
