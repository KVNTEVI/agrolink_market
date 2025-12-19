<footer class="bg-success bg-opacity-10 text-light pt-5 mt-5">
    <div class="container">
        <div class="row gy-4">

            <!-- LOGO + DESCRIPTION -->
            <div class="col-md-4">
                <h5 class="fw-bold text-success">
                <i class="bi bi-leaf-fill fs-4 me-2"></i>
                    AgroLink Market
                </h5>
                <p class="small text-muted">
                    La plateforme qui connecte producteurs et acheteurs
                    de produits agricoles locaux de qualité.
                </p>

                <!-- Réseaux sociaux -->
                <div class="mt-3">
                    <a href="#" class="text-light me-3">
                        <i class="bi bi-facebook text-success"></i>
                    </a>
                    <a href="#" class="text-light me-3">
                        <i class="bi bi-whatsapp text-success"></i>
                    </a>
                    <a href="#" class="text-light">
                        <i class="bi bi-linkedin text-success"></i>
                    </a>
                </div>
            </div>

            <!-- LIENS RAPIDES -->
            <div class="col-md-2">
                <h6 class="text-body fw-bold">Navigation</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-muted text-decoration-none footer-link">Accueil</a></li>
                    <li><a href="#" class="text-muted text-decoration-none footer-link">À propos</a></li>
                    <li><a href="{{ route('boutique.index') }}" class="text-muted text-decoration-none footer-link">Boutique</a></li>
                    <li><a href="{{ route('magazin.index') }}" class="text-muted text-decoration-none footer-link">Magazin</a></li>
                    <li><a href="#" class="text-muted text-decoration-none footer-link">Contact</a></li>
                </ul>
            </div>

            <!-- SERVICES -->
            <div class="col-md-3">
                <h6 class="text-body fw-bold">Services</h6>
                <ul class="list-unstyled text-muted">
                    <li>Vente de produits agricoles</li>
                    <li>Négociation des prix</li>
                    <li>Paiement sécurisé</li>
                    <li>Livraison locale</li>
                </ul>
            </div>

            <!-- CONTACT -->
            <div class="col-md-3">
                <h6 class="text-body fw-bold">Contact</h6>
                <ul class="list-unstyled text-muted">
                    <li><i class="bi bi-envelope text-success me-2"></i> kvntevi@gmail.com</li>
                    <li><i class="bi bi-telephone text-success me-2"></i> +228 97 90 98 02</li>
                    <li><i class="bi bi-geo-alt text-success me-2"></i> Lomé, Togo</li>
                </ul>
            </div>

        </div>

        <!-- COPYRIGHT -->
        <div class="text-center border-top border-secondary mt-4 pt-3 pb-3 small text-muted">
            © {{ date('Y') }} AgroLink Market — Tous droits réservés
        </div>
    </div>
</footer>
