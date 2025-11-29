<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    /**
     * Avances del proyecto
     */
    public function avances()
    {
        return $this->hasMany(Avance::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Tecnologías/tags del proyecto
     */
    public function tecnologias()
    {
        return $this->hasMany(ProyectoTecnologia::class, 'id_proyecto', 'id_proyecto');
    }

    /**
     * Hitos/milestones del proyecto
     */
    public function hitos()
    {
        return $this->hasMany(HitoProyecto::class, 'id_proyecto', 'id_proyecto');
    }
}
