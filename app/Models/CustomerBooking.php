<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class CustomerBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'customer_city',
        'device_category_id',
        'device_type_id',
        'device_brand',
        'device_model',
        'repair_service_id', // Single service ID now
        'custom_repair_description',
        'device_issue_description',
        'device_condition',
        'preferred_date',
        'preferred_time_slot',
        'preferred_time',
        'confirmed_date',
        'confirmed_time',
        'estimated_completion_time',
        'status',
        'priority',
        'admin_quoted_price',
        'admin_final_price',
        'admin_notes',
        'internal_repair_notes',
        'customer_notes',
        'special_instructions',
        'booking_date',
        'confirmed_at',
        'started_at',
        'completed_at',
        'cancel_note', // Add this new field
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'confirmed_date' => 'date',
        'preferred_time' => 'datetime:H:i',
        'confirmed_time' => 'datetime:H:i',
        'estimated_completion_time' => 'datetime',
        'booking_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'admin_quoted_price' => 'decimal:2',
        'admin_final_price' => 'decimal:2',
    ];

    // Relationships
    public function deviceCategory(): BelongsTo
    {
        return $this->belongsTo(DeviceCategory::class);
    }

    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function repairService(): BelongsTo
    {
        return $this->belongsTo(RepairService::class);
    }

    // Updated: Accessor to get the selected repair service (now single service)
    public function getSelectedServiceAttribute()
    {
        if (empty($this->repair_service_id)) {
            return null;
        }

        $cacheKey = "booking_service_" . $this->id;

        return Cache::remember($cacheKey, 1800, function() {
            return RepairService::where('id', $this->repair_service_id)
                               ->where('status', 'active')
                               ->first();
        });
    }

    // Updated: Get service price (now single service)
    public function getServicePriceAttribute()
    {
        return $this->selected_service ? $this->selected_service->admin_price : 0;
    }

    // Updated: Get estimated time (now single service)
    public function getEstimatedTimeAttribute()
    {
        return $this->selected_service ? $this->selected_service->estimated_time_hours : 0;
    }

    // Updated: Get warranty days (now single service)
    public function getWarrantyDaysAttribute()
    {
        return $this->selected_service ? $this->selected_service->warranty_days : 0;
    }

    // Updated: Check if booking has warranty (now single service)
    public function getHasWarrantyAttribute()
    {
        return $this->warranty_days > 0;
    }

    // Updated: Get service name (now single service)
    public function getServiceNameAttribute()
    {
        return $this->selected_service ? $this->selected_service->service_name : 'Custom Repair';
    }

    // Existing accessors
    public function getFormattedBookingDateAttribute(): string
    {
        return $this->booking_date->format('M d, Y \a\t g:i A');
    }

    public function getFormattedPreferredDateAttribute(): string
    {
        return $this->preferred_date->format('M d, Y');
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'in_progress' => 'primary',
            'ready_for_pickup' => 'success',
            'completed' => 'success',
            'cancelled' => 'danger',
            'rejected' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getPriorityBadgeAttribute(): string
    {
        $badges = [
            'low' => 'secondary',
            'normal' => 'primary',
            'high' => 'warning',
            'urgent' => 'danger',
        ];

        return $badges[$this->priority] ?? 'secondary';
    }

    public function getFormattedTimeSlotAttribute(): string
    {
        $slots = [
            'morning' => '🌅 Morning (9AM - 12PM)',
            'afternoon' => '☀️ Afternoon (1PM - 5PM)',
            'evening' => '🌆 Evening (6PM - 8PM)',
            'anytime' => '⏰ Anytime',
        ];

        return $slots[$this->preferred_time_slot] ?? ucfirst($this->preferred_time_slot);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('preferred_date', [$startDate, $endDate]);
    }

    // Updated: Scope for bookings with specific service
    public function scopeWithService($query, $serviceId)
    {
        return $query->where('repair_service_id', $serviceId);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Static methods
    public static function generateBookingNumber(): string
    {
        $prefix = 'BK';
        $date = now()->format('Ymd');
        $lastBooking = static::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastBooking ? (int)substr($lastBooking->booking_number, -4) + 1 : 1;

        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // Updated: Get booking statistics
    public static function getStats($days = 30)
    {
        $startDate = now()->subDays($days);

        return [
            'total' => static::where('created_at', '>=', $startDate)->count(),
            'pending' => static::pending()->where('created_at', '>=', $startDate)->count(),
            'confirmed' => static::confirmed()->where('created_at', '>=', $startDate)->count(),
            'completed' => static::completed()->where('created_at', '>=', $startDate)->count(),
        ];
    }

    // Boot method to auto-generate booking number and handle cache
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->booking_number)) {
                $model->booking_number = static::generateBookingNumber();
            }
        });

        // Clear cache when booking is updated
        static::updated(function ($model) {
            Cache::forget("booking_service_" . $model->id);
        });

        static::deleted(function ($model) {
            Cache::forget("booking_service_" . $model->id);
        });
    }

    // Updated: Method to set service for booking
    public function setService($serviceId)
    {
        $this->repair_service_id = $serviceId;
        $this->save();

        // Clear cache
        Cache::forget("booking_service_" . $this->id);
    }

    // Updated: Method to remove service from booking
    public function removeService()
    {
        $this->repair_service_id = null;
        $this->save();

        // Clear cache
        Cache::forget("booking_service_" . $this->id);
    }

    // Updated: Check if booking has specific service
    public function hasService($serviceId)
    {
        return $this->repair_service_id == $serviceId;
    }
     // Add this new accessor
    public function getCancelNoteAttribute($value)
    {
        return $value ?? 'No cancellation note provided';
    }
}
