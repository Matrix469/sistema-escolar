<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\RecursoEquipo;
use App\Models\Equipo;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecursoController extends Controller
{
    /**
     * Mostrar recursos del equipo
     */
    public function index(Equipo $equipo)
    {
        $user = Auth::user();
        
        // Verificar que es miembro del equipo
        $esMiembro = $equipo->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->exists();

        if (!$esMiembro) {
            abort(404);
        }

        $recursos = $equipo->recursos()
            ->with('subidoPor')
            ->latest()
            ->get();

        return view('estudiante.recursos.index', compact('equipo', 'recursos'));
    }

    /**
     * Agregar un recurso al equipo
     */
    public function store(Request $request, Equipo $equipo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:documento,link,video,imagen,otro',
            'url' => 'required|url|max:500',
            'descripcion' => 'nullable|string',
        ]);

        $user = Auth::user();

        $recurso = RecursoEquipo::create([
            'id_equipo' => $equipo->id_equipo,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'url' => $request->url,
            'descripcion' => $request->descripcion,
            'subido_por' => $user->id_usuario,
        ]);

        // Registrar actividad
        Actividad::create([
            'tipo' => 'recurso_compartido',
            'id_usuario' => $user->id_usuario,
            'id_equipo' => $equipo->id_equipo,
            'descripcion' => "Compartió el recurso: {$recurso->nombre}",
        ]);

        return back()->with('success', 'Recurso compartido correctamente.');
    }

    /**
     * Eliminar un recurso
     */
    public function destroy(RecursoEquipo $recurso)
    {
        $user = Auth::user();

        // Solo el que lo subió o el líder puede eliminar
        $esCreador = $recurso->subido_por === $user->id_usuario;
        $esLider = $recurso->equipo->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->exists();

        if (!$esCreador && !$esLider) {
            return back()->with('error', 'No tienes permiso para eliminar este recurso.');
        }

        $recurso->delete();
        return back()->with('success', 'Recurso eliminado.');
    }
}
