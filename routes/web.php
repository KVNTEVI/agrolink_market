<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Importation des Contrôleurs
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConversationMessageController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\MagazinController;
use App\Http\Controllers\ContactController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\AvisController;
use App\Http\Controllers\Admin\PaiementController as AdminPaiementController;
use App\Http\Controllers\Admin\ProduitController as ProduitAdminController;

// Acheteur Controllers
use App\Http\Controllers\Acheteur\AcheteurController;
use App\Http\Controllers\Acheteur\CommandeController;
use App\Http\Controllers\Acheteur\PanierController;
use App\Http\Controllers\Acheteur\ConversationController as AcheteurConversationController;
use App\Http\Controllers\Acheteur\PaiementController as AcheteurPaiementController;

// Producteur Controllers
use App\Http\Controllers\Producteur\ProducteurController;
use App\Http\Controllers\Producteur\ProduitController as ProduitProducteurController;
use App\Http\Controllers\Producteur\CommandeController as CommandeProducteurController;
use App\Http\Controllers\Producteur\ConversationController as ProducteurConversationController;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']); 

Auth::routes();

Route::get('/boutique', [BoutiqueController::class, 'index'])->name('boutique.index');
Route::get('/boutique/produit/{id}', [BoutiqueController::class, 'show'])->name('boutique.show');
Route::get('/magazin', [MagazinController::class, 'index'])->name('magazin.index');
Route::get('/magazin/producteur/{id}', [MagazinController::class, 'show'])->name('magazin.show');
Route::get('/magazin/producteur/{id}/produits', [MagazinController::class, 'produits'])->name('magazin.produits');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/apropos', function () { return view('apropos.index'); })->name('apropos');
Route::get('/conditions-generales', function () { return view('legal.cgu'); })->name('cgu');

/*
|--------------------------------------------------------------------------
| ROUTES ACHETEUR (Préfixe: acheteur / Nom: acheteur.*)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'acheteur'])->prefix('acheteur')->name('acheteur.')->group(function () {
    Route::get('/dashboard', [AcheteurController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', [AcheteurController::class, 'profil'])->name('profil');
    Route::post('/profil', [AcheteurController::class, 'updateProfil'])->name('profil.update');
    
    Route::get('/notifications', [AcheteurController::class, 'notifications'])->name('notifications.index');

    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/ajouter/{id}', [PanierController::class, 'add'])->name('panier.add');
    Route::delete('/panier/item/{id}', [PanierController::class, 'remove'])->name('panier.remove');

    Route::get('/paiements', [AcheteurPaiementController::class, 'index'])->name('paiements.index');

    Route::post('/notifications/read-all', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return back()->with('success', 'Tout est marqué comme lu.');
    })->name('notifications.readAll');
    Route::get('/notifications/{id}/read-and-view', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Si c'est un message, on va vers la conversation
        if (isset($notification->data['conversation_id'])) {
            return redirect()->route('acheteur.conversation.show', $notification->data['conversation_id']);
        }
        
        // Sinon on retourne juste à la liste (ou vers la commande si tu as l'id)
        return back();
    })->name('notifications.readAndView');

    // Messagerie Acheteur
    Route::get('/messages', [AcheteurConversationController::class, 'index'])->name('conversation.index');
    Route::get('/messages/{id}', [AcheteurConversationController::class, 'show'])->name('conversation.show');
    Route::get('/negociation/start/{produit}', [AcheteurConversationController::class, 'start'])->name('conversation.start');
    Route::post('/conversation/{id}/finaliser', [AcheteurConversationController::class, 'finaliserCommande'])
        ->name('conversation.finaliser');

    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::post('/commandes', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/commandes/{id}', [CommandeController::class, 'show'])->name('commandes.show');

    Route::get('/paiement/{commande}', [AcheteurPaiementController::class, 'show'])->name('paiement.show');
    Route::post('/paiement/{commande}/payer', [AcheteurPaiementController::class, 'payer'])->name('paiement.payer');
});

/*
|--------------------------------------------------------------------------
| ROUTES PRODUCTEUR (Préfixe: producteur / Nom: producteur.*)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'producteur'])->prefix('producteur')->name('producteur.')->group(function () {
    
    // DASHBOARD
    Route::get('/dashboard', [ProducteurController::class, 'dashboard'])->name('dashboard');

    // PROFIL (Une seule route pour afficher, une seule pour mettre à jour)
    Route::get('/profil', [ProducteurController::class, 'profil'])->name('profil');
    Route::put('/profil/update', [ProducteurController::class, 'updateProfil'])->name('profil.update');

    Route::resource('produit', ProduitProducteurController::class);

    // COMMANDES
    Route::get('/commandes', [CommandeProducteurController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{id}/status/{status}', [CommandeProducteurController::class, 'updateStatus'])->name('commandes.status');

    // MESSAGERIE
    Route::get('/conversation', [ProducteurConversationController::class, 'index'])->name('conversation.index');
    Route::get('/conversation/{id}', [ProducteurConversationController::class, 'show'])->name('conversation.show');
    Route::post('/conversation/{id}/accepter', [ProducteurConversationController::class, 'accepterOffre'])->name('conversation.accepter');
    Route::post('/conversation/{id}/refuser', [ProducteurConversationController::class, 'refuser'])->name('conversation.refuser');

    // NOTIFICATIONS
    // On utilise la méthode du contrôleur que nous avons créée pour la pagination
    Route::get('/notifications', [ProducteurController::class, 'notifications'])->name('notifications');
    
    Route::post('/notifications/read-all', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    })->name('notifications.readAll');

});

/*
|--------------------------------------------------------------------------
| ROUTES ADMIN (Préfixe: admin / Nom: admin.*)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('utilisateurs.index');
    Route::patch('/utilisateurs/{id}/statut', [UtilisateurController::class, 'toggleStatut'])->name('utilisateurs.statut');
    Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy'])->name('utilisateurs.destroy');

    Route::resource('categories', CategorieController::class);
    Route::resource('avis', AvisController::class)->only(['index', 'destroy']);
    
    Route::get('paiements', [AdminPaiementController::class, 'index'])->name('paiements.index');

    Route::get('paiements/{id}', [AdminPaiementController::class, 'show'])->name('paiements.show');
    // Le nom final sera automatiquement 'admin.notifications'
    Route::get('/notifications', function () { 
        return view('admin.notifications'); 
    })->name('notifications');

    Route::get('/notifications', function () {
    // 1. On récupère toutes les notifications de l'admin (paginées)
    $notifications = Auth::user()->notifications()->paginate(10);
    
    // 2. On injecte la variable $notifications dans la vue
    return view('admin.notifications', compact('notifications'));
    })->name('notifications');

    // Le nom final sera automatiquement 'admin.notifications.readAll'
    Route::post('/notifications/read-all', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    })->name('notifications.readAll');

    // Ajoute ceci dans le groupe Admin
    Route::get('/notifications/{id}/read-and-view', function ($id) {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Redirection vers le détail du paiement pour l'admin
        if (isset($notification->data['commande_id'])) {
            return redirect()->route('admin.paiements.show', $notification->data['commande_id']);
        }

        return back();
    })->name('notifications.readAndView');
    // ----------------------------------------

    Route::get('produits', [ProduitAdminController::class, 'index'])->name('produits.index');
    Route::patch('produits/{id}/approve', [ProduitAdminController::class, 'approve'])->name('produits.approve');
    Route::patch('produits/{id}/reject', [ProduitAdminController::class, 'reject'])->name('produits.reject');
    Route::delete('produits/{id}', [ProduitAdminController::class, 'destroy'])->name('produits.destroy');
});


/*
|--------------------------------------------------------------------------
| ROUTES COMMUNES (Authentifiés uniquement)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Correction du nom de la route pour correspondre à tes formulaires Blade
    Route::post('/conversation/{id}/message', [ConversationMessageController::class, 'store'])->name('messages.store');

    Route::get('/api/notifications-data', function () {
        return response()->json(Auth::user()->unreadNotifications);
    })->name('notifications.data');

    Route::post('/notifications/{id}/read', function ($id) {
        Auth::user()->notifications()->findOrFail($id)->markAsRead();
        return back();
    })->name('notifications.read');

    Route::post('/notifications/producteur/{id}/read', function ($id) {
        Auth::user()->unreadNotifications()->where('id', $id)->update(['read_at' => now()]);
        return back();
    })->name('producteur.notifications.read');
});