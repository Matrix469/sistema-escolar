<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioLogro extends Model
{
    protected $table = 'usuario_logros';
    protected $primaryKey = 'id_usuario_logro';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_logro',
        'fecha_obtencion',
        'id_evento',
    ];

    protected $casts = [
        'fecha_obtencion' => 'datetime',
    ];

    /**
     * Usuario que obtuvo el logro
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Logro obtenido
     */
    public function logro()
    {
        return $this->belongsTo(Logro::class, 'id_logro', 'id_logro');
    }

    /**
     * Evento en el que se obtuvo (opcional)
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }
}
