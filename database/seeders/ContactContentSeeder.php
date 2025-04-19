<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;
use Illuminate\Support\Facades\DB;

class ContactContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dados de contato a serem criados ou atualizados
        $contactContents = [
            [
                'key' => 'contato-email',
                'section' => 'contato',
                'label' => 'Email de Contato',
                'value' => 'contato@impactovisual.com.br',
                'type' => 'text',
                'order' => 1
            ],
            [
                'key' => 'contato-telefone',
                'section' => 'contato',
                'label' => 'Telefone de Contato',
                'value' => '(11) 99999-9999',
                'type' => 'text',
                'order' => 2
            ],
            [
                'key' => 'contato-titulo',
                'section' => 'contato',
                'label' => 'Título da Seção de Contato',
                'value' => 'Entre em Contato',
                'type' => 'text',
                'order' => 0
            ]
        ];

        foreach ($contactContents as $content) {
            // Verifica se o conteúdo já existe
            $existingContent = Content::where('key', $content['key'])->first();
            
            if ($existingContent) {
                // Atualiza o conteúdo existente
                $existingContent->update([
                    'section' => $content['section'],
                    'label' => $content['label'],
                    'value' => $content['value'],
                    'type' => $content['type'],
                    'order' => $content['order']
                ]);
            } else {
                // Cria um novo conteúdo
                Content::create($content);
            }
        }
    }
}
