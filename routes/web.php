<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Models\Service;
use App\Models\Content;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Redirect;

// Rota principal para a página inicial
Route::get('/', function () {
    $services = Service::where('active', true)->orderBy('order')->get();
    $portfolios = App\Models\Portfolio::where('active', true)->orderBy('order')->get();
    $testimonials = App\Models\Testimonial::where('active', true)->orderBy('order')->get();
    $clients = App\Models\Client::where('active', true)->orderBy('order')->get();
    $contents = Content::all()->keyBy('key');
    $settings = App\Models\Setting::getAllSettings();
    return view('welcome', compact('services', 'portfolios', 'testimonials', 'clients', 'contents', 'settings'));
});

// Rota para processamento do formulário de contato
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'sendMessage'])->name('contact.send');

// Fallback login route that redirects to admin login
Route::get('/login', function () {
    return Redirect::route('admin.login');
})->name('login');

// Rotas do painel administrativo
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    
    // Rotas protegidas
    Route::middleware('auth:admin')->group(function () {
        Route::get('/', function() {
            return redirect()->route('admin.content.sections');
        })->name('dashboard');
        
        // Adicionar rota explícita para o dashboard
        Route::get('/dashboard', function() {
            return redirect()->route('admin.content.sections');
        });
        
        // Gerenciamento de Serviços
        Route::get('/services', [App\Http\Controllers\Admin\ContentController::class, 'services'])->name('services');
        Route::get('/services/create', [App\Http\Controllers\Admin\ContentController::class, 'createService'])->name('services.create');
        Route::post('/services', [App\Http\Controllers\Admin\ContentController::class, 'storeService'])->name('services.store');
        Route::get('/services/{service}/edit', [App\Http\Controllers\Admin\ContentController::class, 'editService'])->name('services.edit');
        Route::put('/services/{service}', [App\Http\Controllers\Admin\ContentController::class, 'updateService'])->name('services.update');
        Route::delete('/services/{service}', [App\Http\Controllers\Admin\ContentController::class, 'destroyService'])->name('services.destroy');
        
        // Gerenciamento de Conteúdo Editável
        Route::get('/content', [App\Http\Controllers\Admin\ContentController::class, 'contentSections'])->name('content.sections');
        Route::get('/content/sections/{section}', [App\Http\Controllers\Admin\ContentController::class, 'editSection'])->name('content.sections.edit');
        Route::put('/content/sections/{section}', [App\Http\Controllers\Admin\ContentController::class, 'updateSection'])->name('content.sections.update');
        
        Route::get('/content/create', [App\Http\Controllers\Admin\ContentController::class, 'createContent'])->name('content.create');
        Route::post('/content', [App\Http\Controllers\Admin\ContentController::class, 'storeContent'])->name('content.store');
        Route::get('/content/{content}/edit', [App\Http\Controllers\Admin\ContentController::class, 'editContent'])->name('content.edit');
        Route::put('/content/{content}', [App\Http\Controllers\Admin\ContentController::class, 'updateContent'])->name('content.update');
        Route::delete('/content/{content}', [App\Http\Controllers\Admin\ContentController::class, 'destroyContent'])->name('content.destroy');
        
        // Gerenciamento de Portfólio
        Route::get('/portfolio', [App\Http\Controllers\Admin\PortfolioController::class, 'index'])->name('portfolio.index');
        Route::get('/portfolio/create', [App\Http\Controllers\Admin\PortfolioController::class, 'create'])->name('portfolio.create');
        Route::post('/portfolio', [App\Http\Controllers\Admin\PortfolioController::class, 'store'])->name('portfolio.store');
        Route::get('/portfolio/{portfolio}/edit', [App\Http\Controllers\Admin\PortfolioController::class, 'edit'])->name('portfolio.edit');
        Route::put('/portfolio/{portfolio}', [App\Http\Controllers\Admin\PortfolioController::class, 'update'])->name('portfolio.update');
        Route::delete('/portfolio/{portfolio}', [App\Http\Controllers\Admin\PortfolioController::class, 'destroy'])->name('portfolio.destroy');
        
        // Gerenciamento de Configurações do Site
        Route::get('/settings/{group?}', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings/{group}', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
        
        // Gerenciamento de Seções do Site
        Route::get('/sections/{section?}', [App\Http\Controllers\Admin\PageSectionController::class, 'edit'])->name('sections.edit');
        Route::post('/sections/{section}', [App\Http\Controllers\Admin\PageSectionController::class, 'update'])->name('sections.update');
        Route::delete('/sections/content/{id}', [App\Http\Controllers\Admin\PageSectionController::class, 'destroyContent'])->name('sections.content.destroy');
        
        // Gerenciamento de Campos Duplicados
        Route::get('/duplicate-fields', [App\Http\Controllers\Admin\DuplicateFieldsController::class, 'index'])->name('duplicate-fields.index');
        Route::get('/duplicate-fields/scan', [App\Http\Controllers\Admin\DuplicateFieldsController::class, 'scan'])->name('duplicate-fields.scan');
        Route::post('/duplicate-fields/fix', [App\Http\Controllers\Admin\DuplicateFieldsController::class, 'fix'])->name('duplicate-fields.fix');
        Route::post('/duplicate-fields/remove', [App\Http\Controllers\Admin\DuplicateFieldsController::class, 'remove'])->name('duplicate-fields.remove');
        Route::get('/duplicate-fields/remove-all', [App\Http\Controllers\Admin\DuplicateFieldsController::class, 'removeAll'])->name('duplicate-fields.remove-all');
        
        Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class);
        Route::resource('clients', App\Http\Controllers\Admin\ClientController::class);

        // Gerenciamento de Usuários
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        Route::post('/testimonials/{testimonial}/toggle-status', [App\Http\Controllers\Admin\TestimonialController::class, 'toggleStatus'])
            ->name('admin.testimonials.toggle-status');
    });
});
