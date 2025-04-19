<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'options',
        'order'
    ];

    /**
     * Get all settings as key-value pairs
     *
     * @return array
     */
    public static function getAllSettings()
    {
        // Se estiver em modo de debug ou se as configurações foram atualizadas recentemente, não use o cache
        if (config('app.debug') || Cache::get('settings_updated')) {
            $settings = self::pluck('value', 'key')->toArray();
            
            // Armazenar as configurações no cache por 5 minutos após uma atualização
            if (Cache::get('settings_updated')) {
                Cache::forget('settings_updated');
                Cache::put('all_settings', $settings, 300); // 5 minutos
            }
            
            return $settings;
        }
        
        return Cache::remember('all_settings', 3600, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get a specific setting by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getSetting($key, $default = null)
    {
        return Cache::remember('setting_' . $key, 60 * 24, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Update a setting value
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function updateSetting($key, $value)
    {
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            $updated = $setting->update(['value' => $value]);
            
            if ($updated) {
                Cache::forget('setting_' . $key);
                Cache::forget('all_settings');
            }
            
            return $updated;
        }
        
        return false;
    }

    /**
     * Get settings grouped by category
     *
     * @return array
     */
    public static function getSettingsByGroup()
    {
        return self::orderBy('group')
            ->orderBy('order')
            ->get()
            ->groupBy('group')
            ->toArray();
    }

    /**
     * Get settings for a specific group
     *
     * @param string $group
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSettingsForGroup($group)
    {
        return self::where('group', $group)
            ->orderBy('order')
            ->get();
    }

    /**
     * Get settings options as array
     *
     * @return array|null
     */
    public function getOptionsArrayAttribute()
    {
        if (empty($this->options)) {
            return null;
        }
        
        return json_decode($this->options, true);
    }
}
