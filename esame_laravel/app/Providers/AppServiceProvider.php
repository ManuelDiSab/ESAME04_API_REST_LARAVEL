<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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

        //Gate per gli user 
        Gate::define('user', function( User $user ){
            if($user->idRuolo === 1 || $user->idRuolo === 2){
                return $user->idRuolo === 1 || $user->idRuolo === 2;
                }
                else{
                    abort(403, 'Ops!Devi prima registrarti!');
                }
            });

        // gate per soli admin
        Gate::define('admin', function( User $user ){
            if($user->idRuolo === 2){
            return $user->idRuolo === 2;
            }
            else{
                abort(403, 'Ops!Non sei autorizzato!');
            }
        });

        //Gate per profili con status attivo
        Gate::define('attivo', function(User $user){
            if($user->status === 1){
            return $user->status === 1;
            }else{
                abort(403, 'Ops! Il tuo account non è attivo');
            }
        });
    }
}
