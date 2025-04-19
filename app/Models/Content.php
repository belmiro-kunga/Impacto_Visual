<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'section',
        'label',
        'value',
        'type',
        'order',
    ];

    /**
     * Get contents by section
     *
     * @param string $section
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getBySection(string $section)
    {
        return self::where('section', $section)
            ->orderBy('order')
            ->get();
    }

    /**
     * Get all available sections
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSections()
    {
        return self::select('section')
            ->distinct()
            ->orderBy('section')
            ->pluck('section');
    }

    /**
     * Get content value by key
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function getValue(string $key, string $default = '')
    {
        $content = self::where('key', $key)->first();
        return $content ? $content->value : $default;
    }
} 