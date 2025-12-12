<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

// Contrôleur pour la section d'administration (accès réservé aux Admins)
class AdminController extends Controller
{
    // Affiche le tableau de bord principal de l'administration.
    public function dashboard()
    {
        // Retourne la vue Blade : resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }
}