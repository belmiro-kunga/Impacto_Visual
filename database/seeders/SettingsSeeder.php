<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Configurações Gerais
            [
                'key' => 'site_name',
                'value' => 'Impacto Visual',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Nome do Site',
                'order' => 1,
            ],
            [
                'key' => 'site_description',
                'value' => 'Produção de Vídeos para Redes Sociais e Empresas',
                'group' => 'general',
                'type' => 'textarea',
                'label' => 'Descrição do Site',
                'order' => 2,
            ],
            [
                'key' => 'logo',
                'value' => null,
                'group' => 'general',
                'type' => 'file',
                'label' => 'Logotipo',
                'order' => 3,
            ],
            [
                'key' => 'favicon',
                'value' => null,
                'group' => 'general',
                'type' => 'file',
                'label' => 'Favicon',
                'order' => 4,
            ],
            
            // Configurações de Contato
            [
                'key' => 'contact_email',
                'value' => 'contato@impactovisual.com.br',
                'group' => 'contact',
                'type' => 'email',
                'label' => 'E-mail de Contato',
                'order' => 1,
            ],
            [
                'key' => 'contact_phone',
                'value' => '(11) 99999-9999',
                'group' => 'contact',
                'type' => 'text',
                'label' => 'Telefone de Contato',
                'order' => 2,
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '5511999999999',
                'group' => 'contact',
                'type' => 'text',
                'label' => 'Número do WhatsApp',
                'order' => 3,
            ],
            
            // Redes Sociais
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/',
                'group' => 'social',
                'type' => 'url',
                'label' => 'URL do Facebook',
                'order' => 1,
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/',
                'group' => 'social',
                'type' => 'url',
                'label' => 'URL do Instagram',
                'order' => 2,
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://youtube.com/',
                'group' => 'social',
                'type' => 'url',
                'label' => 'URL do YouTube',
                'order' => 3,
            ],
            [
                'key' => 'tiktok_url',
                'value' => 'https://tiktok.com/',
                'group' => 'social',
                'type' => 'url',
                'label' => 'URL do TikTok',
                'order' => 4,
            ],
            
            // Configurações SMTP
            [
                'key' => 'mail_mailer',
                'value' => 'smtp',
                'group' => 'mail',
                'type' => 'select',
                'label' => 'Driver de E-mail',
                'options' => json_encode(['smtp' => 'SMTP', 'sendmail' => 'Sendmail', 'mailgun' => 'Mailgun']),
                'order' => 1,
            ],
            [
                'key' => 'mail_host',
                'value' => 'smtp.mailtrap.io',
                'group' => 'mail',
                'type' => 'text',
                'label' => 'Servidor SMTP',
                'order' => 2,
            ],
            [
                'key' => 'mail_port',
                'value' => '2525',
                'group' => 'mail',
                'type' => 'number',
                'label' => 'Porta SMTP',
                'order' => 3,
            ],
            [
                'key' => 'mail_username',
                'value' => null,
                'group' => 'mail',
                'type' => 'text',
                'label' => 'Usuário SMTP',
                'order' => 4,
            ],
            [
                'key' => 'mail_password',
                'value' => null,
                'group' => 'mail',
                'type' => 'password',
                'label' => 'Senha SMTP',
                'order' => 5,
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'group' => 'mail',
                'type' => 'select',
                'label' => 'Criptografia SMTP',
                'options' => json_encode(['tls' => 'TLS', 'ssl' => 'SSL', 'null' => 'Nenhuma']),
                'order' => 6,
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'contato@impactovisual.com.br',
                'group' => 'mail',
                'type' => 'email',
                'label' => 'E-mail de Origem',
                'order' => 7,
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'Impacto Visual',
                'group' => 'mail',
                'type' => 'text',
                'label' => 'Nome de Origem',
                'order' => 8,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
