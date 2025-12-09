<?php

namespace App\Services;

use App\Models\User;
use App\Models\MiembroEquipo;
use App\Models\InscripcionEvento;
use App\Models\Evento;
use App\Models\Evaluacion;
use App\Models\EvaluacionAvance;

class UserValidationService
{
    /**
     * Verificar si un estudiante puede cambiar de rol
     */
    public function canChangeStudentRole(User $user): array
    {
        $reasons = [];
        $canChange = true;
        
        if (!$user->estudiante) {
            return ['canChange' => true, 'reasons' => []];
        }

        $idUsuario = $user->id_usuario;

        // Obtener eventos donde el estudiante está inscrito a través de miembros_equipo
        $eventosActivos = Evento::whereIn('estado', ['Activo', 'Próximo', 'En Progreso'])
            ->whereHas('inscripciones.miembros', function ($query) use ($idUsuario) {
                $query->where('id_estudiante', $idUsuario);
            })
            ->get();

        if ($eventosActivos->isNotEmpty()) {
            $canChange = false;
            
            foreach ($eventosActivos as $evento) {
                $reasons[] = [
                    'type' => 'evento_activo',
                    'message' => "Inscrito en evento '{$evento->nombre}' ({$evento->estado})",
                    'icon' => 'calendar-alt',
                    'severity' => 'error'
                ];
            }
        }

        // Verificar si está en algún equipo activo
        $miembrosEquipo = MiembroEquipo::where('id_estudiante', $idUsuario)
            ->whereHas('inscripcion.evento', function ($query) {
                $query->whereIn('estado', ['Activo', 'Próximo', 'En Progreso']);
            })
            ->with(['inscripcion.equipo', 'inscripcion.evento'])
            ->get();

        if ($miembrosEquipo->isNotEmpty()) {
            foreach ($miembrosEquipo as $miembro) {
                $equipo = $miembro->inscripcion->equipo ?? null;
                $evento = $miembro->inscripcion->evento ?? null;
                
                if ($equipo && $evento) {
                    $reasons[] = [
                        'type' => 'equipo_activo',
                        'message' => "Miembro del equipo '{$equipo->nombre}' en evento '{$evento->nombre}'",
                        'icon' => 'users',
                        'severity' => 'error'
                    ];
                }
            }
            $canChange = false;
        }

        return ['canChange' => $canChange, 'reasons' => $reasons];
    }

    /**
     * Verificar si un estudiante puede ser eliminado
     */
    public function canDeleteStudent(User $user): array
    {
        $reasons = [];
        $canDelete = true;
        $requiresLeadershipTransfer = false;
        $leadershipInfo = [];

        if (!$user->estudiante) {
            return ['canDelete' => true, 'reasons' => [], 'requiresLeadershipTransfer' => false];
        }

        $idUsuario = $user->id_usuario;

        // Verificar si está en eventos en progreso
        $eventosEnProgreso = Evento::where('estado', 'En Progreso')
            ->whereHas('inscripciones.miembros', function ($query) use ($idUsuario) {
                $query->where('id_estudiante', $idUsuario);
            })
            ->get();

        if ($eventosEnProgreso->isNotEmpty()) {
            $canDelete = false;
            foreach ($eventosEnProgreso as $evento) {
                $reasons[] = [
                    'type' => 'evento_progreso',
                    'message' => "Participando en evento en progreso: '{$evento->nombre}'",
                    'icon' => 'spinner',
                    'severity' => 'error'
                ];
            }
        }

        // Verificar si es líder de algún equipo
        $liderazgos = MiembroEquipo::where('id_estudiante', $idUsuario)
            ->where('es_lider', true)
            ->whereHas('inscripcion.evento', function ($query) {
                $query->whereIn('estado', ['Activo', 'Próximo', 'En Progreso']);
            })
            ->with(['inscripcion.equipo', 'inscripcion.miembros.user', 'inscripcion.evento'])
            ->get();

        if ($liderazgos->isNotEmpty()) {
            $requiresLeadershipTransfer = true;
            
            foreach ($liderazgos as $liderazgo) {
                $equipo = $liderazgo->inscripcion->equipo;
                $evento = $liderazgo->inscripcion->evento;
                
                // Obtener otros miembros que pueden ser líderes
                $otrosMiembros = $liderazgo->inscripcion->miembros
                    ->where('id_estudiante', '!=', $idUsuario)
                    ->map(function ($m) {
                        return [
                            'id_miembro' => $m->id_miembro,
                            'id_estudiante' => $m->id_estudiante,
                            'nombre' => $m->user->nombre_completo ?? $m->user->nombre
                        ];
                    });

                $leadershipInfo[] = [
                    'equipo_id' => $equipo->id_equipo,
                    'equipo_nombre' => $equipo->nombre,
                    'evento_nombre' => $evento->nombre,
                    'miembros_disponibles' => $otrosMiembros->values()->toArray(),
                    'inscripcion_id' => $liderazgo->id_inscripcion
                ];

                $reasons[] = [
                    'type' => 'es_lider',
                    'message' => "Es líder del equipo '{$equipo->nombre}' en '{$evento->nombre}'",
                    'icon' => 'crown',
                    'severity' => 'warning'
                ];
            }
        }

        return [
            'canDelete' => $canDelete,
            'reasons' => $reasons,
            'requiresLeadershipTransfer' => $requiresLeadershipTransfer,
            'leadershipInfo' => $leadershipInfo
        ];
    }

    /**
     * Verificar si un jurado puede cambiar a estudiante
     */
    public function canChangeJuradoToStudent(User $user): array
    {
        $reasons = [];
        $canChange = true;

        if (!$user->jurado) {
            return ['canChange' => true, 'reasons' => []];
        }

        $idUsuario = $user->id_usuario;

        // Verificar evaluaciones pendientes (no finalizadas)
        $evaluacionesPendientes = Evaluacion::where('id_jurado', $idUsuario)
            ->where('estado', '!=', 'Finalizada')
            ->with('inscripcion.evento', 'inscripcion.equipo')
            ->get();

        if ($evaluacionesPendientes->isNotEmpty()) {
            $canChange = false;
            foreach ($evaluacionesPendientes as $eval) {
                $evento = $eval->inscripcion->evento ?? null;
                $equipo = $eval->inscripcion->equipo ?? null;
                $equipoNombre = $equipo->nombre ?? 'N/A';
                $eventoNombre = $evento->nombre ?? 'N/A';
                $reasons[] = [
                    'type' => 'evaluacion_pendiente',
                    'message' => "Evaluación pendiente: equipo '" . $equipoNombre . "' en '" . $eventoNombre . "'",
                    'icon' => 'clipboard-check',
                    'severity' => 'error'
                ];
            }
        }

        // Verificar eventos asignados activos
        $eventosAsignados = $user->jurado->eventos()
            ->whereIn('eventos.estado', ['Activo', 'En Progreso'])
            ->get();

        if ($eventosAsignados->isNotEmpty()) {
            $canChange = false;
            foreach ($eventosAsignados as $evento) {
                $reasons[] = [
                    'type' => 'evento_asignado',
                    'message' => "Asignado como jurado en evento activo: '{$evento->nombre}'",
                    'icon' => 'gavel',
                    'severity' => 'error'
                ];
            }
        }

        // Verificar evaluaciones de avances pendientes
        $avancesPendientes = EvaluacionAvance::where('id_jurado', $idUsuario)
            ->whereNull('calificacion')
            ->with('avance.proyecto.inscripcion.evento')
            ->get();

        if ($avancesPendientes->isNotEmpty()) {
            $canChange = false;
            foreach ($avancesPendientes as $eval) {
                $avance = $eval->avance ?? null;
                $proyecto = $avance->proyecto ?? null;
                $evento = $proyecto->inscripcion->evento ?? null;
                
                $eventoNombre = $evento->nombre ?? 'N/A';
                $reasons[] = [
                    'type' => 'avance_pendiente',
                    'message' => "Evaluación de avance pendiente en '" . $eventoNombre . "'",
                    'icon' => 'tasks',
                    'severity' => 'error'
                ];
            }
        }

        return ['canChange' => $canChange, 'reasons' => $reasons];
    }

    /**
     * Verificar si un jurado puede ser eliminado
     */
    public function canDeleteJurado(User $user): array
    {
        // Reutilizamos la misma lógica que cambio de rol
        $result = $this->canChangeJuradoToStudent($user);
        
        return [
            'canDelete' => $result['canChange'],
            'reasons' => $result['reasons']
        ];
    }

    /**
     * Transferir liderazgo de un equipo a otro miembro
     */
    public function transferLeadership(int $inscripcionId, int $nuevoLiderId): bool
    {
        // Quitar liderazgo actual
        MiembroEquipo::where('id_inscripcion', $inscripcionId)
            ->where('es_lider', true)
            ->update(['es_lider' => false]);

        // Asignar nuevo líder
        $updated = MiembroEquipo::where('id_inscripcion', $inscripcionId)
            ->where('id_estudiante', $nuevoLiderId)
            ->update(['es_lider' => true]);

        return $updated > 0;
    }

    /**
     * Obtener el rol actual del usuario en texto
     */
    public function getCurrentRoleType(User $user): string
    {
        if ($user->estudiante) {
            return 'estudiante';
        } elseif ($user->jurado) {
            return 'jurado';
        } else {
            return 'admin';
        }
    }
}
