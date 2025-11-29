<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstudianteStats extends Model
{
    protected $table = 'estudiante_stats';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;

    protected $fillable = [
        'id_usuario',
        'total_xp',
        'nivel',
        'eventos_participados',
        'proyectos_completados',
        'veces_lider',
    ];

    protected $casts = [
        'total_xp' => 'integer',
        'nivel' => 'integer',
        'eventos_participados' => 'integer',
        'proyectos_completados' => 'integer',
        'veces_lider' => 'integer',
    ];

    /**
     * Usuario al que pertenecen las estadísticas
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Agregar XP y actualizar nivel si es necesario
     */
    public function agregarXP($cantidad)
    {
        $this->total_xp += $cantidad;
        $this->actualizarNivel();
        $this->save();
    }

    /**
     * Calcular nivel basado en XP total
     * Fórmula: Nivel = floor(sqrt(XP / 100)) + 1
     */
    protected function actualizarNivel()
    {
        $nuevoNivel = floor(sqrt($this->total_xp / 100)) + 1;
        $this->nivel = max(1, $nuevoNivel);
    }

    /**
     * Calcular XP necesario para el siguiente nivel
     */
    public function getXpSiguienteNivelAttribute()
    {
        $siguienteNivel = $this->nivel + 1;
        return pow($siguienteNivel - 1, 2) * 100;
    }

    /**
     * Calcular XP necesario para el nivel actual
     */
    public function getXpNivelActualAttribute()
    {
        if ($this->nivel <= 1) return 0;
        return pow($this->nivel - 1, 2) * 100;
    }

    /**
     * Calcular progreso del nivel actual (0-100)
     */
    public function getProgresoNivelAttribute()
    {
        $xpNivelActual = $this->xp_nivel_actual;
        $xpSiguienteNivel = $this->xp_siguiente_nivel;
        $xpEnNivel = $this->total_xp - $xpNivelActual;
        $xpNecesario = $xpSiguienteNivel - $xpNivelActual;
        
        if ($xpNecesario <= 0) return 100;
        
        return min(100, ($xpEnNivel / $xpNecesario) * 100);
    }

    /**
     * Incrementar contador de eventos participados
     */
    public function incrementarEventos()
    {
        $this->increment('eventos_participados');
    }

    /**
     * Incrementar contador de proyectos completados
     */
    public function incrementarProyectos()
    {
        $this->increment('proyectos_completados');
    }

    /**
     * Incrementar contador de veces líder
     */
    public function incrementarLiderazgos()
    {
        $this->increment('veces_lider');
    }
}
