<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenJurado extends Model
{
    use HasFactory;
    protected $table = 'tokens_jurado';
    protected $primaryKey = 'id_token';

    /**
     *? Indica si el modelo debe tener marcas de tiempo (created_at, updated_at).
     * ?Ponlo en FALSE si en tu migración no pusiste $table->timestamps();
     */
    public $timestamps = false; 
    protected $fillable = [
        'token',
        'usado',
        'fecha_expiracion',
        'email_invitado',
    ];


   protected $casts = [
        'usado' => 'boolean',
        'fecha_expiracion' => 'datetime',
    ];

    /**
     * Scope (Filtro) para buscar tokens válidos rápidamente.
     * TokenJurado::validos()->where('token', 'ABC')->first();
     */
    public function scopeValidos($query)
    {
        return $query->where('usado', false)
                     ->where('fecha_expiracion', '>', now());
    }
}