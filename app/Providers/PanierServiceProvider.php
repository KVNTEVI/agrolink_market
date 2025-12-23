<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Pour partager des données avec les vues
use Illuminate\Support\Facades\Auth; // Pour gérer l'utilisateur connecté
use App\Models\PanierItem;           // Ton modèle pour les articles du panier

class PanierServiceProvider extends ServiceProvider
{
    /**
     * La méthode boot est appelée après que tous les services sont enregistrés.
     * C'est ici qu'on définit ce qui doit être partagé avec les vues.
     */
    public function boot(): void
    {
        // View::composer('*', ...) signifie : "Pour TOUTES les pages du site (*)"
        View::composer('*', function ($view) {
            
            // On initialise le compteur à 0 par défaut
            $count = 0;

            // 1. On vérifie si l'utilisateur est connecté
            // 2. On vérifie s'il a bien le rôle 'acheteur' (car un admin n'a pas de panier)
            if (Auth::check() && Auth::user()->role_id == 2) { 
                
                // On va chercher dans la table PanierItem (les articles)
                $count = PanierItem::whereHas('panier', function ($q) {
                    // On filtre pour ne prendre que le panier qui appartient à l'utilisateur connecté
                    $q->where('utilisateur_id', Auth::id());
                })
                // Au lieu de compter les lignes, on additionne les quantités
                // (Ex: si j'ai 2 tomates et 1 oignon, le badge affichera 3)
                ->sum('quantite');
            }

            // On envoie la variable 'panierCount' à la vue
            // Tu pourras l'utiliser dans ta navbar avec {{ $panierCount }}
            $view->with('panierCount', $count);
        });
    }

    public function register(): void
    {
        //
    }
}