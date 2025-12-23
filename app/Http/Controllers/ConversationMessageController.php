<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // Import de la classe de base Controller
use App\Models\Message;
use App\Models\Conversation;       // Import du modèle Conversation pour la vérification
use App\Models\Utilisateur; 
use App\Notifications\NouvelleNegociationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;    // Pour la validation optimisée

class ConversationMessageController extends Controller
{
    /**
     * Enregistre un nouveau message ou une proposition de prix dans la conversation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $conversationId L'ID de la conversation cible.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $conversationId)
    {
        // 1. VÉRIFICATION DE LA PARTICIPATION (Sécurité essentielle)
        $conversation = Conversation::findOrFail($conversationId);

        // L'utilisateur doit être l'acheteur OU le producteur de cette conversation.
        if ($conversation->acheteur_id !== Auth::id() && $conversation->producteur_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette conversation.');
        }

        // BLOQUER SI LA CONVERSATION N'EST PLUS OUVERTE
        if ($conversation->statut !== 'ouverte') {
            return back()->with('error', 'Cette négociation est déjà terminée (Accord trouvé ou Refus).');
        }

        // 2. VALIDATION DES DONNÉES
        // S'assure qu'au moins 'contenu' ou 'prix_propose' est présent.
        $request->validate([
            'contenu' => [
                // Requis si 'prix_propose' est vide
                Rule::requiredIf(empty($request->prix_propose)), 
                'nullable', 
                'string'
            ], 
            'prix_propose' => [
                // Requis si 'contenu' est vide
                Rule::requiredIf(empty($request->contenu)),
                'nullable', 
                'numeric', 
                'min:1'
            ]
        ]);

        // 3. CRÉATION DU MESSAGE
        Message::create([
            'conversation_id' => $conversationId,
            'expediteur_id' => Auth::id(), // L'expéditeur est l'utilisateur connecté
            'contenu' => $request->contenu,
            'prix_propose' => $request->prix_propose
        ]);

        // 4. NOTIFICATION DE L'AUTRE PARTIE
    // 4.1 Déterminer l'ID du destinataire (l'autre partie de la conversation)
        $destinataireId =
            Auth::id() === $conversation->acheteur_id
            ? $conversation->producteur_id // Si l'expéditeur est l'acheteur, le destinataire est le producteur
            : $conversation->acheteur_id;  // Sinon, le destinataire est l'acheteur

        // 4.2 Récupérer le modèle utilisateur du destinataire
        $destinataire = Utilisateur::find($destinataireId);

        // 4.3 Envoyer la notification
        // Le type est 'offre' si prix_propose est fourni, sinon c'est un simple 'message'
        $destinataire->notify(
            new NouvelleNegociationNotification(
                $conversation,
                $request->prix_propose ? 'offre' : 'message'
            )
        );

        // Retourne à la vue précédente (la conversation)
        return back();
    }
}