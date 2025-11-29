<?php

namespace App\Observers;

use App\Models\MiembroEquipo;
use App\Models\Actividad;

class MiembroEquipoObserver
{
    /**
     * Handle the MiembroEquipo "created" event.
     */
    public function created(MiembroEquipo $miembro): void
    {
        // Registrar actividad cuando un miembro se une
        Actividad::create([
            'tipo' => 'miembro_unido',
            'id_usuario' => $miembro->id_estudiante,
            'id_equipo' => $miembro->inscripcion->id_equipo,
            'id_evento' => $miembro->inscripcion->id_evento,
            'descripcion' => "{$miembro->user->nombre} se unió al equipo {$miembro->inscripcion->equipo->nombre}",
        ]);
    }

    /**
     * Handle the MiembroEquipo "deleted" event.
     */
    public function deleted(MiembroEquipo $miembro): void
    {
        // Registrar actividad cuando un miembro sale
        Actividad::create([
            'tipo' => 'miembro_removido',
            'id_usuario' => $miembro->id_estudiante,
            'id_equipo' => $miembro->inscripcion->id_equipo,
            'id_evento' => $miembro->inscripcion->id_evento,
            'descripcion' => "{$miembro->user->nombre} salió del equipo {$miembro->inscripcion->equipo->nombre}",
        ]);
    }
}
