<?php

namespace App\Services;

use App\Models\User;
use App\Models\Logro;
use App\Models\UsuarioLogro;
use App\Models\EstudianteStats;

class LogroService
{
    /**
     * Verificar y otorgar logros a un estudiante
     */
    public static function verificarLogros(User $estudiante, ?int $eventoId = null): array
    {
        $logrosObtenidos = [];
        $stats = $estudiante->stats ?? EstudianteStats::create(['id_usuario' => $estudiante->id_usuario]);
        
        // Verificar cada tipo de logro
        $logros = Logro::all();
        
        foreach ($logros as $logro) {
            // Si ya tiene el logro, skip
            if ($estudiante->logros()->where('id_logro', $logro->id_logro)->exists()) {
                continue;
            }
            
            $cumpleCondicion = false;
            
            switch ($logro->condicion) {
                case 'primer_evento':
                    $cumpleCondicion = $stats->eventos_participados >= 1;
                    break;
                    
                case 'participacion_3_eventos':
                    $cumpleCondicion = $stats->eventos_participados >= 3;
                    break;
                    
                case 'participacion_5_eventos':
                    $cumpleCondicion = $stats->eventos_participados >= 5;
                    break;
                    
                case 'primer_lider':
                    $cumpleCondicion = $stats->veces_lider >= 1;
                    break;
                    
                case 'lider_3_veces':
                    $cumpleCondicion = $stats->veces_lider >= 3;
                    break;
                    
                case 'lider_5_veces':
                    $cumpleCondicion = $stats->veces_lider >= 5;
                    break;
                    
                case 'proyecto_completado':
                    $cumpleCondicion = $stats->proyectos_completados >= 1;
                    break;
                    
                // Lógica para logros de lugares (se otorgan manualmente)
                case 'primer_lugar':
                case 'segundo_lugar':
                case 'tercer_lugar':
                    // Estos se otorgan desde el controlador de eventos cuando se asignan ganadores
                    break;
            }
            
            if ($cumpleCondicion) {
                // Otorgar logro
                UsuarioLogro::create([
                    'id_usuario' => $estudiante->id_usuario,
                    'id_logro' => $logro->id_logro,
                    'id_evento' => $eventoId,
                ]);
                
                // Agregar XP
                $stats->agregarXP($logro->puntos_xp);
                
                $logrosObtenidos[] = $logro;
            }
        }
        
        return $logrosObtenidos;
    }
    
    /**
     * Otorgar logro manualmente (para ganadores)
     */
    public static function otorgarLogro(User $estudiante, string $condicion, int $eventoId): bool
    {
        $logro = Logro::where('condicion', $condicion)->first();
        
        if (!$logro) {
            return false;
        }
        
        // Verificar si ya lo tiene
        if ($estudiante->logros()->where('id_logro', $logro->id_logro)->exists()) {
            return false;
        }
        
        // Otorgar
        UsuarioLogro::create([
            'id_usuario' => $estudiante->id_usuario,
            'id_logro' => $logro->id_logro,
            'id_evento' => $eventoId,
        ]);
        
        // Agregar XP
        $stats = $estudiante->stats ?? EstudianteStats::create(['id_usuario' => $estudiante->id_usuario]);
        $stats->agregarXP($logro->puntos_xp);
        
        return true;
    }
}
