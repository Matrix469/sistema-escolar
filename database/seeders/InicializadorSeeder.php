<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Para generar strings aleatorios
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Jurado;
use App\Models\CatCarrera;

class InicializadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 1. ROLES DEL SISTEMA (Vital para el Login)

        // Usamos insertOrIgnore para no duplicar si ya existen
        DB::table('cat_roles_sistema')->insertOrIgnore([
            ['id_rol_sistema' => 1, 'nombre' => 'admin'],
            ['id_rol_sistema' => 2, 'nombre' => 'jurado'],
            ['id_rol_sistema' => 3, 'nombre' => 'estudiante'],
        ]);


        // 2. CARRERAS (Oferta Educativa del ITO)

        $carreras = [
            'Ingeniería en Sistemas Computacionales',
            'Ingeniería Civil',
            'Ingeniería en Gestión Empresarial',
            'Ingeniería Industrial',
            'Ingeniería Electrónica',
            'Ingeniería Eléctrica',
            'Ingeniería Mecánica',
            'Ingeniería Química',
            'Licenciatura en Administración'
        ];

        foreach ($carreras as $carrera) {
            DB::table('cat_carreras')->insertOrIgnore([
                'nombre' => $carrera
            ]);
        }


        // 3. ROLES DE EQUIPO

        DB::table('cat_roles_equipo')->insertOrIgnore([
            ['nombre' => 'Líder', 'descripcion' => 'Encargado de gestionar el equipo y subir avances.'],
            ['nombre' => 'Programador Backend', 'descripcion' => 'Lógica del servidor y bases de datos.'],
            ['nombre' => 'Programador Frontend', 'descripcion' => 'Interfaces y experiencia de usuario.'],
            ['nombre' => 'Analista de Datos', 'descripcion' => 'Gestión de información y métricas.'],
            ['nombre' => 'Diseñador UX/UI', 'descripcion' => 'Prototipado y diseño visual.'],
        ]);


        //! TOKENS PARA JURADOS 
        //TODO Token FIJO para pruebas 
        DB::table('tokens_jurado')->insertOrIgnore([
            'token' => 'JURADO-HACKATEC-2025', // Contraseña maestra para registrar jurados
            'usado' => false,
            'fecha_expiracion' => now()->addMonths(6), 
            'email_invitado' => 'jurado_invitado@ito.mx'
        ]);

        //! GENERADOR DE 5 tokens aleatorios extra (Para simular invitaciones reales)
        for ($i = 0; $i < 5; $i++) {
            DB::table('tokens_jurado')->insert([
                'token' => Str::upper(Str::random(10)), // Genera algo como "A1B2C3D4E5"
                'usado' => false,
                'fecha_expiracion' => now()->addMonths(1),
                'email_invitado' => null
            ]);
        }

        // 5. USUARIO ADMINISTRADOR (Super Usuario)
        // Verificamos si existe para no dar error
        $adminEmail = 'admin@ito.mx';
        if (!DB::table('users')->where('email', $adminEmail)->exists()) {
            DB::table('users')->insert([
                'nombre' => 'Administrador',
                'app_paterno' => 'Principal',
                'app_materno' => 'Sistema',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'), 
                'id_rol_sistema' => 1, // 1 = Admin
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. CREACIÓN DE ESTUDIANTES Y JURADOS DE PRUEBA
        DB::transaction(function () {
            $carreraIds = CatCarrera::pluck('id_carrera');

            // Estudiantes
            $estudiantes = [
                ['nombre' => 'Leonardo Satot', 'app_paterno' => 'Garcia', 'app_materno' => 'Pino', 'email' => 'leonardo@ito.mx'],
                ['nombre' => 'Diego Eduardo', 'app_paterno' => 'Quiroga', 'app_materno' => 'Gómez', 'email' => 'diego469quiroga@gmail.com'],
                ['nombre' => 'Joel', 'app_paterno' => 'Hernandez', 'app_materno' => 'Perez', 'email' => 'joel@ito.mx'],
                ['nombre' => 'Daniel', 'app_paterno' => 'Lopez', 'app_materno' => 'Martinez', 'email' => 'daniel@ito.mx'],
                ['nombre' => 'Gael', 'app_paterno' => 'Ruiz', 'app_materno' => 'Jimenez', 'email' => 'gael@ito.mx'],
                ['nombre' => 'Lorea Camila', 'app_paterno' => 'Quiroga', 'app_materno' => 'Gomez', 'email' => 'lorea@ito.mx'],
            ];

            foreach ($estudiantes as $index => $estudianteData) {
                if (!User::where('email', $estudianteData['email'])->exists()) {
                    $user = User::create([
                        'nombre' => $estudianteData['nombre'],
                        'app_paterno' => $estudianteData['app_paterno'],
                        'app_materno' => $estudianteData['app_materno'],
                        'email' => $estudianteData['email'],
                        'password' => Hash::make('password'),
                        'id_rol_sistema' => 3, 
                        'activo' => true,
                    ]);

                    Estudiante::create([
                        'id_usuario' => $user->id_usuario,
                        'numero_control' => '2016' . str_pad((string)($index + 1), 4, '0', STR_PAD_LEFT),
                        'semestre' => rand(3, 9),
                        'id_carrera' => $carreraIds->random(),
                    ]);
                }
            }

            // Jurados
            $jurados = [
                ['nombre' => 'Otilia', 'app_paterno' => 'Perez', 'app_materno' => 'Lopez', 'email' => 'otilia@jurado.mx'],
                ['nombre' => 'Adelina', 'app_paterno' => 'Martinez', 'app_materno' => 'Nieto', 'email' => 'adelina@jurado.mx'],
                ['nombre' => 'Idarh Claudio', 'app_paterno' => 'Matadamas', 'app_materno' => 'Ortiz', 'email' => 'idarh@jurado.mx'],
                ['nombre' => 'Luis Alberto', 'app_paterno' => 'Alonso', 'app_materno' => 'Hernandez', 'email' => 'luis@jurado.mx'],
            ];

            foreach ($jurados as $juradoData) {
                if (!User::where('email', $juradoData['email'])->exists()) {
                    $user = User::create([
                        'nombre' => $juradoData['nombre'],
                        'app_paterno' => $juradoData['app_paterno'],
                        'app_materno' => $juradoData['app_materno'],
                        'email' => $juradoData['email'],
                        'password' => Hash::make('password'),
                        'id_rol_sistema' => 2, // Rol Jurado
                        'activo' => true,
                    ]);

                    Jurado::create([
                        'id_usuario' => $user->id_usuario,
                        'especialidad' => 'Experto en Desarrollo de Software',
                        'empresa_institucion' => 'Empresa Tecnológica',
                    ]);
                }
            }
        });
    }
}