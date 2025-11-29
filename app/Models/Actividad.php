<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';
    protected $primaryKey = 'id_actividad';

    protected $fillable = [
        'tipo',
        'id_usuario',
        'id_equipo',
        'id_evento',
        'descripcion',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Usuario que generó la actividad
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Equipo relacionado (opcional)
     */
    public function equipo()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }

    /**
     * Evento relacionado (opcional)
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Scope para actividades de un evento
     */
    public function scopeDelEvento($query, $eventoId)
    {
        return $query->where('id_evento', $eventoId);
    }

    /**
     * Scope para actividades de un equipo
     */
    public function scopeDelEquipo($query, $equipoId)
    {
        return $query->where('id_equipo', $equipoId);
    }

    /**
     * Scope para actividades recientes
     */
    public function scopeRecientes($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Accessor para ícono según tipo
     */
    public function getIconoAttribute()
    {
        return match($this->tipo) {
            'equipo_creado' => '🎉',
            'miembro_unido' => '👋',
            'miembro_removido' => '👋',
            'avance_subido' => '📤',
            'avance_evaluado' => '✅',
            'hito_completado' => '🎯',
            'recurso_compartido' => '📎',
            'proyecto_actualizado' => '🔄',
            'logro_obtenido' => '🏆',
            default => '📌'
        };
    }
}
