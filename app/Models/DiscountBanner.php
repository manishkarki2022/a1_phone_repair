<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DiscountBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image_path',
        'is_active',
        'is_hero_slide',
        'display_order',
        'start_date',
        'end_date',
        'views'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_hero_slide' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/'.$this->image_path) : null;
    }

    public function scopeActiveHeroSlides($query)
    {
        return $query->where('is_hero_slide', true)
                    ->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    })
                    ->orderBy('display_order', 'asc');
    }
}
