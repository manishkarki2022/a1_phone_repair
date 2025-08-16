<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'name',           // e.g., 'Daily Bookings', 'Revenue Report'
        'report_type',    // e.g., 'booking', 'revenue', 'customer'
        'filters',        // JSON of filters applied
    ];

    protected $casts = [
        'filters' => 'array',
    ];
}
