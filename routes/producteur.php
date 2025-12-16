<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Producteur\ProducteurController;
use App\Http\Controllers\Producteur\ProduitController;
use App\Http\Controllers\Producteur\CommandeController;

Route::get('/dashboard', [ProducteurController::class, 'index'])->name('producteur.dashboard');

// Produits
Route::resource('/produits', ProduitController::class);

// Commandes reçues
Route::get('/commandes', [CommandeController::class, 'index'])->name('producteur.commandes');

// Profil + Logout
Route::get('/profil', [ProducteurController::class, 'profil'])->name('producteur.profil');
Route::post('/logout', [ProducteurController::class, 'logout'])->name('producteur.logout');
