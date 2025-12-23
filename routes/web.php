<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\AvisController;
use App\Http\Controllers\Admin\PaiementController as AdminPaiementController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Acheteur\AcheteurController;
use App\Http\Controllers\Acheteur\CommandeController;
use App\Http\Controllers\Acheteur\PanierController;
use App\Http\Controllers\Producteur\ProducteurController;
use App\Http\Controllers\Producteur\ProduitController as ProduitProducteurController;
use App\Http\Controllers\Producteur\CommandeController as CommandeProducteurController;
use App\Http\Controllers\Acheteur\ConversationController as AcheteurConversationController;
use App\Http\Controllers\Producteur\ConversationController as ProducteurConversationController;
use App\Http\Controllers\ConversationMessageController;
use App\Http\Controllers\Acheteur\PaiementController as AcheteurPaiementController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\MagazinController;
use App\Http\Controllers\ContactController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::middleware(['auth', 'producteur'])->get('/producteur/dashboard', function () {
    return view('producteur.dashboard');
});

Route::get('/producteur/notifications-data', function () {
    // On récupère uniquement les notifications non lues de l'utilisateur connecté
    return response()->json(Auth::user()->unreadNotifications);
})->name('producteur.notifications')->middleware('auth');

Route::post('/producteur/notifications/{id}/read', function ($id) {
    // On récupère l'utilisateur et on dit explicitement à l'éditeur : "C'est un Utilisateur"
    /** @var Utilisateur $user */
    $user = Auth::user(); 

    // Maintenant $user->notifications() ne sera plus en rouge
    $user->unreadNotifications()
         ->where('id', $id)
         ->update(['read_at' => now()]);

    return back();
})->name('producteur.notifications.read');

Route::middleware(['auth', 'acheteur'])->get('/acheteur/dashboard', function () {
    return view('acheteur.dashboard');
});


Route::middleware(['auth', 'admin'])->get(
    '/admin/dashboard',
    [AdminController::class, 'dashboard']
)->name('admin.dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
Route::get('/utilisateurs', [UtilisateurController::class, 'index'])
        ->name('admin.utilisateurs.index');

Route::patch('/utilisateurs/{id}/statut', [UtilisateurController::class, 'toggleStatut'])
        ->name('admin.utilisateurs.statut');

Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy'])
        ->name('admin.utilisateurs.destroy');
});

Route::middleware(['auth', 'admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
    Route::resource('categories', CategorieController::class);
    Route::get('avis', [AvisController::class, 'index'])
            ->name('avis.index');

    Route::delete('avis/{id}', [AvisController::class, 'destroy'])
            ->name('avis.destroy');
    Route::get('paiements', [AdminPaiementController::class, 'index'])
            ->name('paiements.index');
    Route::get('produits', [ProduitController::class, 'index'])
            ->name('produits.index');

    Route::patch('produits/{id}/approve', [ProduitController::class, 'approve'])
            ->name('produits.approve');

    Route::patch('produits/{id}/reject', [ProduitController::class, 'reject'])
            ->name('produits.reject');

    Route::delete('produits/{id}', [ProduitController::class, 'destroy'])
            ->name('produits.destroy');
});

Route::middleware(['auth', 'acheteur'])
    ->prefix('acheteur')
    ->name('acheteur.')
    ->group(function () {
            Route::get('/dashboard', [AcheteurController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/profil', [AcheteurController::class, 'profil'])
        ->name('profil');

    Route::post('/profil', [AcheteurController::class, 'updateProfil'])
        ->name('profil.update');

    Route::get('/panier', [PanierController::class, 'index'])
        ->name('panier.index');

    Route::post('/panier/ajouter/{id}', [PanierController::class, 'add'])
        ->name('panier.add');

    Route::delete('/panier/item/{id}', [PanierController::class, 'remove'])
            ->name('panier.remove');

    Route::get('/commandes', [CommandeController::class, 'index'])
        ->name('commandes.index');

    Route::post('/commandes', [CommandeController::class, 'store'])
        ->name('commandes.store');

    Route::get('/commandes/{id}', [CommandeController::class, 'show'])
        ->name('commandes.show');
});

Route::middleware(['auth', 'producteur'])
    ->prefix('producteur')
    ->name('producteur.')
    ->group(function () {
    Route::get('/dashboard', [ProducteurController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/profil', [ProducteurController::class, 'profil'])
        ->name('profil');

    Route::post('/profil', [ProducteurController::class, 'updateProfil'])
        ->name('profil.update');
    Route::get('/produits', [ProduitProducteurController::class, 'index'])
        ->name('produits.index');

    Route::get('/produits/create', [ProduitProducteurController::class, 'create'])
        ->name('produits.create');

    Route::post('/produits', [ProduitProducteurController::class, 'store'])
        ->name('produits.store');
    Route::get('/commandes', [CommandeProducteurController::class, 'index'])
        ->name('commandes.index');

    Route::patch('/commandes/{id}/{status}', [CommandeProducteurController::class, 'updateStatus'])
        ->name('commandes.status');
    
    Route::post('/conversation/{id}/message', 
    [AcheteurConversationController::class, 'store'])
        ->name('message.store');

});

Route::middleware(['auth'])->group(function () {

    // Afficher une conversation
    Route::get('/conversation/{id}',
        [AcheteurConversationController::class, 'show']
    )->name('conversation.show');

    // Envoyer message OU offre de prix (ACHETEUR & PRODUCTEUR)
    Route::post('/conversation/{id}/message',
        [ConversationMessageController::class, 'store']
    )->name('conversation.message.store');
});

Route::middleware(['auth', 'acheteur'])->group(function () {

    Route::get('/negociation/start/{produit}',
        [AcheteurConversationController::class, 'start']
    )->name('conversation.start');
});

Route::middleware(['auth', 'producteur'])->group(function () {

    Route::post('/conversation/{id}/accepter',
        [ProducteurConversationController::class, 'accepterOffre']
    )->name('conversation.accepter');

    Route::post('/conversation/{id}/refuser',
        [ProducteurConversationController::class, 'refuser']
    )->name('conversation.refuser');
});

Route::get('/notifications', function () {
    return Auth::user()->notifications;
})->middleware('auth');

Route::middleware(['auth', 'acheteur'])->group(function () {

    Route::get('/paiement/{commande}',
        [AcheteurPaiementController::class, 'show']
    )->name('paiement.show');

    Route::post('/paiement/{commande}/payer',
        [AcheteurPaiementController::class, 'payer']
    )->name('paiement.payer');
});

Route::get('/boutique', [BoutiqueController::class, 'index'])
    ->name('boutique.index');

Route::get('/boutique/produit/{id}', [BoutiqueController::class, 'show'])
    ->name('boutique.show');

Route::get('/magazin', [MagazinController::class, 'index'])
    ->name('magazin.index');

Route::get('/magazin/producteur/{id}', [MagazinController::class, 'show'])
    ->name('magazin.show');

Route::get('/magazin/producteur/{id}/produits', [MagazinController::class, 'produits'])
    ->name('magazin.produits');

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact.index');

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');

Route::get('/apropos', function () {
    return view('apropos.index');
})->name('apropos');
