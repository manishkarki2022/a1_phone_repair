<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;
    protected $table = 'website_settings';

    protected $fillable = [
        // Basic Information
        'website_name',
        'slogan',
        'logo_path',
        'favicon_path',

        // Contact Information
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'phone',
        'mobile',
        'email',
        'contact_email',

        // Business Hours
        'opening_hours',
        'special_hours',

        // Design Settings
        'primary_color',
        'secondary_color',
        'tertiary_color',
        'font_family',
        'font_size',

        // Social Media
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'pinterest_url',

        // SEO Settings
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image_path',
        'google_analytics_id',
        'google_tag_manager_id',
        'custom_head_scripts',
        'custom_footer_scripts',

        // Additional Settings
        'default_language',
        'maintenance_mode',
        'maintenance_message',
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean',
    ];

    /**
     * Get the website settings (create if doesn't exist)
     */
    public static function getSettings()
    {
        $settings = self::first();

        if (!$settings) {
            $settings = self::create([
                'website_name' => 'My Website',
                'slogan' => 'Your Amazing Website',
                'primary_color' => '#3490dc',
                'secondary_color' => '#ffed4a',
                'default_language' => 'en',
                'maintenance_mode' => false,
                'meta_title' => 'My Website',
                'meta_description' => 'Welcome to my amazing website',
            ]);
        }

        return $settings;
    }
}
