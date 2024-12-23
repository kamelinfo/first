<?php
/*
    Ce fichier définit le middleware `RoleMiddleware` qui permet de restreindre l'accès aux routes en fonction des rôles des utilisateurs.
    Il vérifie si l'utilisateur est authentifié et s'il possède l'un des rôles spécifiés avant de permettre l'accès à la ressource demandée.
    Si l'utilisateur n'est pas authentifié, il est redirigé vers la page de connexion.
    Si l'utilisateur n'a aucun des rôles requis, une erreur 403 (Accès non autorisé) est renvoyée.
*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Gère une requête entrante en vérifiant les rôles de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request  La requête HTTP entrante.
     * @param  \Closure  $next  La fonction de fermeture qui représente le prochain middleware ou la requête finale.
     * @param  mixed ...$roles  Une liste variable de rôles autorisés (par exemple, 'admin', 'gestionaire').
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse  La réponse HTTP après traitement.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Vérifie si l'utilisateur est authentifié
        if (!Auth::check()) {
            // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
            return redirect('/login');
        }

        // Récupère l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Parcourt chaque rôle spécifié dans les paramètres du middleware
        foreach ($roles as $role) {
            // Vérifie si l'utilisateur possède le rôle actuel
            if ($user->hasRole($role)) {
                // Si l'utilisateur possède le rôle, permet la poursuite de la requête vers le prochain middleware ou le contrôleur
                return $next($request);
            }
        }

        // Si l'utilisateur ne possède aucun des rôles requis, abort avec une erreur 403 (Accès non autorisé)
        abort(403, 'Accès non autorisé');
    }
}
