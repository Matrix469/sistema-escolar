<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    /**
     * Dashboard de estadísticas del estudiante
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Obtener o crear stats
        $stats = $user->stats ?? \App\Models\EstudianteStats::create([
            'id_usuario' => $user->id_usuario,
        ]);
        
        // Logros recientes (últimos 5)
        $logrosRecientes = $user->logros()
            ->orderBy('usuario_logros.fecha_obtencion', 'desc')
            ->take(5)
            ->get();
        
        $logrosCount = $user->logros()->count();
        
        // Habilidades del estudiante
        $habilidades = $user->habilidades()->take(10)->get();
        
        return view('estudiante.stats.dashboard', compact(
            'stats',
            'logrosRecientes',
            'logrosCount',
            'habilidades'
        ));
    }
}
