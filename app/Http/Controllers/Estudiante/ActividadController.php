<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use App\Models\Evento;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActividadController extends Controller
{
    /**
     * Feed de actividad de un evento
     */
    public function feedEvento(Evento $evento)
    {
        $actividades = Actividad::where('id_evento', $evento->id_evento)
            ->with(['usuario', 'equipo'])
            ->recientes(50)
            ->get();

        return view('estudiante.actividades.feed-evento', compact('evento', 'actividades'));
    }

    /**
     * Feed de actividad de un equipo
     */
    public function feedEquipo(Equipo $equipo)
    {
        $user = Auth::user();
        
        // Verificar que es miembro
        $esMiembro = $equipo->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->exists();

        if (!$esMiembro) {
            abort(404);
        }

        $actividades = Actividad::where('id_equipo', $equipo->id_equipo)
            ->with('usuario')
            ->recientes(30)
            ->get();

        return view('estudiante.actividades.feed-equipo', compact('equipo', 'actividades'));
    }

    /**
     * Registrar actividad manual (para eventos especiales)
     */
    public static function registrar($tipo, $descripcion, $usuarioId, $equipoId = null, $eventoId = null, $metadata = null)
    {
        return Actividad::create([
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'id_usuario' => $usuarioId,
            'id_equipo' => $equipoId,
            'id_evento' => $eventoId,
            'metadata' => $metadata,
        ]);
    }
}
