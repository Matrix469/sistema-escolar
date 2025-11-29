<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
//? modelos que cree
use Illuminate\Support\Facades\DB;
use App\Models\Estudiante;
use App\Models\TokenJurado;
use App\Models\Jurado;
use App\Models\CatCarrera;
use App\Models\CatRolSistema;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        //? Aqui jalo las carrera de la BD 
        $carreras = CatCarrera::all();
       return view('auth.register', compact('carreras'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'app_paterno' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'tipo_registro' => ['required', 'in:estudiante,jurado'],
        ]);
        //? inicio de la trancción para nuestra validación que es especifica

        try {
            DB::beginTransaction(); // Inicia la transacción

            // A. Lógica para ESTUDIANTES
            if ($request->tipo_registro === 'estudiante') {
                // Validar datos extra del estudiante
                $request->validate([
                    'numero_control' => ['required', 'string', 'max:20', 'unique:estudiantes'],
                    'id_carrera' => ['required', 'exists:cat_carreras,id_carrera'],
                    'semestre' => ['required', 'integer', 'min:1', 'max:14'],
                ]);

                // Crear Usuario Padre
                $user = User::create([
                    'nombre' => $request->nombre,
                    'app_paterno' => $request->app_paterno,
                    'app_materno' => $request->app_materno, // Opcional
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'id_rol_sistema' => 3, // ID 3 = Estudiante (Hardcodeado por seguridad)
                    'activo' => true,
                ]);

                // Crear Estudiante Hijo
                Estudiante::create([
                    'id_usuario' => $user->id_usuario,
                    'numero_control' => $request->numero_control,
                    'id_carrera' => $request->id_carrera,
                    'semestre' => $request->semestre,
                ]);
            }

            // B. Lógica para JURADOS (Seguridad Máxima)
            elseif ($request->tipo_registro === 'jurado') {
                // Validar token
                $request->validate([
                    'token_acceso' => ['required', 'string'],
                    'especialidad' => ['required', 'string'],
                ]);

                // Verificar si el token es válido en la BD
                $tokenDb = TokenJurado::where('token', $request->token_acceso)
                    ->where('usado', false)
                    ->where('fecha_expiracion', '>', now())
                    ->first();

                if (!$tokenDb) {
                    throw ValidationException::withMessages([
                        'token_acceso' => 'El token de jurado es inválido, ha expirado o ya fue usado.',
                    ]);
                }

                // Si pasa, creamos el Usuario
                $user = User::create([
                    'nombre' => $request->nombre,
                    'app_paterno' => $request->app_paterno,
                    'app_materno' => $request->app_materno,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'id_rol_sistema' => 2, // ID 2 = Jurado
                    'activo' => true,
                ]);

                // Crear Jurado Hijo
                Jurado::create([
                    'id_usuario' => $user->id_usuario,
                    'especialidad' => $request->especialidad,
                    'empresa_institucion' => $request->empresa_institucion ?? 'Independiente',
                    'cedula_profesional' => $request->cedula_profesional,
                ]);

                // QUEMAR EL TOKEN (Para que no se pueda reusar)
                $tokenDb->update(['usado' => true]);
            }

            DB::commit(); // Si todo salió bien, guardamos cambios en BD

        } catch (\Exception $e) {
            DB::rollBack(); // Si algo falló, deshacemos TODO (incluso la creación del usuario)
            throw $e; // Re-lanzamos el error para que Laravel lo muestre
        }

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
