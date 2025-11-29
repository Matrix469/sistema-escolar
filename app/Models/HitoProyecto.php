<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HitoProyecto extends Model
{
    protected $table = 'hitos_proyecto';
    protected $primaryKey = 'id_hito';

    protected $fillable = [
        'id_proyecto',
        'titulo',
        'descripcion',
        'fecha_limite',
        'completado',
        'fecha_completado',
        'orden',
        'completado_por',
    ];

    protected $casts = [
        'fecha_limite' => 'datetime',
        'fecha_completado' => 'datetime',
        'completado' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * Proyecto al que pertenece el hito
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Usuario que completó el hito
     */
    public function completadoPor()
    {
        return $this->belongsTo(User::class, 'completado_por', 'id_usuario');
    }

    /**
     * Marcar hito como completado
     */
    public function marcarCompletado($usuarioId)
    {
        $this->update([
            'completado' => true,
            'fecha_completado' => now(),
            'completado_por' => $usuarioId,
        ]);
    }

    /**
     * Scope para hitos completados
     */
    public function scopeCompletados($query)
    {
        return $query->where('completado', true);
    }

    /**
     * Scope para hitos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('completado', false);
    }

    /**
     * Scope ordenado por orden
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }
}
