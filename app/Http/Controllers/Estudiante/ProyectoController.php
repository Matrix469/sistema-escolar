<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use App\Models\InscripcionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    /**
     * Obtener la inscripción del usuario actual
     */
    private function getInscripcion()
    {
        return InscripcionEvento::whereHas('miembros', function($q) {
            $q->where('id_estudiante', Auth::id());
        })->with(['equipo', 'evento', 'proyecto'])->first();
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
     * Mostrar el proyecto del equipo
     */
    public function show()
    {
        $inscripcion = $this->getInscripcion();
        
        if (!$inscripcion) {
            return redirect()->route('estudiante.eventos.index')
                ->with('info', 'No estás inscrito en ningún evento activo.');
        }

        $esLider = $this->esLider($inscripcion);
        $proyecto = $inscripcion->proyecto;

        return view('estudiante.proyecto.show', compact('inscripcion', 'proyecto', 'esLider'));
    }

    /**
     * Formulario para crear proyecto
     */
    public function create()
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('error', 'Solo el líder puede crear el proyecto.');
        }

        if ($inscripcion->proyecto) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('info', 'El equipo ya tiene un proyecto creado.');
        }

        return view('estudiante.proyecto.form', compact('inscripcion'));
    }

    /**
     * Guardar nuevo proyecto
     */
    public function store(Request $request)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede crear el proyecto.');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion_tecnica' => 'nullable|string',
            'repositorio_url' => 'nullable|url|max:255',
        ]);

        Proyecto::create([
            'id_inscripcion' => $inscripcion->id_inscripcion,
            'nombre' => $request->nombre,
            'descripcion_tecnica' => $request->descripcion_tecnica,
            'repositorio_url' => $request->repositorio_url,
        ]);

        return redirect()->route('estudiante.proyecto.show')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Formulario para editar proyecto
     */
    public function edit()
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return redirect()->route('estudiante.proyecto.show')
                ->with('error', 'Solo el líder puede editar el proyecto.');
        }

        $proyecto = $inscripcion->proyecto;

        if (!$proyecto) {
            return redirect()->route('estudiante.proyecto.create');
        }

        return view('estudiante.proyecto.form', compact('inscripcion', 'proyecto'));
    }

    /**
     * Actualizar proyecto
     */
    public function update(Request $request)
    {
        $inscripcion = $this->getInscripcion();

        if (!$inscripcion || !$this->esLider($inscripcion)) {
            return back()->with('error', 'Solo el líder puede editar el proyecto.');
        }

        $proyecto = $inscripcion->proyecto;

        if (!$proyecto) {
            return redirect()->route('estudiante.proyecto.create');
        }

        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion_tecnica' => 'nullable|string',
            'repositorio_url' => 'nullable|url|max:255',
        ]);

        $proyecto->update([
            'nombre' => $request->nombre,
            'descripcion_tecnica' => $request->descripcion_tecnica,
            'repositorio_url' => $request->repositorio_url,
        ]);

        return redirect()->route('estudiante.proyecto.show')
            ->with('success', 'Proyecto actualizado exitosamente.');
    }
}
