<?php
namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;

// Contrôleur de gestion du démarrage et de l'affichage des conversations
class ConversationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'acheteur']);
    }

    /**
     * Liste toutes les conversations de l'acheteur
     */
    public function index()
    {
        // On récupère les conversations où l'utilisateur est l'acheteur
        // On charge les relations 'producteur' et 'produit' pour l'affichage
        $conversations = Conversation::where('acheteur_id', Auth::id())
            ->with(['producteur', 'produit'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('acheteur.conversation.index', compact('conversations'));
    }

    /**
     * Démarrer ou retrouver une conversation existante pour un produit donné.
     *
     * @param  int  $produitId L'ID du produit pour lequel la conversation est démarrée.
     * @return Redirector|\Illuminate\Http\RedirectResponse
     */
public function start($produitId)
{
    $produit = Produit::findOrFail($produitId);

    // 1. On cherche d'abord s'il y a une conversation "active" pour ce produit
    $conversation = Conversation::where('acheteur_id', Auth::id())
        ->where('produit_id', $produit->id_produit)
        ->whereIn('statut', ['ouverte', 'prix_accepte']) // On ignore 'cloturee'
        ->first();

    // 2. Si aucune conversation active n'existe, on en crée une nouvelle
    if (!$conversation) {
        $conversation = Conversation::create([
            'acheteur_id' => Auth::id(),
            'producteur_id' => $produit->producteur_id,
            'produit_id' => $produit->id_produit,
            'statut' => 'ouverte'
        ]);
    }

    return redirect()->route('acheteur.conversation.show', $conversation->id_conversation); 
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

    public function finaliserCommande(Request $request, $id)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1'
        ]);

        $conversation = Conversation::findOrFail($id);

        // Sécurité : Vérifier que c'est bien l'acheteur et que le prix est validé
        if ($conversation->acheteur_id !== Auth::id() || $conversation->statut !== 'prix_accepte') {
            return back()->with('error', 'Action non autorisée.');
        }

        // 1. Calcul du montant total
        $montantTotal = $conversation->prix_final * $request->quantite;

        // 2. Création de la Commande (Table : commandes)
        $commande = \App\Models\Commande::create([
            'acheteur_id'   => $conversation->acheteur_id,
            'producteur_id' => $conversation->producteur_id,
            'montant_total' => $montantTotal,
            'statut'        => 'en_attente',
        ]);

        // 3. Création du détail de la commande (Table : commande_items)
        \App\Models\CommandeItem::create([
            'commande_id' => $commande->id_commande, // On récupère l'ID fraîchement créé
            'produit_id'  => $conversation->produit_id,
            'quantite'    => $request->quantite,
            'prix_final'  => $conversation->prix_final,
        ]);

        // 4. Clôturer la négociation
        $conversation->update(['statut' => 'cloturee']);

        return redirect()->route('acheteur.paiement.show', $commande->id_commande)
                        ->with('success', 'Commande créée ! Veuillez finaliser le paiement.');
    }
}