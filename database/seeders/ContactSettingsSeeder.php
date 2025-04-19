<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class ContactSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Configurações de contato a serem criadas ou atualizadas
        $contactSettings = [
            [
                'key' => 'contact_email',
                'label' => 'Email de Contato',
                'value' => 'contato@impactovisual.com.br',
                'group' => 'contact',
                'type' => 'text',
                'order' => 1
            ],
            [
                'key' => 'contact_phone',
                'label' => 'Telefone de Contato',
                'value' => '(11) 99999-9999',
                'group' => 'contact',
                'type' => 'text',
                'order' => 2
            ],
            [
                'key' => 'contact_address',
                'label' => 'Endereço',
                'value' => 'São Paulo, SP',
                'group' => 'contact',
                'type' => 'textarea',
                'order' => 3
            ],
            [
                'key' => 'contact_hours',
                'label' => 'Horário de Atendimento',
                'value' => 'Segunda a Sexta: 9h às 18h',
                'group' => 'contact',
                'type' => 'text',
                'order' => 4
            ],
            [
                'key' => 'whatsapp_number',
                'label' => 'Número do WhatsApp (apenas números)',
                'value' => '5511999999999',
                'group' => 'contact',
                'type' => 'text',
                'order' => 5
            ]
        ];

        foreach ($contactSettings as $setting) {
            // Verifica se a configuração já existe
            $existingSetting = Setting::where('key', $setting['key'])->first();
            
            if ($existingSetting) {
                // Atualiza a configuração existente
                $existingSetting->update([
                    'label' => $setting['label'],
                    'group' => $setting['group'],
                    'type' => $setting['type'],
                    'order' => $setting['order']
                ]);
            } else {
                // Cria uma nova configuração
                Setting::create($setting);
            }
        }
    }
}
