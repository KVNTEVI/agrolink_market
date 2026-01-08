<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageContact;
use App\Models\Utilisateur; 
use App\Notifications\NewContactMessage;


class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        // 1. Validation
        $validated = $request->validate([
            'nom'     => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|min:5'
        ]);

        // 2. Enregistrement du message
        $contact = MessageContact::create($validated);

        // 3. Récupérer l'administrateur
        // On cherche dans votre modèle Utilisateur celui qui a le role_id = 1
        $admin = Utilisateur::where('role_id', 1)->first();

        // 4. Envoyer la notification
        if ($admin) {
            $admin->notify(new NewContactMessage($contact));
        }

        return back()->with('success', 'Message envoyé avec succès. Nous vous répondrons dès que possible.');
    }
}