<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageContact;

/**
 * Ce contrôleur gère le formulaire de contact public.
 * Il permet à n'importe quel visiteur (connecté ou non) d'envoyer 
 * un message à l'administration du site.
 */
class ContactController extends Controller
{
    /**
     * Affiche la page contenant le formulaire de contact.
     * * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retourne simplement la vue située dans resources/views/contact/index.blade.php
        return view('contact.index');
    }

    /**
     * Traite les données soumises par le formulaire de contact.
     * * @param  \Illuminate\Http\Request  $request  Contient les données saisies par l'utilisateur
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        // On s'assure que les champs obligatoires sont remplis et valides.
        // Si la validation échoue, Laravel redirige automatiquement vers le formulaire avec les erreurs.
        $request->validate([
            'nom'     => 'required|string|max:255', // Le nom est obligatoire
            'email'   => 'required|email',          // Doit être un format email valide
            'message' => 'required|min:5'           // Minimum 5 caractères pour éviter les messages vides
        ]);

        // 2. Enregistrement dans la base de données
        // La méthode create() utilise le "Mass Assignment" via la propriété $fillable du modèle MessageContact.
        // On enregistre : le nom, l'email et le contenu du message.
        MessageContact::create($request->all());

        // 3. Retour à l'utilisateur
        // Redirige vers la page précédente (le formulaire) avec un message flash de succès.
        return back()->with('success', 'Message envoyé avec succès. Nous vous répondrons dès que possible.');
    }
}