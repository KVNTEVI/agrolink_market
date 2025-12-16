<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UtilisateurController;
use App\Http\Controllers\Admin\CategorieController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\AvisController;
use App\Http\Controllers\Admin\CommandeController;
use App\Http\Controllers\Admin\PaiementController;

Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

// Gestion des utilisateurs
Route::get('/utilisateurs', [UtilisateurController::class, 'index'])->name('admin.utilisateurs');
Route::delete('/utilisateurs/{id}', [UtilisateurController::class, 'destroy']);

// Gestion des catégories
Route::resource('/categories', CategorieController::class);

// Gestion des produits
Route::get('/produits', [ProduitController::class, 'index'])->name('admin.produits');
Route::put('/produits/{id}/valider', [ProduitController::class, 'valider'])->name('admin.produits.valider');
Route::delete('/produits/{id}', [ProduitController::class, 'destroy']);

// Gestion des avis
Route::get('/avis', [AvisController::class, 'index'])->name('admin.avis');
Route::delete('/avis/{id}', [AvisController::class, 'destroy']);



// Paiements
Route::get('/paiements', [PaiementController::class, 'index'])->name('admin.paiements');

// Profil + Logout
Route::get('/profil', [AdminController::class, 'profil'])->name('admin.profil');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
