<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CatRolSistema;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Estadísticas
        $totalAdmins = User::where('id_rol_sistema', 1)->count();
        $totalJurados = User::where('id_rol_sistema', 2)->count();
        $totalEstudiantes = User::where('id_rol_sistema', 3)->count();

        // Query para usuarios
        $query = User::with('rolSistema');

        // Búsqueda
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'like', '%' . $searchTerm . '%')
                  ->orWhere('app_paterno', 'like', '%' . $searchTerm . '%')
                  ->orWhere('app_materno', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->where('id_rol_sistema', $request->input('rol'));
        }

        $usuarios = $query->orderBy('nombre')->paginate(15);
        $roles = CatRolSistema::all();

        return view('admin.users.index', compact(
            'usuarios', 
            'roles',
            'totalAdmins',
            'totalJurados',
            'totalEstudiantes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('estudiante.carrera', 'jurado');
        $roles = CatRolSistema::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'app_paterno' => 'required|string|max:100',
            'app_materno' => 'nullable|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id_usuario . ',id_usuario',
            'id_rol_sistema' => 'required|exists:cat_roles_sistema,id_rol_sistema',
            // Validar campos específicos del rol
            'numero_control' => 'nullable|string|max:20',
            'semestre' => 'nullable|integer|min:1',
            'especialidad' => 'nullable|string|max:100',
        ]);

        // Actualizar el modelo User
        $user->update([
            'nombre' => $validated['nombre'],
            'app_paterno' => $validated['app_paterno'],
            'app_materno' => $validated['app_materno'],
            'email' => $validated['email'],
            'id_rol_sistema' => $validated['id_rol_sistema'],
        ]);

        // Actualizar el modelo de sub-rol si existe
        if ($user->estudiante && $request->filled('numero_control')) {
            $user->estudiante->update([
                'numero_control' => $validated['numero_control'],
                'semestre' => $validated['semestre'],
            ]);
        } elseif ($user->jurado && $request->filled('especialidad')) {
            $user->jurado->update([
                'especialidad' => $validated['especialidad'],
            ]);
        }
        
        // TODO: Implementar la lógica para cuando un rol cambia (ej. de Estudiante a Jurado).
        // Esto requeriría eliminar el registro antiguo y crear uno nuevo.

        return redirect()->route('admin.users.edit', $user)->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
