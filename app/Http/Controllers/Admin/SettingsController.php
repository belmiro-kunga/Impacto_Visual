<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /**
     * Exibe a página de configurações por grupo
     */
    public function index($group = 'general')
    {
        $settings = Setting::getSettingsForGroup($group);
        $groups = ['general' => 'Geral', 'contact' => 'Contato', 'social' => 'Redes Sociais', 'mail' => 'Configurações de E-mail'];
        
        return view('admin.settings.index', compact('settings', 'groups', 'group'));
    }

    /**
     * Atualiza as configurações do grupo selecionado
     */
    public function update(Request $request, $group)
    {
        $settings = Setting::where('group', $group)->get();
        
        foreach ($settings as $setting) {
            $value = $request->input('settings.' . $setting->key);
            
            // Upload de arquivos
            if ($setting->type == 'file' && $request->hasFile('settings.' . $setting->key)) {
                $file = $request->file('settings.' . $setting->key);
                $filename = $setting->key . '.' . $file->getClientOriginalExtension();
                
                // Diretório de uploads
                $directory = public_path('uploads/settings');
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }
                
                // Deletar arquivo antigo se existir
                if ($setting->value && File::exists(public_path($setting->value))) {
                    File::delete(public_path($setting->value));
                }
                
                $file->move($directory, $filename);
                $value = 'uploads/settings/' . $filename;
            }
            
            // Não atualiza campo de senha se vier vazio
            if ($setting->type == 'password' && empty($value)) {
                continue;
            }
            
            // Atualiza o valor da configuração
            if ($value !== null) {
                $setting->value = $value;
                $setting->save();
            }
        }
        
        // Limpar o cache para que as alterações sejam refletidas imediatamente
        Cache::forget('all_settings');
        
        // Definir flag indicando que as configurações foram atualizadas recentemente
        Cache::put('settings_updated', true, 300); // 5 minutos
        
        // Se for configuração de email, atualiza as variáveis de ambiente
        if ($group == 'mail') {
            $this->updateMailConfig();
        }
        
        return redirect()->route('admin.settings.index', $group)
            ->with('success', 'Configurações atualizadas com sucesso!');
    }
    
    /**
     * Atualiza as configurações de email no .env
     */
    private function updateMailConfig()
    {
        $mailSettings = Setting::where('group', 'mail')->get();
        
        // Mapeamento de chaves de configuração para variáveis .env
        $envMap = [
            'mail_mailer' => 'MAIL_MAILER',
            'mail_host' => 'MAIL_HOST',
            'mail_port' => 'MAIL_PORT',
            'mail_username' => 'MAIL_USERNAME',
            'mail_password' => 'MAIL_PASSWORD',
            'mail_encryption' => 'MAIL_ENCRYPTION',
            'mail_from_address' => 'MAIL_FROM_ADDRESS',
            'mail_from_name' => 'MAIL_FROM_NAME',
        ];
        
        foreach ($mailSettings as $setting) {
            if (isset($envMap[$setting->key]) && !empty($setting->value)) {
                $this->setEnvironmentVariable($envMap[$setting->key], $setting->value);
            }
        }
        
        // Limpa o cache de configuração
        Artisan::call('config:clear');
    }
    
    /**
     * Atualiza uma variável no arquivo .env
     */
    private function setEnvironmentVariable($key, $value)
    {
        $path = app()->environmentFilePath();
        
        if (File::exists($path)) {
            $content = File::get($path);
            
            // Se o valor contém espaços, colocamos entre aspas
            if (strpos($value, ' ') !== false) {
                $value = '"' . $value . '"';
            }
            
            // Verifica se a variável já existe
            if (strpos($content, "{$key}=") !== false) {
                // Substitui a variável existente
                $content = preg_replace("/{$key}=(.*)/", "{$key}={$value}", $content);
            } else {
                // Adiciona nova variável
                $content .= "\n{$key}={$value}";
            }
            
            File::put($path, $content);
        }
    }
}
