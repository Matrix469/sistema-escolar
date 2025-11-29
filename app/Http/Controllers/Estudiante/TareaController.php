<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\TareaProyecto;
use App\Models\InscripcionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    /**
     * Obtener la inscripción del usuario actual
     */
    private function getInscripcion()
    {
        return InscripcionEvento::whereHas('miembros', function($q) {
            $q->where('id_estudiante', Auth::id());
        })->with(['equipo', 'proyecto.tareas.asignadoA.user'])->first();
    }

    /**
     * Verificar si el usuario es líder
     */
    private function esLider($inscripcion): bool
    {
        return $inscripcion->miembros()
            ->where('id_estudiante', Auth::id())
            ->where('es_lider', true)
            ->exists();
    }

    /**
     * Mostrar lista de tareas
     */
    public function index()
    {
        $inscripcion = $this->getInscripcion();
        
        if (!$inscripcion || !$inscripcion->proyecto) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('info', 'Primero debes crear el proyecto.');
        }

        $esLider = $this->esLider($inscripcion);
        $proyecto = $inscripcion->proyecto;
        $tareas = $proyecto->tareas()->with(['asignadoA.user', 'completadaPor'])->orderBy('completada')->orderBy('created_at', 'desc')->get();
        $miembros = $inscripcion->miembros;

        // Calcular progreso
        $totalTareas = $tareas->count();
        $tareasCompletadas = $tareas->where('completada', true)->count();
        $progreso = $totalTareas > 0 ? round(($tareasCompletadas / $totalTareas) * 100) : 0;

        return view('estudiante.proyecto.tareas', compact('inscripcion', 'proyecto', 'tareas', 'esLider', 'miembros', 'progreso'));
    }

    /**
     * Crear nueva tarea
     */
    public function store(Request $request)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede crear tareas.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'asignado_a' => 'nullable|exists:miembros_equipo,id_miembro',
            'fecha_limite' => 'nullable|date',
            'prioridad' => 'required|in:Alta,Media,Baja',
        ]);

        TareaProyecto::create([
            'id_proyecto' => $inscripcion->proyecto->id_proyecto,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'asignado_a' => $request->asignado_a,
            'fecha_limite' => $request->fecha_limite,
            'prioridad' => $request->prioridad,
        ]);

        return back()->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Marcar tarea como completada/pendiente
     */
    public function toggle(TareaProyecto $tarea)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || $tarea->proyecto->id_inscripcion != $inscripcion->id_inscripcion) {
            return back()->with('error', 'No tienes permiso para modificar esta tarea.');
        }

        if ($tarea->completada) {
            $tarea->marcarPendiente();
            $mensaje = 'Tarea marcada como pendiente.';
        } else {
            $tarea->marcarCompletada(Auth::user());
            $mensaje = 'Tarea marcada como completada.';
        }

        return back()->with('success', $mensaje);
    }

    /**
     * Eliminar tarea
     */
    public function destroy(TareaProyecto $tarea)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede eliminar tareas.');
        }

        if ($tarea->proyecto->id_inscripcion != $inscripcion->id_inscripcion) {
            return back()->with('error', 'No tienes permiso para eliminar esta tarea.');
        }

        $tarea->delete();

        return back()->with('success', 'Tarea eliminada exitosamente.');
    }
}
