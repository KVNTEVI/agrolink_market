<?php

namespace App\Http\Controllers\Acheteur;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 
use App\Notifications\CommandePayeeNotification;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

class PaiementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'acheteur']);
    }

    public function index()
    {
        $query = Paiement::whereHas('commande', function ($q) {
            $q->where('acheteur_id', Auth::id());
        });

        $totalDepense = $query->sum('montant');

        $paiements = $query->with('commande')
            ->latest()
            ->paginate(10);

        return view('acheteur.paiement.index', compact('paiements', 'totalDepense'));
    }

    public function show($commandeId)
    {
        $commande = Commande::where('id_commande', $commandeId)
            ->where('acheteur_id', Auth::id())
            ->firstOrFail();

        return view('acheteur.paiement.show', compact('commande'));
    }

    public function payer($commandeId)
    {
        $commande = Commande::where('id_commande', $commandeId)
            ->where('acheteur_id', Auth::id())
            ->with('items.produit') // On charge les produits liés
            ->firstOrFail();

        if ($commande->statut === 'payée') {
            return redirect()->route('acheteur.commandes.index')
                ->with('warning', 'Cette commande a déjà été réglée.');
        }

        $montantFinal = $commande->montant_total;

        // --- CALCULS DU BUSINESS MODEL (5%) ---
        $tauxCommission = 0.05;
        $commission = $montantFinal * $tauxCommission;
        $netProducteur = $montantFinal - $commission;

        // --- DEBUT TRANSACTION ---
        try {
            DB::transaction(function () use ($commande, $montantFinal, $commission, $netProducteur) {
                // 1. Création du paiement
                Paiement::create([
                    'commande_id' => $commande->id_commande,
                    'montant'     => $montantFinal,
                    'mode'        => request('mode', 'Mobile Money'),
                    'statut'      => 'payée'
                ]);

                // 2. DIMINUTION AUTOMATIQUE DU STOCK
                foreach ($commande->items as $item) {
                    $produit = $item->produit;
                    if ($produit) {
                        // On vérifie si le stock est suffisant avant de déduire
                        if ($produit->stock < $item->quantite) {
                            throw new \Exception("Stock insuffisant pour le produit : " . $produit->nom);
                        }
                        $produit->decrement('stock', $item->quantite);
                    }
                }

                // 3. Mise à jour du statut de la commande ET des montants de commission
                $commande->update([
                    'statut' => 'payée',
                    'commission_montant' => $commission,
                    'montant_net_producteur' => $netProducteur
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->route('acheteur.commandes.index')
                ->with('error', "Échec du paiement : " . $e->getMessage());
        }
        // --- FIN TRANSACTION ---

        // 4. Notifications (après le succès de la transaction)
        $producteur = Utilisateur::find($commande->producteur_id);
        $admins = Utilisateur::where('role_id', 1)->get(); 

        try {
            if($producteur) {
                $producteur->notify(new CommandePayeeNotification($commande));
            }
            foreach($admins as $admin) {
                $admin->notify(new CommandePayeeNotification($commande));
            }
        } catch (\Exception $e) {
            Log::error("Erreur notification paiement : " . $e->getMessage());
        }

        return redirect()
            ->route('acheteur.commandes.index')
            ->with('success', "Le paiement de " . number_format($montantFinal, 0, ',', ' ') . " FCFA a été validé. (Commission de " . number_format($commission, 0, ',', ' ') . " FCFA prélevée)");
    }

    public function genererRecu($id)
    {
        $paiement = Paiement::with(['commande.acheteur', 'commande.producteur', 'commande.items.produit'])
            ->whereHas('commande', function ($q) {
                $q->where('acheteur_id', Auth::id());
            })
            ->findOrFail($id);

        $pdf = Pdf::loadView('acheteur.paiement.recu_pdf', compact('paiement'));

        return $pdf->download('Recu_AgroLink_#' . $paiement->commande->id_commande . '.pdf');
    }
}