<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estudiante;
use App\Models\MiembroEquipo;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    /**
     * Mostrar el perfil público de un usuario
     */
    public function show(User $user)
    {
        $user->load('rolSistema');
        
        $estudiante = null;
        $equipos = collect();
        $eventos = collect();
        
        // Si es estudiante, cargar información adicional
        if ($user->rolSistema->nombre === 'estudiante') {
            $estudiante = Estudiante::where('id_usuario', $user->id_usuario)
                ->with('carrera')
                ->first();
            
            if ($estudiante) {
                // Obtener miembros de equipo del estudiante
                $miembros = MiembroEquipo::where('id_estudiante', $user->id_usuario)
                    ->with(['inscripcion.equipo', 'inscripcion.evento', 'rol'])
                    ->get();
                
                $equipos = $miembros->map(function($miembro) {
                    return [
                        'equipo' => $miembro->inscripcion->equipo,
                        'evento' => $miembro->inscripcion->evento,
                        'rol' => $miembro->rol,
                        'es_lider' => $miembro->es_lider,
                    ];
                });
                
                // Obtener eventos únicos
                $eventos = $equipos->pluck('evento')->filter()->unique('id_evento');
            }
        }
        
        return view('perfil.show', compact('user', 'estudiante', 'equipos', 'eventos'));
    }
}

