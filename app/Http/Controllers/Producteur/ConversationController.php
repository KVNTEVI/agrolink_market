<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Commande;
use App\Models\CommandeItem; // Ton modèle est maintenant bien utilisé
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Notifications\NouvelleNegociationNotification;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'producteur']);
    }

    /**
     * Liste toutes les négociations du producteur
     */
    public function index()
    {
        $conversations = Conversation::where('producteur_id', Auth::id())
            ->with(['produit', 'acheteur'])
            ->latest()
            ->get();

        return view('producteur.conversations.index', compact('conversations'));
    }

    /**
     * Affiche le détail d'une discussion
     */
    public function show($id)
    {
        $conversation = Conversation::where('producteur_id', Auth::id())
            ->with(['messages.expediteur', 'produit', 'acheteur'])
            ->findOrFail($id);

        return view('producteur.conversations.show', compact('conversation'));
    }

    /**
     * Accepter l'offre : Crée une Commande ET un CommandeItem
     */
    public function accepterOffre($conversationId)
    {
        $conversation = Conversation::where('producteur_id', Auth::id())
            ->with('acheteur')
            ->findOrFail($conversationId);

        // Récupération du prix proposé dans le dernier message
        $dernierPrix = $conversation->messages()
            ->whereNotNull('prix_propose')
            ->latest()
            ->value('prix_propose');

        if (!$dernierPrix) {
            return back()->with('error', 'Aucune proposition de prix valide trouvée.');
        }

        try {
            DB::transaction(function () use ($conversation, $dernierPrix) {
                
                // 1. Mise à jour du statut de la négociation
                $conversation->update([
                    'statut' => 'accord_trouve',
                    'prix_final' => $dernierPrix
                ]);

                // 2. Création de la Commande (En-tête)
                $commande = Commande::create([
                    'acheteur_id'   => $conversation->acheteur_id,
                    'producteur_id' => $conversation->producteur_id,
                    'montant_total' => $dernierPrix,
                    'statut'        => 'en_attente'
                ]);

                // 3. UTILISATION DE TON MODÈLE CommandeItem (Le détail)
                // On crée explicitement l'item lié à la commande
                CommandeItem::create([
                    'commande_id' => $commande->id_commande, // Récupère l'ID de la commande créée
                    'produit_id'  => $conversation->produit_id,
                    'quantite'    => 1, 
                    'prix_final'  => $dernierPrix
                ]);

                // 4. Notification de l'acheteur
                if ($conversation->acheteur) {
                    $conversation->acheteur->notify(
                        new NouvelleNegociationNotification($conversation, 'accepte')
                    );
                }
            });

            return back()->with('success', 'Offre acceptée ! La commande et son détail ont été créés.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la validation : ' . $e->getMessage());
        }
    }

    /**
     * Refuser et clôturer la négociation
     */
    public function refuser($conversationId)
    {
        $conversation = Conversation::where('producteur_id', Auth::id())
            ->with('acheteur')
            ->findOrFail($conversationId);

        $conversation->update(['statut' => 'cloturee']);

        if ($conversation->acheteur) {
            $conversation->acheteur->notify(
                new NouvelleNegociationNotification($conversation, 'refuse')
            );
        }

        return back()->with('error', 'Négociation refusée et conversation clôturée.');
    }
}