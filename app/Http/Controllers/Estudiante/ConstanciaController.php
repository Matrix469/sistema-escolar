<?php

namespace App\Http\Controllers\Estudiante;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;
use PDF;
class ConstanciaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $estudiante = Estudiante::where('id_usuario', $user->id_usuario)->first();

        // Obtener IDs de todos los eventos donde el usuario está inscrito
        $eventosInscritosIds = Evento::whereHas('inscripciones.miembros', function ($query) use ($user) {
            $query->where('id_estudiante', $user->id_usuario);
        })->pluck('id_evento');
        
        // 1. Mis Eventos "En Progreso" y "Finalizado"
        $eventosTotalesInscritos = Evento::whereIn('id_evento', $eventosInscritosIds)
            ->where('estado', 'En Progreso')
            ->orWhere('estado', 'Finalizado')
            ->orderBy('fecha_inicio', 'desc')
            ->get();

        return view('estudiante.constancias.index', compact('estudiante', 'eventosTotalesInscritos'));
    }
    public function generarPdf(Evento $evento)
    {

        $user = Auth::user();
        $estudiante = Estudiante::where('id_usuario', $user->id_usuario)->first();

        // Construye una consulta que busca el evento POR SU ID y que cumpla la condición de inscripción
        $esUsuarioInscrito = Evento::where('id_evento', $evento->id_evento)
            ->whereHas('inscripciones.miembros', function ($query) use ($user) {
                $query->where('id_estudiante', $user->id_usuario);
            })
            ->whereIn('estado', ['Finalizado'])
            ->exists();

        // 2. Si la verificación falla, se detiene y devuelve un 403.
        if (!$esUsuarioInscrito) {
            abort(403, 'No tienes permiso para generar la constancia de este evento o el evento no ha finalizado.');
        }

        $pdf = PDF::loadView('estudiante.constancias.constancia-alumno', compact('estudiante', 'user', 'evento'));
        return $pdf->stream();
    }
}
