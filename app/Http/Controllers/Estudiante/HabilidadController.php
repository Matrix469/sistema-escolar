<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\CatHabilidad;
use App\Models\EstudianteStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabilidadController extends Controller
{
    /**
     * Mostrar las habilidades del estudiante
     */
    public function index()
    {
        $user = Auth::user();
        
        // Habilidades del estudiante con nivel
        $misHabilidades = $user->habilidades()
            ->orderBy('cat_habilidades.categoria')
            ->get();
        
        // Todas las habilidades disponibles agrupadas por categoría
        $habilidadesDisponibles = CatHabilidad::orderBy('categoria')
            ->orderBy('nombre')
            ->get()
            ->groupBy('categoria');
        
        return view('estudiante.habilidades.index', compact('misHabilidades', 'habilidadesDisponibles'));
    }

    /**
     * Agregar una habilidad al perfil del estudiante
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_habilidad' => 'required|exists:cat_habilidades,id_habilidad',
            'nivel' => 'required|in:Básico,Intermedio,Avanzado,Experto',
        ]);

        $user = Auth::user();
        
        // Verificar si ya tiene esta habilidad
        if ($user->habilidades()->where('cat_habilidades.id_habilidad', $request->id_habilidad)->exists()) {
            return back()->with('error', 'Ya tienes esta habilidad en tu perfil.');
        }

        // Agregar habilidad
        $user->habilidades()->attach($request->id_habilidad, [
            'nivel' => $request->nivel,
        ]);

        return back()->with('success', 'Habilidad agregada correctamente.');
    }

    /**
     * Actualizar el nivel de una habilidad
     */
    public function update(Request $request, $habilidadId)
    {
        $request->validate([
            'nivel' => 'required|in:Básico,Intermedio,Avanzado,Experto',
        ]);

        $user = Auth::user();
        
        $user->habilidades()->updateExistingPivot($habilidadId, [
            'nivel' => $request->nivel,
        ]);

        return back()->with('success', 'Nivel de habilidad actualizado.');
    }

    /**
     * Eliminar una habilidad del perfil
     */
    public function destroy($habilidadId)
    {
        $user = Auth::user();
        $user->habilidades()->detach($habilidadId);

        return back()->with('success', 'Habilidad eliminada de tu perfil.');
    }
}
