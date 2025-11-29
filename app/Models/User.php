<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    //? Aqui le estoy diciendo cual es nuestra llave primaria para que no se me pierdan
    protected $primaryKey = 'id_usuario';
    use HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
        //? Aqui es la asignación para la seguridad
    protected $fillable = [
        'nombre',
        'app_paterno',
        'app_materno',
        'email',
        'password',
        'foto_perfil',
        'id_rol_sistema',
        'activo'
    ];

    // ? Espacio para nuestra relaciones 
    public function rolSistema() {
        return $this->belongsTo(CatRolSistema::class, 'id_rol_sistema', 'id_rol_sistema');
    }
    public function estudiante() {
        return $this->hasOne(Estudiante::class, 'id_usuario', 'id_usuario');
    }
    public function jurado() {
        return $this->hasOne(Jurado::class, 'id_usuario', 'id_usuario');
    }
    public function isAdmin() {
        return $this->rolSistema->nombre === 'admin';
    }

    public function esEstudiante() {
        return $this->rolSistema->nombre === 'estudiante';
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim("{$this->nombre} {$this->app_paterno} {$this->app_materno}");
    }

    /**
     * Obtener la URL de la foto de perfil o generar una predeterminada.
     */
    public function getFotoPerfilUrlAttribute(): string
    {
        if ($this->foto_perfil) {
            return asset('storage/' . $this->foto_perfil);
        }
        
        // Generar avatar con iniciales usando UI Avatars API
        $iniciales = strtoupper(substr($this->nombre, 0, 1) . substr($this->app_paterno, 0, 1));
        return "https://ui-avatars.com/api/?name={$iniciales}&background=4F46E5&color=fff&size=200";
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Habilidades del estudiante (many-to-many)
     */
    public function habilidades()
    {
        return $this->belongsToMany(
            CatHabilidad::class,
            'estudiante_habilidades',
            'id_usuario',
            'id_habilidad'
        )->withPivot('nivel')->withTimestamps();
    }

    /**
     * Logros obtenidos por el usuario (many-to-many)
     */
    public function logros()
    {
        return $this->belongsToMany(
            Logro::class,
            'usuario_logros',
            'id_usuario',
            'id_logro'
        )->withPivot('fecha_obtencion', 'id_evento');
    }

    /**
     * Estadísticas y XP del estudiante
     */
    public function stats()
    {
        return $this->hasOne(EstudianteStats::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Actividades generadas por el usuario
     */
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Recursos subidos por el usuario
     */
    public function recursosSubidos()
    {
        return $this->hasMany(RecursoEquipo::class, 'subido_por', 'id_usuario');
    }
}
