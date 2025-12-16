<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Gère la requête entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Vérifie si l'utilisateur est connecté (auth()->check())
        // OU si l'utilisateur connecté n'a PAS le role_id 1 (Administrateur).
        // (NOTE : Le rôle 'Administrateur' est généralement associé à l'ID 1 dans la base de données.)
        if (!Auth::check() || Auth::user()->role_id != 1) { 
            // Si la condition est VRAIE (non connecté OU n'est pas Admin), l'accès est bloqué.
            // Affiche une erreur HTTP 403 (Accès interdit/Forbidden).
            abort(403, "Accès interdit.");
        }

        // 2. Si l'utilisateur est connecté ET a le role_id = 1, la requête est transmise 
        // à la prochaine étape (le contrôleur ou le middleware suivant).
        return $next($request);
    }
}