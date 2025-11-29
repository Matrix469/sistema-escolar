<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatHabilidad extends Model
{
    protected $table = 'cat_habilidades';
    protected $primaryKey = 'id_habilidad';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'categoria',
        'icono',
        'color',
    ];

    /**
     * Estudiantes que tienen esta habilidad
     */
    public function estudiantes()
    {
        return $this->belongsToMany(
            User::class,
            'estudiante_habilidades',
            'id_habilidad',
            'id_usuario'
        )->withPivot('nivel')->withTimestamps();
    }

    /**
     * Scope para filtrar por categoría
     */
    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }
}
