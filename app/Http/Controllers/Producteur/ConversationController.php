<?php

namespace App\Http\Controllers\Producteur;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
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

        // --- MARQUAGE AUTOMATIQUE COMME LU ---
        Auth::user()->unreadNotifications
            ->where('data.conversation_id', $id)
            ->markAsRead();
        // -------------------------------------

        return view('producteur.conversations.show', compact('conversation'));
    }

    /**
     * Valider le prix proposé : Fixe le prix et attend le choix de la quantité par l'acheteur
     */
    public function accepterOffre($conversationId)
    {
        $conversation = Conversation::where('producteur_id', Auth::id())
            ->with(['acheteur', 'produit']) // Ajout du produit pour retrouver la commande
            ->findOrFail($conversationId);

        // Récupération du prix proposé dans le dernier message
        $dernierPrix = $conversation->messages()
            ->whereNotNull('prix_propose')
            ->latest()
            ->value('prix_propose');

        if (!$dernierPrix) {
            return back()->with('error', 'Aucune proposition de prix valide trouvée.');
        }

        // --- TON CODE EXISTANT (Conservé) ---
        $conversation->update([
            'statut' => 'prix_accepte',
            'prix_final' => $dernierPrix
        ]);

        // --- AJOUT : SYNCHRONISATION AVEC LA COMMANDE ---
        // On cherche la commande "en attente" pour cet acheteur et ce produit
        // Note : On utilise first() car il peut n'y en avoir qu'une en cours
        $commande = \App\Models\Commande::where('acheteur_id', $conversation->acheteur_id)
            ->where('statut', 'en_attente')
            ->whereHas('items', function($query) use ($conversation) {
                $query->where('produit_id', $conversation->produit_id);
            })
            ->first();

        if ($commande) {
            // On récupère la quantité pour calculer le nouveau montant total
            // Si c'est un forfait global (ex: les 320 000 pour tout le lot), 
            // on met directement le prix final.
            $item = $commande->items()->where('produit_id', $conversation->produit_id)->first();
            $nouveauTotal = $dernierPrix * ($item ? $item->quantite : 1);

            $commande->update([
                'montant_total' => $nouveauTotal,
                'producteur_id' => Auth::id() // On sécurise le lien avec le producteur
            ]);

            // Optionnel : Mettre à jour le prix_final dans la table pivot (items)
            if ($item) {
                $item->update(['prix_final' => $dernierPrix]);
            }
        }
        // ----------------------------------------------

        // Notification de l'acheteur
        if ($conversation->acheteur) {
            $conversation->acheteur->notify(
                new NouvelleNegociationNotification($conversation, 'accepte')
            );
        }

        return back()->with('success', 'Prix validé ! Le montant de la commande a été mis à jour.');
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