<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class ApplySettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Limpar o cache de configurações para garantir que as alterações serão aplicadas
        Cache::forget('all_settings');
        
        // Obtem todas as configurações do site
        $settings = Setting::getAllSettings();
        
        // Compartilha as configurações com todas as views
        View::share('settings', $settings);
        
        // Configura o título do site
        if (isset($settings['site_name'])) {
            config(['app.name' => $settings['site_name']]);
        }
        
        // Configura o e-mail para o formulário de contato
        if (isset($settings['contact_email'])) {
            config(['mail.from.address' => $settings['contact_email']]);
        }
        
        if (isset($settings['site_name'])) {
            config(['mail.from.name' => $settings['site_name']]);
        }
        
        return $next($request);
    }
}
