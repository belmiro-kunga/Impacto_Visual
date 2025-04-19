<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'Redes Sociais',
                'description' => 'Produção de vídeos otimizados para Instagram, Reels e TikTok que geram engajamento e aumentam sua presença digital.',
                'icon' => 'bi-instagram',
                'is_highlighted' => false,
                'order' => 1,
                'active' => true,
            ],
            [
                'title' => 'YouTube',
                'description' => 'Criação de conteúdo para YouTube incluindo vlogs, entrevistas, tutoriais e séries especiais adaptados ao seu canal.',
                'icon' => 'bi-youtube',
                'is_highlighted' => false,
                'order' => 2,
                'active' => true,
            ],
            [
                'title' => 'Vídeos Corporativos',
                'description' => 'Vídeos institucionais e corporativos que transmitem a identidade da sua empresa com profissionalismo e qualidade.',
                'icon' => 'bi-building',
                'is_highlighted' => false,
                'order' => 3,
                'active' => true,
            ],
            [
                'title' => 'Edição Profissional',
                'description' => 'Serviços avançados de edição e pós-produção com efeitos visuais, animações, correção de cor e finalização.',
                'icon' => 'bi-film',
                'is_highlighted' => false,
                'order' => 4,
                'active' => true,
            ],
            [
                'title' => 'Eventos e Publicidade',
                'description' => 'Cobertura audiovisual completa de eventos e produção de vídeos publicitários que destacam seu produto ou serviço.',
                'icon' => 'bi-camera-reels',
                'is_highlighted' => false,
                'order' => 5,
                'active' => true,
            ],
            [
                'title' => 'Fotografia para Eventos',
                'description' => 'Cobertura fotográfica profissional para festas, casamentos, formaturas e eventos corporativos com edição de alta qualidade.',
                'icon' => 'bi-camera',
                'is_highlighted' => false,
                'order' => 6,
                'active' => true,
            ],
            [
                'title' => 'Criação de Websites',
                'description' => 'Desenvolvimento de sites modernos, responsivos e otimizados para SEO, desde landing pages até e-commerces completos.',
                'icon' => 'bi-globe',
                'is_highlighted' => false,
                'order' => 7,
                'active' => true,
            ],
            [
                'title' => 'Design Gráfico',
                'description' => 'Criação de identidades visuais, logotipos, materiais impressos, banners e peças gráficas para redes sociais com design moderno e impactante.',
                'icon' => 'bi-palette',
                'is_highlighted' => false,
                'order' => 8,
                'active' => true,
            ],
            [
                'title' => 'Pacotes Personalizados',
                'description' => 'Soluções sob medida para suas necessidades específicas. Combinamos nossos serviços para criar o pacote ideal para você.',
                'icon' => 'bi-stars',
                'is_highlighted' => true,
                'order' => 9,
                'active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
} 