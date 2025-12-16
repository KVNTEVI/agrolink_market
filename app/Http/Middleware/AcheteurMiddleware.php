<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcheteurMiddleware
{
    /**
     * Gère la requête HTTP entrante et vérifie les permissions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Vérifie si l'utilisateur n'est PAS connecté (Auth::check())
        // OU si l'utilisateur connecté n'a PAS le role_id 3 (Acheteur).
        // (Nous supposons que l'ID 3 correspond au rôle 'Acheteur'.)
        if (!Auth::check() || Auth::user()->role_id != 2) { 
            
            // Si la condition est VRAIE (utilisateur non autorisé), l'accès est bloqué.
            // Affiche une erreur HTTP 403 (Accès interdit/Forbidden).
            abort(403, "Accès réservé aux acheteurs.");
        }

        // 2. Si l'utilisateur est connecté ET a le role_id = 3, la requête est autorisée
        // et transmise à la destination finale (la route/le contrôleur).
        return $next($request);
    }
}