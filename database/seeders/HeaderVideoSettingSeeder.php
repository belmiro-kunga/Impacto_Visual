<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class HeaderVideoSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Configurau00e7u00e3o do vu00eddeo do header
        $headerVideoSetting = [
            'key' => 'header_video',
            'label' => 'Vu00eddeo do Header',
            'value' => 'videos/Coca-Col.mp4',
            'group' => 'general',
            'type' => 'file',
            'order' => 10
        ];

        // Verifica se a configurau00e7u00e3o ju00e1 existe
        $existingSetting = Setting::where('key', $headerVideoSetting['key'])->first();
        
        if ($existingSetting) {
            // Atualiza a configurau00e7u00e3o existente
            $existingSetting->update([
                'label' => $headerVideoSetting['label'],
                'group' => $headerVideoSetting['group'],
                'type' => $headerVideoSetting['type'],
                'order' => $headerVideoSetting['order']
            ]);
        } else {
            // Cria uma nova configurau00e7u00e3o
            Setting::create($headerVideoSetting);
        }
    }
}
