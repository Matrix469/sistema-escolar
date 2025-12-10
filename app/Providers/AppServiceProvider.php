<?php

namespace App\Providers;

use App\Models\Equipo;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurar Carbon para español
        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain', 'Spanish');
        
        Gate::define('lider-equipo', function (User $user, Equipo $equipo) {
            return $equipo->miembros()->where('id_estudiante', $user->id_usuario)->where('es_lider', true)->exists();
        });
        if($this->app->environment('production')) {
        URL::forceScheme('https');
        }

        // Registrar Observers
        \App\Models\Equipo::observe(\App\Observers\EquipoObserver::class);
        \App\Models\MiembroEquipo::observe(\App\Observers\MiembroEquipoObserver::class);
    }
}
