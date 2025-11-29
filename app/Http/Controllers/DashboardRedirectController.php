<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if ($user->rolSistema->nombre === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->rolSistema->nombre === 'jurado') {
            return redirect()->route('jurado.dashboard');
        } elseif ($user->rolSistema->nombre === 'estudiante') {
            return redirect()->route('estudiante.dashboard');
        }

        // Fallback por si acaso
        return redirect('/');
    }
}
