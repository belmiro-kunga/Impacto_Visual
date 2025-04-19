<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // Hero Section
            [
                'key' => 'hero-title',
                'section' => 'Hero',
                'label' => 'Título Principal',
                'value' => 'Transformamos ideias em vídeos incríveis para redes sociais e empresas',
                'type' => 'text',
                'order' => 1,
            ],
            [
                'key' => 'hero-subtitle',
                'section' => 'Hero',
                'label' => 'Subtítulo',
                'value' => 'Produção audiovisual com qualidade, estratégia e impacto visual',
                'type' => 'text',
                'order' => 2,
            ],
            [
                'key' => 'hero-button-text',
                'section' => 'Hero',
                'label' => 'Texto do Botão',
                'value' => 'Solicite um orçamento',
                'type' => 'text',
                'order' => 3,
            ],
            [
                'key' => 'hero-whatsapp-text',
                'section' => 'Hero',
                'label' => 'Texto do Botão WhatsApp',
                'value' => 'Fale no WhatsApp',
                'type' => 'text',
                'order' => 4,
            ],
            [
                'key' => 'hero-whatsapp-number',
                'section' => 'Hero',
                'label' => 'Número do WhatsApp',
                'value' => '5511999999999',
                'type' => 'text',
                'order' => 5,
            ],
            
            // Sobre Nós Section
            [
                'key' => 'sobre-titulo',
                'section' => 'Sobre',
                'label' => 'Título da Seção',
                'value' => 'Sobre a Impacto Visual',
                'type' => 'text',
                'order' => 1,
            ],
            [
                'key' => 'sobre-video',
                'section' => 'Sobre',
                'label' => 'ID do Vídeo YouTube',
                'value' => 'IS1XHAJVURI',
                'type' => 'text',
                'order' => 2,
            ],
            [
                'key' => 'sobre-historia-titulo',
                'section' => 'Sobre',
                'label' => 'Título História',
                'value' => 'Nossa História',
                'type' => 'text',
                'order' => 3,
            ],
            [
                'key' => 'sobre-historia-texto',
                'section' => 'Sobre',
                'label' => 'Texto História',
                'value' => 'A Impacto Visual nasceu em 2018, a partir da visão de profissionais apaixonados pela arte de contar histórias através de imagens. O que começou como um pequeno estúdio de produção audiovisual rapidamente evoluiu para uma empresa completa, especializada em vídeos para redes sociais e empresas.

Ao longo destes anos, construímos uma reputação sólida no mercado, baseada na excelência técnica e na capacidade de traduzir a identidade de cada cliente em conteúdo audiovisual impactante. Nossa equipe cresceu, mas mantivemos nossa essência: paixão pela criatividade e compromisso com resultados.',
                'type' => 'textarea',
                'order' => 4,
            ],
            
            // Contadores
            [
                'key' => 'contador-projetos',
                'section' => 'Contadores',
                'label' => 'Número de Projetos',
                'value' => '100',
                'type' => 'text',
                'order' => 1,
            ],
            [
                'key' => 'contador-clientes',
                'section' => 'Contadores',
                'label' => 'Número de Clientes',
                'value' => '50',
                'type' => 'text',
                'order' => 2,
            ],
            [
                'key' => 'contador-anos',
                'section' => 'Contadores',
                'label' => 'Número de Anos',
                'value' => '5',
                'type' => 'text',
                'order' => 3,
            ],
            
            // Contato Section
            [
                'key' => 'contato-titulo',
                'section' => 'Contato',
                'label' => 'Título da Seção',
                'value' => 'Entre em Contato',
                'type' => 'text',
                'order' => 1,
            ],
            [
                'key' => 'contato-email',
                'section' => 'Contato',
                'label' => 'Email de Contato',
                'value' => 'contato@impactovisual.com.br',
                'type' => 'text',
                'order' => 2,
            ],
            [
                'key' => 'contato-telefone',
                'section' => 'Contato',
                'label' => 'Telefone de Contato',
                'value' => '(11) 99999-9999',
                'type' => 'text',
                'order' => 3,
            ],
            
            // Footer
            [
                'key' => 'footer-copyright',
                'section' => 'Footer',
                'label' => 'Texto de Copyright',
                'value' => '© 2024 Impacto Visual. Todos os direitos reservados.',
                'type' => 'text',
                'order' => 1,
            ],
        ];

        foreach ($contents as $content) {
            Content::create($content);
        }
    }
} 