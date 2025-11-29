<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatRolEquipo extends Model
{
    protected $table = 'cat_roles_equipo';
    protected $primaryKey = 'id_rol_equipo';
    public $timestamps = false;
}
