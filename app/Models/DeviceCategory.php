<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'device_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'icon',
        'display_order',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'display_order' => 'integer',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'display_order' => 'integer',
            'status' => 'string',
        ];
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to order by display order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDisplayOrder($query, $direction = 'asc')
    {
        return $query->orderBy('display_order', $direction);
    }

    /**
     * Get the icon URL or class.
     *
     * @return string|null
     */
    public function getIconUrlAttribute()
    {
        if (!$this->icon) {
            return null;
        }

        // If icon starts with 'fa-' or 'fas ', assume it's a Font Awesome class
        if (str_starts_with($this->icon, 'fa-') || str_starts_with($this->icon, 'fas ')) {
            return $this->icon;
        }

        // Otherwise, assume it's a file path
        return asset('storage/' . $this->icon);
    }

    /**
     * Check if the category is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the category is inactive.
     *
     * @return bool
     */
    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    /**
     * Get the status badge HTML.
     *
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        $badgeClass = $this->status === 'active' ? 'badge-success' : 'badge-danger';
        $statusText = ucfirst($this->status);

        return "<span class='badge {$badgeClass}'>{$statusText}</span>";
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set display_order when creating
        static::creating(function ($model) {
            if (!$model->display_order) {
                $model->display_order = static::max('display_order') + 1;
            }
        });
    }

    /**
     * Get available status options.
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
        ];
    }

    /**
     * Search categories by name or description.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

  public function deviceTypes()
    {
        return $this->hasMany(DeviceType::class, 'category_id');
    }

}
