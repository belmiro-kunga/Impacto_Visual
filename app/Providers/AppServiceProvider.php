<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Substituir o BladeHeroiconsServiceProvider
        $this->app->singleton('heroicon', function () {
            return new class {
                public function __call($method, $args)
                {
                    return '';
                }
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Adicionar uma diretiva para substituir o x-heroicon
        if (class_exists('\Illuminate\Support\Facades\Blade')) {
            \Illuminate\Support\Facades\Blade::directive('heroicon', function ($expression) {
                return "<?php echo ''; ?>";
            });
            
            // Registrar um componente com nome de string em vez de closure direta
            if (method_exists('\Illuminate\Support\Facades\Blade', 'component')) {
                \Illuminate\Support\Facades\Blade::component('heroicon-outline', 'DummyHeroiconOutline');
                \Illuminate\Support\Facades\Blade::component('heroicon-solid', 'DummyHeroiconSolid');
            }
        }
    }
}
