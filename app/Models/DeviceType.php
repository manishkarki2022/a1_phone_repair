<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'model',
        'image',
        'display_order',
        'status'
    ];

    protected $casts = [
        'category_id' => 'integer',
        'display_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with DeviceCategory
    public function category()
    {
        return $this->belongsTo(DeviceCategory::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOrderedByDisplay($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->brand . ' ' . $this->name;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-device.png');
    }

    // Methods
    public function isActive()
    {
        return $this->status === 'active';
    }
    public function repairServices()
    {
        return $this->hasMany(RepairService::class);
    }
      public function bookings()
    {
        return $this->hasMany(CustomerBooking::class, 'device_type_id');
    }

}
