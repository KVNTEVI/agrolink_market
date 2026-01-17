<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Commande;
use App\Models\CommandeItem;
use App\Models\Conversation;

// Contrôleur dédié au tableau de bord et à la gestion du profil de l'acheteur
class AcheteurController extends Controller
{
    // Applique les middlewares de sécurité.
    public function __construct()
    {
        $this->middleware(['auth', 'acheteur']);
    }

    // Affiche le tableau de bord principal de la zone Acheteur.
    public function dashboard()
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();

        // 1. Statistiques
        $unreadNotificationsCount = $user->unreadNotifications->count();
        $messagesCount = \App\Models\Conversation::where('acheteur_id', $user->id_utilisateur)->count();
        
        // Ajout : Nombre de commandes en cours
        $commandesEnCoursCount = \App\Models\Commande::where('acheteur_id', $user->id_utilisateur)
            ->whereIn('statut', ['en_attente', 'expedie'])
            ->count();

        // 2. Récupérer les dernières commandes pour le tableau
        $dernieresCommandes = \App\Models\Commande::where('acheteur_id', $user->id_utilisateur)
        ->with('items.produit')
        ->latest()
        ->take(5)
        ->get();

        return view('acheteur.dashboard', compact(
            'unreadNotificationsCount', 
            'messagesCount', 
            'commandesEnCoursCount',
            'dernieresCommandes'
        ));
    }

    /**
     * Affiche la liste complète des notifications de l'acheteur avec pagination
     */
    public function notifications()
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user();

        // On récupère toutes les notifications avec une pagination (10 par page)
        $allNotifications = $user->notifications()
            ->latest() 
            ->paginate(10);

        return view('acheteur.notifications', compact('allNotifications'));
    }

    public function finaliserCommande(Request $request, $id)
    {
        // 1. Validation de la quantité
        $request->validate([
            'quantite' => 'required|integer|min:1'
        ]);

        // 2. Récupération de la conversation
        $conversation = Conversation::where('acheteur_id', Auth::id())
            ->findOrFail($id);

        // Vérifier que le prix a bien été accepté
        if ($conversation->statut !== 'prix_accepte' || !$conversation->prix_final) {
            return back()->with('error', 'Le prix n\'a pas encore été validé par le producteur.');
        }

        try {
            DB::transaction(function () use ($conversation, $request) {
                
                // 3. Création de la Commande (En-tête)
                $commande = Commande::create([
                    'acheteur_id'   => $conversation->acheteur_id,
                    'producteur_id' => $conversation->producteur_id,
                    'montant_total' => $conversation->prix_final * $request->quantite,
                    'statut'        => 'en_attente' // ou 'payée' selon votre logique
                ]);

                // 4. Création du détail (CommandeItem)
                CommandeItem::create([
                    'commande_id' => $commande->id_commande, // Adaptez selon votre clé primaire
                    'produit_id'  => $conversation->produit_id,
                    'quantite'    => $request->quantite,
                    'prix_final'  => $conversation->prix_final
                ]);

                // 5. Mise à jour de la conversation (Clôture)
                $conversation->update([
                    'statut' => 'cloturee' // La négociation est terminée, elle devient une commande
                ]);
            });

            return redirect()->route('acheteur.commandes.index') // Redirige vers la liste des commandes
                ->with('success', 'Votre commande a été générée avec succès !');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création de la commande : ' . $e->getMessage());
        }
    }

    // Affiche le formulaire d'édition/consultation du profil de l'utilisateur connecté.
    public function profil()
    {
        $user = Auth::user(); 
        return view('acheteur.profil.index', compact('user'));
    }

    // Gère la mise à jour des informations du profil (nom, email).
    public function updateProfil(Request $request)
    {
        /** @var \App\Models\Utilisateur $user */
        $user = Auth::user(); 

        $request->validate([
            'nom' => 'required',
            'email' => 'required|email'
        ]);

        $user->update($request->only(['nom', 'email']));

        return back()->with('success', 'Profil mis à jour.');
    }
}