<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'numero_control',
        'id_carrera',
        'semestre',
    ];

        public function carrera()

        {

            return $this->belongsTo(CatCarrera::class, 'id_carrera', 'id_carrera');
        }

    

        public function user()

        {

            return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');

        }

    }