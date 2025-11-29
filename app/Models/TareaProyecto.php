<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaProyecto extends Model
{
    protected $table = 'tareas_proyecto';
    protected $primaryKey = 'id_tarea';
    
    protected $fillable = [
        'id_proyecto',
        'nombre',
        'descripcion',
        'asignado_a',
        'completada',
        'completada_por',
        'fecha_completada',
        'fecha_limite',
        'prioridad',
    ];

    protected $casts = [
        'completada' => 'boolean',
        'fecha_completada' => 'datetime',
        'fecha_limite' => 'date',
    ];

    //? Relaciones
    
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }

    public function asignadoA(): BelongsTo
    {
        return $this->belongsTo(MiembroEquipo::class, 'asignado_a', 'id_miembro');
    }

    public function completadaPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completada_por', 'id_usuario');
    }

    //! Scopes

    public function scopePendientes($query)
    {
        return $query->where('completada', false);
    }

    public function scopeCompletadas($query)
    {
        return $query->where('completada', true);
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    //TODO Métodos Helper

    /**
     * Marcar tarea como completada
     */
    public function marcarCompletada(User $usuario)
    {
        $this->update([
            'completada' => true,
            'completada_por' => $usuario->id_usuario,
            'fecha_completada' => now(),
        ]);
    }

    /**
     * Marcar tarea como pendiente
     */
    public function marcarPendiente()
    {
        $this->update([
            'completada' => false,
            'completada_por' => null,
            'fecha_completada' => null,
        ]);
    }

    /**
     * Verificar si está vencida
     */
    public function estaVencida(): bool
    {
        if (!$this->fecha_limite || $this->completada) {
            return false;
        }
        
        return $this->fecha_limite->isPast();
    }

    /**
     * Obtener clase de CSS según prioridad
     */
    public function getColorPrioridad(): string
    {
        return match($this->prioridad) {
            'Alta' => 'text-red-600 bg-red-100',
            'Media' => 'text-yellow-600 bg-yellow-100',
            'Baja' => 'text-green-600 bg-green-100',
            default => 'text-gray-600 bg-gray-100',
        };
    }
}
