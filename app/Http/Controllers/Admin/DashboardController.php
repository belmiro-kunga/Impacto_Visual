<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Content;

class DashboardController extends Controller
{
    /**
     * Exibe o painel de controle administrativo
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Contagens de dados reais do sistema
        $totalServices = Service::count();
        $activeServices = Service::where('active', true)->count();
        $highlightedServices = Service::where('is_highlighted', true)->count();
        
        $totalPortfolios = Portfolio::count();
        $activePortfolios = Portfolio::where('active', true)->count();
        
        $totalContents = Content::count();
        
        // Dados para gráficos
        $servicesBySection = [
            'ativos' => $activeServices,
            'inativos' => $totalServices - $activeServices,
            'destacados' => $highlightedServices
        ];
        
        // Conteúdos por seção
        $contentsBySections = Content::select('section', \DB::raw('count(*) as total'))
            ->groupBy('section')
            ->get()
            ->pluck('total', 'section')
            ->toArray();
        
        return view('admin.dashboard', [
            'totalServices' => $totalServices,
            'activeServices' => $activeServices,
            'totalPortfolios' => $totalPortfolios,
            'activePortfolios' => $activePortfolios,
            'totalContents' => $totalContents,
            'servicesBySection' => $servicesBySection,
            'contentsBySections' => $contentsBySections
        ]);
    }
}
