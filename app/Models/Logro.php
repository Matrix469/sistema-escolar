<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    protected $table = 'logros';
    protected $primaryKey = 'id_logro';

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'tipo',
        'condicion',
        'puntos_xp',
    ];

    protected $casts = [
        'puntos_xp' => 'integer',
    ];

    /**
     * Usuarios que han obtenido este logro
     */
    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'usuario_logros',
            'id_logro',
            'id_usuario'
        )->withPivot('fecha_obtencion', 'id_evento');
    }

    /**
     * Scope para filtrar por tipo
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para ordenar por puntos XP
     */
    public function scopeOrdenarPorXP($query, $direccion = 'desc')
    {
        return $query->orderBy('puntos_xp', $direccion);
    }
}
