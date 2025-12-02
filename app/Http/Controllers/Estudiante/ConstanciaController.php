<?php

namespace App\Http\Controllers\Estudiante;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConstanciaController extends Controller
{
    public function index()
    {
        return view('estudiante.constancias.index');
    }
}
