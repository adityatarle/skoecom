<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'image',
        'title',
        'subtitle', 
        'description',
        'button_text',
        'button_url',
        'price_text',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active banners
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for slider banners
    public function scopeSlider($query)
    {
        return $query->where('type', 'slider');
    }

    // Scope for fullwidth banners
    public function scopeFullwidth($query)
    {
        return $query->where('type', 'fullwidth');
    }

    // Scope for newsletter banners
    public function scopeNewsletter($query)
    {
        return $query->where('type', 'newsletter');
    }
}