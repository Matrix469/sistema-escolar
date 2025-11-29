<?php

namespace App\Http\Controllers\Jurado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jurado;
use App\Models\Evento;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $jurado = Jurado::find($user->id_usuario); // Asume que id_usuario es la PK y coincide con Auth::id()

        if (!$jurado) {
            // Manejar caso donde el user logueado no es un jurado (aunque debería serlo por el middleware)
            return redirect('/dashboard')->with('error', 'No tienes perfil de jurado.');
        }

        // Obtener los eventos a los que este jurado está asignado
        $misEventosAsignados = $jurado->eventos()
                                      ->whereIn('estado', ['Activo', 'Próximo'])
                                      ->orderBy('fecha_inicio', 'asc')
                                      ->get();

        // Obtener todos los eventos públicos (Activos o Próximos)
        $eventosPublicos = Evento::whereIn('estado', ['Activo', 'Próximo'])
                                 ->orderBy('fecha_inicio', 'asc')
                                 ->get();

        return view('jurado.dashboard', compact('misEventosAsignados', 'eventosPublicos'));
    }
}
