<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairService extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_type_id',
        'service_name',
        'description',
        'image_path', // ✅ Corrected from 'image' to 'image_path'
        'estimated_time_hours',
        'admin_price',
        'admin_cost',
        'warranty_days',
        'is_popular',
        'display_order',
        'status'
    ];

    protected $casts = [
        'admin_price' => 'decimal:2',
        'admin_cost' => 'decimal:2',
        'is_popular' => 'boolean',
        'estimated_time_hours' => 'integer',
        'warranty_days' => 'integer',
        'display_order' => 'integer'
    ];

    // Relationship with DeviceType
    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class);
    }

    // Scopes for comprehensive filtering
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }

    public function scopeNotPopular($query)
    {
        return $query->where('is_popular', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }

    public function scopeByDeviceType($query, $deviceTypeId)
    {
        return $query->where('device_type_id', $deviceTypeId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('service_name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhereHas('deviceType', function($deviceQuery) use ($search) {
                  $deviceQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    // Price range filters
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        if ($minPrice !== null) {
            $query->where('admin_price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('admin_price', '<=', $maxPrice);
        }
        return $query;
    }

    public function scopeCostRange($query, $minCost, $maxCost)
    {
        if ($minCost !== null) {
            $query->where('admin_cost', '>=', $minCost);
        }
        if ($maxCost !== null) {
            $query->where('admin_cost', '<=', $maxCost);
        }
        return $query;
    }

    // Time range filters
    public function scopeTimeRange($query, $minHours, $maxHours)
    {
        if ($minHours !== null) {
            $query->where('estimated_time_hours', '>=', $minHours);
        }
        if ($maxHours !== null) {
            $query->where('estimated_time_hours', '<=', $maxHours);
        }
        return $query;
    }

    // Warranty range filters
    public function scopeWarrantyRange($query, $minDays, $maxDays)
    {
        if ($minDays !== null) {
            $query->where('warranty_days', '>=', $minDays);
        }
        if ($maxDays !== null) {
            $query->where('warranty_days', '<=', $maxDays);
        }
        return $query;
    }

    // Display order range filters
    public function scopeOrderRange($query, $minOrder, $maxOrder)
    {
        if ($minOrder !== null) {
            $query->where('display_order', '>=', $minOrder);
        }
        if ($maxOrder !== null) {
            $query->where('display_order', '<=', $maxOrder);
        }
        return $query;
    }

    // Comprehensive filter scope
    public function scopeFilter($query, $request)
    {
        return $query
            // Text search
            ->when($request->filled('search'), function($q) use ($request) {
                return $q->search($request->search);
            })
            // Device type filter
            ->when($request->filled('device_type'), function($q) use ($request) {
                return $q->byDeviceType($request->device_type);
            })
            // Status filter
            ->when($request->filled('status'), function($q) use ($request) {
                return $q->byStatus($request->status);
            })
            // Popular filter
            ->when($request->filled('popular'), function($q) use ($request) {
                return $request->popular == '1' ? $q->popular() : $q->notPopular();
            })
            // Price range filter
            ->when($request->filled('min_price') || $request->filled('max_price'), function($q) use ($request) {
                return $q->priceRange($request->min_price, $request->max_price);
            })
            // Cost range filter
            ->when($request->filled('min_cost') || $request->filled('max_cost'), function($q) use ($request) {
                return $q->costRange($request->min_cost, $request->max_cost);
            })
            // Time range filter
            ->when($request->filled('min_hours') || $request->filled('max_hours'), function($q) use ($request) {
                return $q->timeRange($request->min_hours, $request->max_hours);
            })
            // Warranty range filter
            ->when($request->filled('min_warranty') || $request->filled('max_warranty'), function($q) use ($request) {
                return $q->warrantyRange($request->min_warranty, $request->max_warranty);
            })
            // Display order range filter
            ->when($request->filled('min_order') || $request->filled('max_order'), function($q) use ($request) {
                return $q->orderRange($request->min_order, $request->max_order);
            });
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->admin_price, 2);
    }

    public function getFormattedCostAttribute()
    {
        return $this->admin_cost ? '$' . number_format($this->admin_cost, 2) : 'N/A';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active'
            ? '<span class="badge badge-success">Active</span>'
            : '<span class="badge badge-danger">Inactive</span>';
    }

    public function getPopularBadgeAttribute()
    {
        return $this->is_popular
            ? '<span class="badge badge-warning">Popular</span>'
            : '';
    }

    // Image handling

    	 public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('default/no-image.png');
    }

    public function hasImage()
    {
        return !empty($this->image_path) && file_exists(storage_path('app/public/storage/' . $this->image_path));
    }
}
