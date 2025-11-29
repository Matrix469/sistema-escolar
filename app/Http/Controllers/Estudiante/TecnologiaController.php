<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\ProyectoTecnologia;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TecnologiaController extends Controller
{
    /**
     * Agregar tecnología a un proyecto
     */
    public function store(Request $request, Proyecto $proyecto)
    {
        $request->validate([
            'tecnologia' => 'required|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        
        // Verificar que es del equipo
        $esMiembro = $proyecto->inscripcion->equipo->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->exists();

        if (!$esMiembro) {
            return back()->with('error', 'No tienes permiso para editar este proyecto.');
        }

        // Verificar si ya existe
        if ($proyecto->tecnologias()->where('tecnologia', $request->tecnologia)->exists()) {
            return back()->with('error', 'Esta tecnología ya está agregada.');
        }

        ProyectoTecnologia::create([
            'id_proyecto' => $proyecto->id_proyecto,
            'tecnologia' => $request->tecnologia,
            'color' => $request->color ?? '#10b981',
        ]);

        return back()->with('success', 'Tecnología agregada al proyecto.');
    }

    /**
     * Eliminar tecnología de un proyecto
     */
    public function destroy(Proyecto $proyecto, $tecnologia)
    {
        $user = Auth::user();
        
        // Verificar que es del equipo o líder
        $esLider = $proyecto->inscripcion->equipo->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->exists();

        if (!$esLider) {
            return back()->with('error', 'Solo el líder puede eliminar tecnologías.');
        }

        $proyecto->tecnologias()->where('tecnologia', $tecnologia)->delete();

        return back()->with('success', 'Tecnología eliminada.');
    }
}
