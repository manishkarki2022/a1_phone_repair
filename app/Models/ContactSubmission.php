<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_type',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'is_read'
    ];

    // Inquiry types for dropdown
    public static $inquiryTypes = [
        'general' => 'General Question',
        'repair' => 'Repair Question',
        'pricing' => 'Pricing Inquiry',
        'warranty' => 'Warranty Claim',
        'complaint' => 'Complaint',
        'suggestion' => 'Suggestion'
    ];
}
