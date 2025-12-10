<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\MiembroEquipo;
use App\Models\CatRolEquipo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class EquipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Contadores basados en cantidad de miembros (5 = completo)
        $totalEquipos = Equipo::count();
        
        // Equipos completos: tienen 5 o más miembros
        $equiposCompletos = Equipo::whereHas('inscripciones', function($q) {
            $q->whereHas('miembros', function($mq) {
                // Contamos por inscripción
            }, '>=', 5);
        })->count();
        
        // Calculamos incompletos como la diferencia
        $equiposIncompletos = $totalEquipos - $equiposCompletos;
        
        // Query base con relaciones
        $query = Equipo::with('miembros.user', 'inscripciones.evento')
            ->withCount('miembros');
        
        // Filtro de búsqueda por nombre
        if ($request->filled('search')) {
            $query->where('nombre', 'ilike', '%' . $request->search . '%');
        }
        
        // Filtro por estado (completo/incompleto) basado en cantidad de miembros
        if ($request->filled('estado')) {
            if ($request->estado === 'completo') {
                // Equipos con 5+ miembros
                $query->has('miembros', '>=', 5);
            } elseif ($request->estado === 'incompleto') {
                // Equipos con menos de 5 miembros
                $query->has('miembros', '<', 5);
            }
        }
        
        // Filtro por evento
        if ($request->filled('evento')) {
            $query->whereHas('inscripciones', function($q) use ($request) {
                $q->where('id_evento', $request->evento);
            });
        }
        
        $equipos = $query->orderBy('nombre')->paginate(15);
        
        // Lista de eventos para el filtro
        $eventos = \App\Models\Evento::whereIn('estado', ['Activo', 'Próximo'])->orderBy('nombre')->get();
        
        return view('admin.equipos.index', compact(
            'equipos',
            'totalEquipos',
            'equiposCompletos',
            'equiposIncompletos',
            'eventos'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipo $equipo)
    {
        $equipo->load('miembros.user.estudiante.carrera', 'miembros.rol', 'inscripciones.evento.jurados');
        $roles = CatRolEquipo::all();

        // Obtener información del evento y sus jurados
        $inscripcion = $equipo->inscripciones->first();
        $evento = $inscripcion?->evento;
        $juradosCount = $evento ? $evento->jurados->count() : 0;
        $juradosSuficientes = $juradosCount >= 3 && $juradosCount <= 5;

        return view('admin.equipos.show', compact('equipo', 'roles', 'evento', 'juradosCount', 'juradosSuficientes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipo $equipo)
    {
        $equipo->load('inscripciones.evento');
        $evento = $equipo->inscripciones->first()?->evento;
        
        return view('admin.equipos.edit', compact('equipo', 'evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('equipos')->ignore($equipo->id_equipo, 'id_equipo'),
            ],
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only('nombre');
        if ($request->hasFile('ruta_imagen')) {
            // Borrar imagen anterior si existe
            if ($equipo->ruta_imagen) {
                Storage::disk('public')->delete($equipo->ruta_imagen);
            }
            $data['ruta_imagen'] = $request->file('ruta_imagen')->store('imagenes_equipos', 'public');
        }

        $equipo->update($data);

        return redirect()->route('admin.equipos.show', $equipo)->with('success', 'Equipo actualizado correctamente.');
    } // Added missing brace
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipo $equipo)
    {
        $eventoId = null;
        if ($equipo->inscripciones->first()) {
            $eventoId = $equipo->inscripciones->first()->id_evento;
        }

        $equipo->delete();

        if ($eventoId) {
            return redirect()->route('admin.eventos.show', $eventoId)->with('success', 'Equipo eliminado correctamente.');
        }

        return redirect()->route('admin.dashboard')->with('success', 'Equipo eliminado correctamente.');
    }

    /**
     * Remove team from specific event (without deleting the team)
     */
    public function removeFromEvent(Request $request, Equipo $equipo)
    {
        $eventoId = $request->input('evento_id');
        $equipoNombre = $equipo->nombre;
        
        // Buscar la inscripción del equipo en este evento
        $inscripcion = $equipo->inscripciones()->where('id_evento', $eventoId)->first();
        
        if (!$inscripcion) {
            return redirect()->back()->with('error', 'Este equipo no está inscrito en el evento especificado.');
        }

        // NO eliminar la inscripción, solo quitar el evento
        // Esto mantiene el equipo y sus miembros intactos
        $inscripcion->id_evento = null;
        $inscripcion->status_registro = 'Incompleto';
        $inscripcion->puesto_ganador = null;
        $inscripcion->save();

        return redirect()->route('admin.eventos.show', $eventoId)
            ->with('success', "Equipo '{$equipoNombre}' excluido del evento. El equipo y sus miembros se mantienen sin evento.");
    }

    /**
     * Update member role (Admin can change any member's role)
     * Bloquea la asignación del rol "Líder" manualmente
     */
    public function updateMemberRole(Request $request, MiembroEquipo $miembro)
    {
        $request->validate([
            'id_rol_equipo' => 'required|exists:cat_roles_equipo,id_rol_equipo',
        ]);

        // Bloquear la asignación del rol "Líder" manualmente
        $rolLider = CatRolEquipo::where('nombre', 'Líder')->first();
        if ($rolLider && $request->id_rol_equipo == $rolLider->id_rol_equipo) {
            return back()->with('error', 'No puedes asignar el rol de Líder manualmente. Usa el botón "Transferir Liderazgo".');
        }

        // Si es el líder, no se puede cambiar su rol
        if ($miembro->es_lider) {
            return back()->with('error', 'El rol del líder no se puede cambiar manualmente.');
        }

        $miembro->update([
            'id_rol_equipo' => $request->id_rol_equipo,
        ]);

        return back()->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Toggle leader status
     */
    public function toggleLeader(Request $request, MiembroEquipo $miembro)
    {
        // Si se está haciendo líder a este miembro
        if (!$miembro->es_lider) {
            // Quitar líder actual
            MiembroEquipo::where('id_inscripcion', $miembro->id_inscripcion)
                ->where('es_lider', true)
                ->update(['es_lider' => false]);
            
            $miembro->update(['es_lider' => true]);
            $message = 'Nuevo líder asignado correctamente.';
        } else {
            return back()->with('error', 'No puedes quitar al único líder del equipo.');
        }

        return back()->with('success', $message);
    }
}