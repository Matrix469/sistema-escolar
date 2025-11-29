<?php

namespace App\Observers;


use App\Models\Equipo;
use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class EquipoObserver
{
    /**
     * Handle the Equipo "created" event.
     */
    public function created(Equipo $equipo): void
    {
        // Buscar la inscripción relacionada
        $inscripcion = $equipo->inscripciones()->first();
        
        if ($inscripcion && Auth::check()) {
            // Registrar actividad de equipo creado
            Actividad::create([
                'tipo' => 'equipo_creado',
                'id_usuario' => Auth::user()->id_usuario,
                'id_equipo' => $equipo->id_equipo,
                'id_evento' => $inscripcion->id_evento,
                'descripcion' => "Se creó el equipo {$equipo->nombre}",
            ]);
        }
    }
}
