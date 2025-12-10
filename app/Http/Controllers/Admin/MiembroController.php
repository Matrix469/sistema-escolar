<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiembroEquipo;
use App\Models\CatRolEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MiembroController extends Controller
{
    /**
     * Remove the specified resource from storage.
     * Si el miembro es líder, transfiere automáticamente el liderazgo al siguiente miembro.
     */
    public function destroy(MiembroEquipo $miembro)
    {
        $equipoId = $miembro->inscripcion->equipo->id_equipo;
        $inscripcionId = $miembro->id_inscripcion;
        $eraLider = $miembro->es_lider;
        
        DB::beginTransaction();
        try {
            // Si el miembro era líder, verificar si hay otros miembros
            if ($eraLider) {
                $otroMiembro = MiembroEquipo::where('id_inscripcion', $inscripcionId)
                    ->where('id_miembro', '!=', $miembro->id_miembro)
                    ->first();
                
                if ($otroMiembro) {
                    // Obtener el rol de líder
                    $rolLider = CatRolEquipo::where('nombre', 'Líder')->first();
                    
                    // Transferir liderazgo al siguiente miembro
                    $otroMiembro->update([
                        'es_lider' => true,
                        'id_rol_equipo' => $rolLider ? $rolLider->id_rol_equipo : $otroMiembro->id_rol_equipo
                    ]);
                }
            }
            
            $miembro->delete();
            
            DB::commit();
            
            $mensaje = 'Miembro eliminado del equipo.';
            if ($eraLider && isset($otroMiembro)) {
                $mensaje .= ' El liderazgo fue transferido automáticamente a ' . $otroMiembro->user->nombre_completo . '.';
            }
            
            return redirect()->route('admin.equipos.show', $equipoId)->with('success', $mensaje);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.equipos.show', $equipoId)
                ->with('error', 'Error al eliminar miembro: ' . $e->getMessage());
        }
    }

    /**
     * Toggle leader status (Admin only)
     * Quita el liderazgo al líder actual y lo asigna al miembro especificado.
     * También cambia los roles automáticamente.
     */
    public function toggleLeader(MiembroEquipo $miembro)
    {
        $inscripcionId = $miembro->id_inscripcion;
        $equipoId = $miembro->inscripcion->equipo->id_equipo;
        
        // Si ya es líder, no hacer nada
        if ($miembro->es_lider) {
            return redirect()->route('admin.equipos.show', $equipoId)
                ->with('info', 'Este miembro ya es el líder del equipo.');
        }
        
        DB::beginTransaction();
        try {
            // Obtener roles
            $rolLider = CatRolEquipo::where('nombre', 'Líder')->first();
            $rolesNoLider = CatRolEquipo::where('nombre', '!=', 'Líder')->get();
            $rolAleatorio = $rolesNoLider->isNotEmpty() ? $rolesNoLider->random() : null;
            
            // Obtener líder actual
            $liderActual = MiembroEquipo::where('id_inscripcion', $inscripcionId)
                ->where('es_lider', true)
                ->first();
            
            // Quitar liderazgo al actual y asignar rol aleatorio
            if ($liderActual) {
                $liderActual->update([
                    'es_lider' => false,
                    'id_rol_equipo' => $rolAleatorio ? $rolAleatorio->id_rol_equipo : $liderActual->id_rol_equipo
                ]);
            }
            
            // Asignar nuevo líder con rol de líder
            $miembro->update([
                'es_lider' => true,
                'id_rol_equipo' => $rolLider ? $rolLider->id_rol_equipo : $miembro->id_rol_equipo
            ]);
            
            DB::commit();
            
            $mensaje = 'Liderazgo transferido a ' . $miembro->user->nombre_completo . ' correctamente.';
            if ($liderActual && $rolAleatorio) {
                $mensaje .= ' ' . $liderActual->user->nombre . ' ahora tiene el rol de ' . $rolAleatorio->nombre . '.';
            }
            
            return redirect()->route('admin.equipos.show', $equipoId)->with('success', $mensaje);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.equipos.show', $equipoId)
                ->with('error', 'Error al cambiar líder: ' . $e->getMessage());
        }
    }
}
