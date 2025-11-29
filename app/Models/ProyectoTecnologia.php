<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoTecnologia extends Model
{
    protected $table = 'proyecto_tecnologias';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_proyecto',
        'tecnologia',
        'color',
    ];

    /**
     * Proyecto al que pertenece esta tecnología
     */
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }
}
