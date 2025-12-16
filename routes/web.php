<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::middleware(['auth', 'producteur'])->get('/producteur/dashboard', function () {
    return view('producteur.dashboard');
});

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
        Route::get('/commandes', [CommandeController::class, 'index'])
        ->name('commandes.index');

    Route::post('/commandes', [CommandeController::class, 'store'])
        ->name('commandes.store');
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
