<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Produit;

/**
 * Ce contrôleur gère l'affichage des profils des producteurs et de leurs catalogues spécifiques.
 * Contrairement au BoutiqueController qui mélange tout, celui-ci segmente par vendeur.
 */
class MagazinController extends Controller
{
    /**
     * Affiche la liste de tous les producteurs inscrits et actifs.
     * * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. On filtre les utilisateurs par leur rôle
        $producteurs = Utilisateur::whereHas('role', function ($q) {
                // On ne récupère que ceux dont le rôle est 'producteur'
                $q->where('nom', 'producteur');
            })
            // 2. On vérifie que le compte du producteur est actif (statut true)
            ->where('statut', true)
            ->get();

        // 3. Retourne la vue avec la liste des vendeurs
        return view('magazin.index', compact('producteurs'));
    }

    /**
     * Affiche le profil public détaillé d'un producteur (Bio, Localisation, etc.)
     * * @param int $id ID de l'utilisateur (producteur)
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // On récupère l'utilisateur en s'assurant qu'il possède bien le rôle producteur
        // Cela évite qu'un petit malin puisse voir le profil d'un admin via cette route.
        $producteur = Utilisateur::whereHas('role', function ($q) {
                $q->where('nom', 'producteur');
            })
            ->where('id_utilisateur', $id) // Utilisation de votre clé primaire personnalisée
            ->firstOrFail(); // Renvoie une 404 si non trouvé ou si ce n'est pas un producteur

        return view('magazin.show', compact('producteur'));
    }

    /**
     * Affiche uniquement les produits appartenant à un producteur spécifique.
     * * @param int $id ID du producteur
     * @return \Illuminate\View\View
     */
    public function produits($id)
    {
        // 1. On vérifie d'abord que le producteur existe
        $producteur = Utilisateur::findOrFail($id);

        // 2. On récupère ses produits validés uniquement
        $produits = Produit::where('producteur_id', $id)
            ->where('statut', 'valide')
            // Pagination pour ne pas surcharger la page si le producteur a beaucoup d'articles
            ->paginate(10);

        // 3. On passe les deux variables à la vue : 
        // - $producteur pour afficher son nom en titre
        // - $produits pour la grille des articles
        return view('magazin.produits', compact('producteur', 'produits'));
    }
}