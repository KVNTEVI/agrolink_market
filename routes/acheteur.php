<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Acheteur\AcheteurController;
use App\Http\Controllers\Acheteur\PanierController;
use App\Http\Controllers\Acheteur\CommandeController;
use App\Http\Controllers\Acheteur\FavorisController;

Route::get('/dashboard', [AcheteurController::class, 'index'])->name('acheteur.dashboard');

// Panier
Route::get('/panier', [PanierController::class, 'index'])->name('acheteur.panier');
Route::post('/panier/ajouter', [PanierController::class, 'store']);
Route::delete('/panier/{id}', [PanierController::class, 'destroy']);

// Commandes
Route::get('/commandes', [CommandeController::class, 'index'])->name('acheteur.commandes');
Route::post('/commandes/create', [CommandeController::class, 'store']);

// Favoris
Route::get('/favoris', [FavorisController::class, 'index'])->name('acheteur.favoris');
Route::post('/favoris', [FavorisController::class, 'store']);
Route::delete('/favoris/{id}', [FavorisController::class, 'destroy']);

// Profil + Logout
Route::get('/profil', [AcheteurController::class, 'profil'])->name('acheteur.profil');
Route::post('/logout', [AcheteurController::class, 'logout'])->name('acheteur.logout');
