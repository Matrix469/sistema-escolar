<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudUnion extends Model
{
    protected $table = 'solicitudes_union';
    protected $primaryKey = 'id'; // Asumiendo que 'id' es la clave primaria por defecto

    protected $fillable = [
        'equipo_id',
        'estudiante_id',
        'status',
        'mensaje',
    ];

    /**
     * Una solicitud pertenece a un equipo.
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'equipo_id', 'id_equipo');
    }

    /**
     * Una solicitud pertenece a un estudiante (usuario).
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id', 'id_usuario');
    }
}
