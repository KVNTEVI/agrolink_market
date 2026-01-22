<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu de paiement #{{ $paiement->id_paiement }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 13px; margin: 0; padding: 0; }
        
        .header { 
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #198754;
            padding-bottom: 20px;
            width: 100%;
        }
        
        .logo-container {
            display: block;
            margin: 0 auto 10px auto;
            text-align: center;
        }

        .logo-img { 
            max-height: 70px; 
            width: auto; 
            display: inline-block; 
        }
        
        /* Section Infos : Vendeur à gauche, Acheteur à droite */
        .info-section { 
            width: 100%; 
            margin-bottom: 40px;
            clear: both;
        }
        
        .info-box-vendeur { 
            width: 48%; 
            float: left; /* Pousse vers la gauche */
            text-align: left;
        }
        
        .info-box-acheteur { 
            width: 48%; 
            float: right; /* Pousse vers la droite */
            text-align: right;
        }

        /* Nettoyage du float pour la suite du document */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #1a1d20; color: white; padding: 10px; text-align: left; text-transform: uppercase; font-size: 11px; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        
        .total-section { margin-top: 30px; text-align: right; }
        .badge-paye { color: #198754; border: 1px solid #198754; padding: 5px 12px; border-radius: 15px; font-weight: bold; text-transform: uppercase; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            @php
                $logoPath = public_path('images/logo.png');
            @endphp

            @if(file_exists($logoPath))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" class="logo-img">
            @else
                <div style="color: #198754; font-size: 24px; font-weight: bold;">AgroLink Market</div>
            @endif
        </div>
        <p style="margin: 0; color: #666; font-size: 14px;">
            Reçu de paiement électronique
        </p>
    </div>

    {{-- SECTION INFOS AVEC FLOAT ET CLEARFIX --}}
    <div class="info-section clearfix">
        <div class="info-box-vendeur">
            <strong style="color: #198754;">VENDEUR (PRODUCTEUR)</strong><br>
            <span style="font-size: 14px; font-weight: bold;">{{ $paiement->commande->producteur->nom }}</span><br>
            <span style="color: #666;">{{ $paiement->commande->producteur->email }}</span>
        </div>
        
        <div class="info-box-acheteur">
            <strong style="color: #198754;">ACHETEUR</strong><br>
            <span style="font-size: 14px; font-weight: bold;">{{ $paiement->commande->acheteur->nom }}</span><br>
            <span style="color: #666;">Date: {{ $paiement->created_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    <div style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
        <table style="margin: 0; border: none; width: 100%;">
            <tr>
                <td style="border: none; padding: 0;"><strong>Référence Commande :</strong> #{{ $paiement->commande->id_commande }}</td>
                <td style="border: none; padding: 0; text-align: right;">
                    <span class="badge-paye">PAYÉ VIA {{ strtoupper($paiement->mode) }}</span>
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th style="text-align: center;">Quantité</th>
                <th>Prix Unitaire</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paiement->commande->items as $item)
            <tr>
                <td style="font-weight: bold;">{{ $item->produit->nom }}</td>
                <td style="text-align: center;">{{ $item->quantite }} Kg</td>
                <td>{{ number_format($item->prix_final, 0, ',', ' ') }} FCFA</td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($item->quantite * $item->prix_final, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p style="margin: 0; color: #666;">Montant Total Réglé</p>
        <h2 style="color: #1a1d20; margin-top: 5px;">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</h2>
    </div>

    <div style="margin-top: 80px; text-align: center; color: #999; font-size: 10px; border-top: 2px solid #198754; padding-top: 10px;">
        Ce document est généré numériquement et sert de preuve d'achat officielle sur AgroLink Market.<br>
        Merci de soutenir l'agriculture locale.
    </div>
</body>
</html>