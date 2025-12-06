<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Jurado;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JuradoAssignmentController extends Controller
{
    /**
     * Show the form for assigning jurors to an event.
     */
    public function edit(Request $request, Evento $evento)
    {
        // Obtener búsqueda
        $search = $request->input('search');
        
        // Obtener todos los jurados con su información de usuario con filtro
        $query = Jurado::with('user');
        
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('app_paterno', 'like', "%{$search}%")
                  ->orWhere('app_materno', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $juradosDisponibles = $query->paginate(12)->withQueryString();

        // Obtener los IDs de los jurados ya asignados a este evento
        $juradosAsignadosIds = $evento->jurados()->pluck('jurados.id_usuario')->toArray();

        return view('admin.eventos.asignar-jurados', compact('evento', 'juradosDisponibles', 'juradosAsignadosIds', 'search'));
    }

    /**
     * Update the specified event's juror assignments in storage.
     */
    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'jurados' => [
                'nullable',
                'array',
                'min:3',
                'max:5',
            ],
        ], [
            'jurados.min' => 'Debes asignar un mínimo de :min jurados.',
            'jurados.max' => 'Puedes asignar un máximo de :max jurados.',
        ]);

        // Sincronizar los jurados con el evento
        $evento->jurados()->sync($request->input('jurados', []));

        return redirect()->route('admin.eventos.show', $evento)->with('success', 'Jurados asignados exitosamente.');
    }
}
