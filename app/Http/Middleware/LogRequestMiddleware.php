<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // Exclure les requêtes AJAX
    if ($request->ajax()) {
        return $next($request);
    }

    // // Exclure certaines routes spécifiques
    // $excludedRoutes = ['health-check', 'api/*'];

    // foreach ($excludedRoutes as $route) {
    //     if ($request->is($route)) {
    //         return $next($request);
    //     }
    // }
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Informations à enregistrer
        $logData = [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : 'Guest',
            'timestamp' => now()->toDateTimeString(),
        
            'user_agent' => $request->userAgent(),
        ];

        // Enregistrer les informations dans le fichier de log
        Log::info('Requête HTTP:', $logData);

        return $next($request);
    }
}
