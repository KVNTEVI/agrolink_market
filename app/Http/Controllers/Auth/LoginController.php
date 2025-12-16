<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * IMPORTANT : Nous définissons la méthode redirectTo() ci-dessous 
     * pour gérer la logique conditionnelle par rôle.
     * La propriété $redirectTo par défaut est commentée.
     *
     * @var string
     */
    // protected $redirectTo = '/home'; // <-- Commenté ou supprimé

    /**
     * Redirige l'utilisateur vers son tableau de bord spécifique après la connexion.
     *
     * @return string
     */
    protected function redirectTo()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        if ($user->role_id == 1) {
            // Rôle Administrateur
            return '/admin/dashboard';
        } elseif ($user->role_id == 3) {
            // Rôle Producteur
            return '/producteur/dashboard';
        } elseif ($user->role_id == 2) {
            // Rôle Acheteur
            return '/acheteur/dashboard';
        }

        // Si role_id n'est pas trouvé (ce qui ne devrait pas arriver avec les middlewares), 
        // ou pour une erreur inattendue, on redirige vers l'accueil.
        return '/home'; 
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}