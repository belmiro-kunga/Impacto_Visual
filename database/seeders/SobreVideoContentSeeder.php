<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class SobreVideoContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dados do vu00eddeo da seu00e7u00e3o Sobre Nu00f3s
        $sobreVideoContent = [
            'key' => 'sobre-video',
            'section' => 'sobre',
            'label' => 'ID do Vu00eddeo do YouTube',
            'value' => 'IS1XHAJVURI',
            'type' => 'text',
            'order' => 2
        ];

        // Verifica se o conteu00fado ju00e1 existe
        $existingContent = Content::where('key', $sobreVideoContent['key'])->first();
        
        if ($existingContent) {
            // Atualiza o conteu00fado existente
            $existingContent->update([
                'section' => $sobreVideoContent['section'],
                'label' => $sobreVideoContent['label'],
                'value' => $existingContent->value, // Mantu00e9m o valor atual se ju00e1 existir
                'type' => $sobreVideoContent['type'],
                'order' => $sobreVideoContent['order']
            ]);
        } else {
            // Cria um novo conteu00fado
            Content::create($sobreVideoContent);
        }
        
        // Adiciona outros conteu00fados relacionados u00e0 seu00e7u00e3o Sobre Nu00f3s
        $outrosSobreContents = [
            [
                'key' => 'sobre-titulo',
                'section' => 'sobre',
                'label' => 'Tu00edtulo da Seu00e7u00e3o Sobre Nu00f3s',
                'value' => 'Conheu00e7a a Impacto Visual',
                'type' => 'text',
                'order' => 1
            ],
            [
                'key' => 'sobre-historia-titulo',
                'section' => 'sobre',
                'label' => 'Tu00edtulo da Histu00f3ria',
                'value' => 'Nossa Trajetu00f3ria de Sucesso',
                'type' => 'text',
                'order' => 3
            ],
            [
                'key' => 'sobre-historia-texto',
                'section' => 'sobre',
                'label' => 'Texto da Histu00f3ria',
                'value' => 'Fundada em 2018 por um grupo de profissionais visionu00e1rios e apaixonados pelo audiovisual, a Impacto Visual nasceu com uma missu00e3o clara: transformar ideias em histu00f3rias visuais memoru00e1veis. O que comeu00e7ou como um estu00fadio boutique rapidamente se expandiu para uma produtora completa, especializada em conteu00fado premium para marcas e empresas de todos os portes.\n\nNosso crescimento u00e9 resultado de uma filosofia centrada na excelu00eancia criativa e no compromisso com resultados mensuru00e1veis. Combinamos expertise tu00e9cnica com sensibilidade artu00edstica para desenvolver conteu00fados que nu00e3o apenas capturam a atenu00e7u00e3o, mas tambu00e9m geram engajamento genuu00edno e impulsionam o crescimento dos nossos clientes.\n\nHoje, somos reconhecidos no mercado pela nossa abordagem estratu00e9gica e pela capacidade de traduzir a essu00eancia de cada marca em narrativas audiovisuais autu00eanticas e impactantes.',
                'type' => 'textarea',
                'order' => 4
            ]
        ];
        
        foreach ($outrosSobreContents as $content) {
            // Verifica se o conteu00fado ju00e1 existe
            $existingContent = Content::where('key', $content['key'])->first();
            
            if ($existingContent) {
                // Atualiza o conteu00fado existente
                $existingContent->update([
                    'section' => $content['section'],
                    'label' => $content['label'],
                    'type' => $content['type'],
                    'order' => $content['order']
                ]);
            } else {
                // Cria um novo conteu00fado
                Content::create($content);
            }
        }
    }
}
