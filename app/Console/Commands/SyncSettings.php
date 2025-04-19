<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

class SyncSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza as configurações do site';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sincronizando configurações do site...');
        
        // Verificar se a tabela existe
        if (!Schema::hasTable('settings')) {
            $this->error('A tabela settings não existe. Execute as migrações primeiro.');
            return 1;
        }
        
        // Limpar o cache de configurações
        Cache::forget('all_settings');
        
        // Definir configurações padrão
        $defaultSettings = [
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
                'value' => 'Produção de Vídeos',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Descrição do Site',
                'order' => 2,
            ],
            [
                'key' => 'logo',
                'value' => '',
                'group' => 'general',
                'type' => 'file',
                'label' => 'Logo',
                'order' => 3,
            ],
            [
                'key' => 'favicon',
                'value' => '',
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
                'value' => '#',
                'group' => 'social',
                'type' => 'url',
                'label' => 'URL do Facebook',
                'order' => 1,
            ],
            [
                'key' => 'instagram_url',
                'value' => '#',
                'group' => 'social',
                'type' => 'url',
                'label' => 'URL do Instagram',
                'order' => 2,
            ],
            [
                'key' => 'youtube_url',
                'value' => '#',
                'group' => 'social',
                'type' => 'url',
                'label' => 'URL do YouTube',
                'order' => 3,
            ],
            [
                'key' => 'tiktok_url',
                'value' => '#',
                'group' => 'social',
                'type' => 'url',
                'label' => 'URL do TikTok',
                'order' => 4,
            ],
        ];
        
        $count = 0;
        
        // Inserir ou atualizar cada configuração
        foreach ($defaultSettings as $setting) {
            $exists = Setting::where('key', $setting['key'])->first();
            
            if (!$exists) {
                Setting::create($setting);
                $this->line("Criada configuração: {$setting['key']}");
                $count++;
            }
        }
        
        $this->info("Sincronização concluída! {$count} novas configurações adicionadas.");
        
        return 0;
    }
} 