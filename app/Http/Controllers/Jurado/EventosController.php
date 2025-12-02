<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventosController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        // Obtener los eventos donde el jurado está asignado
        $misEventosInscritos = $jurado ? $jurado->eventos()->orderBy('fecha_inicio', 'desc')->get() : collect();
        $misEventosIds = $misEventosInscritos->pluck('id_evento');

        // Eventos activos disponibles (excluyendo los que ya tiene asignados)
        $eventosActivos = Evento::where('estado', 'Activo')
                                 ->whereNotIn('id_evento', $misEventosIds)
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();
        
        // Próximos eventos (excluyendo los que ya tiene asignados)
        $eventosProximos = Evento::where('estado', 'Próximo')
                                 ->whereNotIn('id_evento', $misEventosIds)
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();
                                 
        return view('jurado.eventos.index', compact('misEventosInscritos', 'eventosActivos', 'eventosProximos'));
    }

    public function show(Evento $evento)
    {
        $user = Auth::user();
        $jurado = $user->jurado;

        // Verificar si el jurado está asignado a este evento (especificando la tabla para evitar ambigüedad)
        $esJuradoDelEvento = $jurado && $jurado->eventos()->where('eventos.id_evento', $evento->id_evento)->exists();

        // Cargar las relaciones necesarias del evento
        $evento->load([
            'inscripciones' => function($query) {
                $query->orderBy('fecha_inscripcion', 'desc');
            },
            'inscripciones.equipo' => function($query) {
                $query->orderBy('nombre', 'asc');
            },
            'inscripciones.miembros' => function($query) {
                $query->orderBy('es_lider', 'desc')->orderBy('id_rol_equipo', 'asc');
            },
            'inscripciones.miembros.user',
            'inscripciones.miembros.rol'
        ]);

        // Contar equipos inscritos
        $totalEquipos = $evento->inscripciones->count();
        return view('jurado.eventos.show', compact('evento', 'esJuradoDelEvento', 'totalEquipos'));
    }
}