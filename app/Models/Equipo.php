<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $primaryKey = 'id_equipo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'ruta_imagen',
    ];

    /**
     * Obtiene todos los miembros asociados con este equipo a través de las inscripciones.
     */
    public function miembros()
    {
        return $this->hasManyThrough(
            MiembroEquipo::class,
            InscripcionEvento::class,
            'id_equipo',          // FK en inscripciones_evento
            'id_inscripcion',     // FK en miembros_equipo
            'id_equipo',          // Local key en equipos
            'id_inscripcion'      // Local key en inscripciones_evento
        );
    }

    /**
     * Recursos compartidos del equipo
     */
    public function recursos()
    {
        return $this->hasMany(RecursoEquipo::class, 'id_equipo', 'id_equipo');
    }

    /**
     * Actividades del equipo
     */
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_equipo', 'id_equipo');
    }

    /**
     * Obtiene las inscripciones a eventos para este equipo.
     */
    public function inscripciones()
    {
        return $this->hasMany(InscripcionEvento::class, 'id_equipo', 'id_equipo');
    }
}
