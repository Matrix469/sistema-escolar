<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Equipo;
use App\Models\InscripcionEvento;
use App\Models\MiembroEquipo;
use App\Models\SolicitudUnion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EquipoController extends Controller
{
    public function index(Request $request, Evento $evento)
    {
        $user = Auth::user();
        $miInscripcion = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->with('inscripcion:id_inscripcion,id_equipo')
            ->first();
        $miInscripcionDeEquipoId = $miInscripcion ? $miInscripcion->inscripcion->id_equipo : null;
        $solicitudesDelEstudiante = SolicitudUnion::where('estudiante_id', $user->id_usuario)
            ->whereHas('equipo.inscripciones', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->get()
            ->keyBy('equipo_id');
        $query = $evento->inscripciones()->with('equipo.miembros');
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('equipo', function ($q) use ($searchTerm) {
                $q->where('nombre', 'like', '%' . $searchTerm . '%');
            });
        }
        if ($request->filled('status')) {
            if ($request->input('status') == 'Completo') {
                $query->whereRaw('(SELECT COUNT(*) FROM miembros_equipo me JOIN inscripciones_evento ie ON me.id_inscripcion = ie.id_inscripcion WHERE ie.id_equipo = inscripciones_evento.id_equipo) >= ?', [$evento->cupo_max_equipos]);
            } else {
                $query->whereRaw('(SELECT COUNT(*) FROM miembros_equipo me JOIN inscripciones_evento ie ON me.id_inscripcion = ie.id_inscripcion WHERE ie.id_equipo = inscripciones_evento.id_equipo) < ?', [$evento->cupo_max_equipos]);
            }
        }
        $inscripciones = $query->paginate(12);
        return view('estudiante.equipos.index', compact('evento', 'inscripciones', 'user', 'miInscripcionDeEquipoId', 'solicitudesDelEstudiante'));
    }

    public function create(Evento $evento)
    {
        $user = Auth::user();
        $inscripcionExistente = InscripcionEvento::whereHas('miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->whereHas('evento', function ($query) {
            $query->where('estado', 'Activo');
        })->first();
        if ($inscripcionExistente) {
            return redirect()->route('estudiante.dashboard')->with('error', 'Ya estás participando en un evento activo.');
        }
        return view('estudiante.equipos.create', compact('evento'));
    }

    public function store(Request $request, Evento $evento)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:equipos,nombre',
            'descripcion' => 'nullable|string|max:1000',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        try {
            DB::transaction(function () use ($request, $evento) {
                $user = Auth::user();
                $rutaImagen = null;
                if ($request->hasFile('ruta_imagen')) {
                    $rutaImagen = $request->file('ruta_imagen')->store('imagenes_equipos', 'public');
                }
                $equipo = Equipo::create([
                    'nombre' => $request->nombre,
                    'descripcion' => $request->descripcion,
                    'ruta_imagen' => $rutaImagen,
                ]);
                $inscripcion = InscripcionEvento::create([
                    'id_equipo' => $equipo->id_equipo,
                    'id_evento' => $evento->id_evento,
                    'status_registro' => 'Incompleto',
                ]);
                MiembroEquipo::create([
                    'id_inscripcion' => $inscripcion->id_inscripcion,
                    'id_estudiante' => $user->id_usuario,
                    'id_rol_equipo' => 1,
                    'es_lider' => true,
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un error al crear el equipo: ' . $e->getMessage())->withInput();
        }
        return redirect()->route('estudiante.dashboard')->with('success', '¡Equipo creado e inscrito exitosamente!');
    }

    public function edit()
    {
        $user = Auth::user();
        $miembro = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->whereHas('inscripcion.evento', function ($query) {
                $query->where('estado', 'Activo');
            })
            ->with('inscripcion.equipo')
            ->firstOrFail(); 
        $equipo = $miembro->inscripcion->equipo;
        return view('estudiante.equipos.edit', compact('equipo'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $miembro = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->where('es_lider', true)
            ->whereHas('inscripcion.evento', function ($query) {
                $query->where('estado', 'Activo');
            })
            ->with('inscripcion.equipo')
            ->firstOrFail();
        $equipo = $miembro->inscripcion->equipo;
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('equipos')->ignore($equipo->id_equipo, 'id_equipo')],
            'descripcion' => 'nullable|string|max:1000',
            'ruta_imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->only('nombre', 'descripcion');
        if ($request->hasFile('ruta_imagen')) {
            if ($equipo->ruta_imagen) {
                Storage::disk('public')->delete($equipo->ruta_imagen);
            }
            $data['ruta_imagen'] = $request->file('ruta_imagen')->store('imagenes_equipos', 'public');
        }
        $equipo->update($data);
        return redirect()->route('estudiante.equipo.index')->with('success', 'Equipo actualizado correctamente.');
    }

    public function show(Evento $evento, Equipo $equipo)
    {
        $user = Auth::user();
        
        // Obtener la inscripción del equipo para este evento
        $inscripcion = InscripcionEvento::where('id_equipo', $equipo->id_equipo)
            ->where('id_evento', $evento->id_evento)
            ->with(['equipo.miembros.user.estudiante.carrera', 'equipo.miembros.rol', 'evento'])
            ->firstOrFail();
        
        // Verificar si el usuario ya es miembro de un equipo en este evento
        $miInscripcion = MiembroEquipo::where('id_estudiante', $user->id_usuario)
            ->whereHas('inscripcion', function ($query) use ($evento) {
                $query->where('id_evento', $evento->id_evento);
            })
            ->with('inscripcion:id_inscripcion,id_equipo')
            ->first();
        $miInscripcionDeEquipoId = $miInscripcion ? $miInscripcion->inscripcion->id_equipo : null;
        
        // Verificar si hay solicitud pendiente
        $solicitudActual = SolicitudUnion::where('estudiante_id', $user->id_usuario)
            ->where('equipo_id', $equipo->id_equipo)
            ->first();
        
        return view('estudiante.equipos.show', compact('inscripcion', 'evento', 'miInscripcionDeEquipoId', 'solicitudActual'));
    }

    public function destroy(string $id)
    {
        //
    }
}