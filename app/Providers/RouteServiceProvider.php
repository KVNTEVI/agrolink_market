<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * L'espace de noms du contrôleur à appliquer aux routes.
     *
     * Dans les versions récentes de Laravel, ceci est souvent laissé vide.
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Définir les mappages de routes de votre application.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            // Appel des méthodes que vous avez définies
            $this->mapAdminRoutes();
            $this->mapProducteurRoutes();
            $this->mapAcheteurRoutes();

            // Routes API
            Route::middleware('api')
                ->prefix('api')
                // Assurez-vous que ce fichier existe !
                ->group(base_path('routes/api.php'));

            // Routes WEB (Routes avec état, CSRF, Session)
            Route::middleware('web')
                // Assurez-vous que ce fichier existe !
                ->group(base_path('routes/web.php'));
        });
    }

            protected function mapAdminRoutes()
            {
                Route::middleware(['web', 'auth', 'admin'])
                    ->prefix('admin')
                    ->name('admin.')
                    ->group(base_path('routes/admin.php'));
            }

            protected function mapProducteurRoutes()
            {
                Route::middleware(['web', 'auth', 'producteur'])
                    ->prefix('producteur')
                    ->name('producteur.')
                    ->group(base_path('routes/producteur.php'));
            }

            protected function mapAcheteurRoutes()
            {
                Route::middleware(['web', 'auth', 'acheteur'])
                    ->prefix('acheteur')
                    ->name('acheteur.')
                    ->group(base_path('routes/acheteur.php'));
            }


    /**
     * Configure le limiteur de taux pour les routes de l'application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}