<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiembroEquipo;
use Illuminate\Http\Request;

class MiembroController extends Controller
{
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MiembroEquipo $miembro)
    {
        $equipoId = $miembro->inscripcion->equipo->id_equipo;
        $miembro->delete();

        return redirect()->route('admin.equipos.show', $equipoId)->with('success', 'Miembro eliminado del equipo.');
    }
}
