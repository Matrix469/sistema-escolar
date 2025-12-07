<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiembroEquipo extends Model
{
    protected $table = 'miembros_equipo';
    protected $primaryKey = 'id_miembro';
    public $timestamps = false;

    protected $fillable = [
        'id_inscripcion',
        'id_estudiante',
        'id_rol_equipo',
        'es_lider',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id_miembro';
    }

    public function rol()
    {
        return $this->belongsTo(CatRolEquipo::class, 'id_rol_equipo', 'id_rol_equipo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_estudiante', 'id_usuario');
    }

    public function inscripcion()
    {
        return $this->belongsTo(InscripcionEvento::class, 'id_inscripcion', 'id_inscripcion');
    }
}
