<?php
namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;

// Contrôleur de gestion du démarrage et de l'affichage des conversations
class ConversationController extends Controller
{
    /**
     * Démarrer ou retrouver une conversation existante pour un produit donné.
     *
     * @param  int  $produitId L'ID du produit pour lequel la conversation est démarrée.
     * @return Redirector|\Illuminate\Http\RedirectResponse
     */
    public function start($produitId)
    {
        $produit = Produit::findOrFail($produitId);

        // Vérifie si une conversation existe déjà, sinon la crée.
        $conversation = Conversation::firstOrCreate(
            [
                'acheteur_id' => Auth::id(),
                'producteur_id' => $produit->producteur_id,
                'produit_id' => $produit->id_produit
            ],
            [
                'statut' => 'ouverte'
            ]
        );

        // Redirige vers la vue de la conversation (utilise l'ID de la clé primaire)
        return redirect()->route('conversation.show', $conversation->id_conversation); 
    }

    /**
     * Affiche l'interface de la conversation spécifique avec Eager Loading.
     *
     * @param  int  $id L'ID de la conversation.
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // 1. Récupération de la conversation avec Eager Loading
        // Charge la conversation et les messages associés, ainsi que l'expéditeur de chaque message, et le produit concerné.
        $conversation = Conversation::with([
            'messages.expediteur', // Charge les messages ET l'utilisateur qui a envoyé le message
            'produit'              // Charge le produit concerné par la conversation
        ])->findOrFail($id);

        // 2. Vérification d'autorisation (Sécurité essentielle)
        // L'utilisateur doit être l'acheteur OU le producteur de cette conversation.
        if ($conversation->acheteur_id !== Auth::id() && $conversation->producteur_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette conversation.');
        }
        
        // 3. Affichage de la vue
        // Assurez-vous que cette vue existe bien : resources/views/conversation/show.blade.php
        return view('conversation.show', compact('conversation'));
    }
}