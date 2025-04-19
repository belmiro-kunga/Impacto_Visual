<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'company',
        'testimonial',
        'image',
        'rating',
        'order',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'rating' => 'integer',
        'order' => 'integer'
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        
        // If the path already starts with 'storage/', return as is
        if (str_starts_with($this->image, 'storage/')) {
            return asset($this->image);
        }
        
        // Otherwise, prepend 'storage/' to the path
        return Storage::url($this->image);
    }
} 