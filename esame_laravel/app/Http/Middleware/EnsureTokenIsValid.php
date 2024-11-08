<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\v1\AccessoController;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        $payload = AccessoController::verificaToken($token);
        if($payload != null)
        {
            $user = User::where('idUser',$payload->data->idUser)->first();
            Auth::login($user);
            return $next($request);
        }else{
            abort(403, "Token non valido");
        }
    }
}
