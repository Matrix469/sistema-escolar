<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\InscripcionEvento;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MisProyectosController extends Controller
{
    /**
     * Mostrar todos los proyectos del estudiante
     */
    public function index()
    {
        $user = Auth::user();

        // Obtener todas las inscripciones del estudiante que tienen proyecto
        $inscripciones = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })
        ->whereHas('proyecto') // Solo inscripciones con proyecto
        ->with([
            'equipo',
            'evento' => function ($query) {
                $query->withTrashed();
            },
            'proyecto.tareas',
            'proyecto.avances',
            'miembros.user',
        ])
        ->get();

        // Preparar datos de cada proyecto
        $proyectosData = $inscripciones->map(function ($inscripcion) use ($user) {
            $miembro = $inscripcion->miembros->firstWhere('id_estudiante', $user->id_usuario);
            $esLider = $miembro ? $miembro->es_lider : false;
            
            $proyecto = $inscripcion->proyecto;
            
            // Calcular estadísticas del proyecto
            $totalTareas = $proyecto->tareas->count();
            $tareasCompletadas = $proyecto->tareas->where('completada', true)->count();
            $porcentajeTareas = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;
            
            $totalAvances = $proyecto->avances->count();
            
            return [
                'inscripcion' => $inscripcion,
                'proyecto' => $proyecto,
                'equipo' => $inscripcion->equipo,
                'evento' => $inscripcion->evento,
                'esLider' => $esLider,
                'totalTareas' => $totalTareas,
                'tareasCompletadas' => $tareasCompletadas,
                'porcentajeTareas' => $porcentajeTareas,
                'totalAvances' => $totalAvances,
            ];
        });

        return view('estudiante.proyecto.index', [
            'proyectos' => $proyectosData,
        ]);
    }
}
