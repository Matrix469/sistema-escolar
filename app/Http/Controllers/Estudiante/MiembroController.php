<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\MiembroEquipo;
use App\Models\SolicitudUnion;
use App\Models\CatRolEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MiembroController extends Controller
{
    /**
     * Update the role of a team member.
     */
    public function updateRole(Request $request, MiembroEquipo $miembro)
    {
        $request->validate([
            'id_rol_equipo' => 'required|exists:cat_roles_equipo,id_rol_equipo',
        ]);

        $user = Auth::user();
        $inscripcion = $miembro->inscripcion;
        $esLider = $inscripcion->equipo->miembros()->where('id_estudiante', $user->id_usuario)->where('es_lider', true)->exists();

        // Autorización: solo el líder puede cambiar roles.
        if (!$esLider) {
            return back()->with('error', 'No tienes permiso para cambiar roles.');
        }

        // Un líder no puede cambiar su propio rol.
        if ($miembro->es_lider) {
            return back()->with('error', 'El rol del líder no se puede cambiar.');
        }

        // Bloquear la asignación del rol "Líder" manualmente
        $rolLider = CatRolEquipo::where('nombre', 'Líder')->first();
        if ($rolLider && $request->id_rol_equipo == $rolLider->id_rol_equipo) {
            return back()->with('error', 'No puedes asignar el rol de Líder manualmente. Usa la opción de transferir liderazgo.');
        }

        $miembro->update(['id_rol_equipo' => $request->id_rol_equipo]);

        return back()->with('success', 'Rol del miembro actualizado correctamente.');
    }

    /**
     * Remove a member from the team.
     */
    public function destroy(MiembroEquipo $miembro)
    {
        $user = Auth::user();
        $inscripcion = $miembro->inscripcion;
        $equipo = $inscripcion->equipo;
        $esLider = $equipo->miembros()->where('id_estudiante', $user->id_usuario)->where('es_lider', true)->exists();

        // Autorización: solo el líder puede eliminar miembros.
        if (!$esLider) {
            return back()->with('error', 'No tienes permiso para eliminar miembros.');
        }

        // Edge case: un líder no puede eliminarse a sí mismo.
        if ($miembro->id_estudiante == $user->id_usuario) {
            return back()->with('error', 'No puedes eliminarte a ti mismo del equipo.');
        }

        try {
            DB::transaction(function () use ($miembro, $inscripcion) {
                $estudianteId = $miembro->id_estudiante;
                $eventoId = $inscripcion->id_evento;

                $miembro->delete();

                SolicitudUnion::where('estudiante_id', $estudianteId)
                    ->whereHas('equipo.inscripciones', function($q) use ($eventoId) {
                        $q->where('id_evento', $eventoId);
                    })
                    ->delete();
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al eliminar al miembro: ' . $e->getMessage());
        }

        return back()->with('success', 'Miembro eliminado del equipo.');
    }

    /**
     * Permitir que un miembro se salga del equipo por su propia voluntad
     */
    public function leave()
    {
        $user = Auth::user();

        $miembro = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion.evento', function ($query) {
                $query->whereIn('estado', ['Próximo', 'Activo', 'Cerrado']);
            })
            ->with('inscripcion')
            ->first();

        if (!$miembro) {
            return back()->with('error', 'No perteneces a ningún equipo activo.');
        }

        if ($miembro->es_lider) {
            return back()->with('error', 'Como líder, no puedes abandonar el equipo. Debes transferir el liderazgo primero.');
        }

        try {
            DB::transaction(function () use ($miembro) {
                $estudianteId = $miembro->id_estudiante;
                $eventoId = $miembro->inscripcion->id_evento;

                $miembro->delete();

                SolicitudUnion::where('estudiante_id', $estudianteId)
                    ->whereHas('equipo.inscripciones', function($q) use ($eventoId) {
                        $q->where('id_evento', $eventoId);
                    })
                    ->delete();
            });

            return redirect()->route('estudiante.eventos.index')
                ->with('success', 'Has abandonado el equipo exitosamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al salir del equipo: ' . $e->getMessage());
        }
    }

    /**
     * Transferir liderazgo a otro miembro (solo el líder actual puede hacerlo)
     * Automáticamente cambia los roles: nuevo líder obtiene rol "Líder",
     * antiguo líder recibe un rol al azar.
     */
    public function transferLeadership(Request $request, MiembroEquipo $miembro)
    {
        $request->validate([
            'nuevo_lider_id' => 'required|exists:miembros_equipo,id_miembro',
        ]);

        $user = Auth::user();
        $inscripcion = $miembro->inscripcion;
        $equipo = $inscripcion->equipo;
        
        $liderActual = $equipo->miembros()
            ->where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->first();
        
        if (!$liderActual) {
            return back()->with('error', 'Solo el líder puede transferir el liderazgo.');
        }

        $nuevoLider = MiembroEquipo::where('id_miembro', $request->nuevo_lider_id)
            ->where('id_inscripcion', $inscripcion->id_inscripcion)
            ->first();

        if (!$nuevoLider) {
            return back()->with('error', 'El miembro seleccionado no pertenece a este equipo.');
        }

        if ($nuevoLider->id_miembro == $liderActual->id_miembro) {
            return back()->with('info', 'Ya eres el líder del equipo.');
        }

        try {
            DB::transaction(function () use ($liderActual, $nuevoLider) {
                $rolLider = CatRolEquipo::where('nombre', 'Líder')->first();
                $rolesNoLider = CatRolEquipo::where('nombre', '!=', 'Líder')->get();
                $rolAleatorio = $rolesNoLider->isNotEmpty() ? $rolesNoLider->random() : null;
                
                $liderActual->update([
                    'es_lider' => false,
                    'id_rol_equipo' => $rolAleatorio ? $rolAleatorio->id_rol_equipo : $liderActual->id_rol_equipo
                ]);
                
                $nuevoLider->update([
                    'es_lider' => true,
                    'id_rol_equipo' => $rolLider ? $rolLider->id_rol_equipo : $nuevoLider->id_rol_equipo
                ]);
            });

            return back()->with('success', 'Liderazgo transferido a ' . $nuevoLider->user->nombre_completo . ' correctamente. Ahora eres un miembro regular del equipo.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al transferir liderazgo: ' . $e->getMessage());
        }
    }
}
