<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('website_name');
            $table->string('slogan')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();

            // Contact Information
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_email')->nullable();

            // Business Hours
            $table->text('opening_hours')->nullable();
            $table->text('special_hours')->nullable();

            // Design Settings
            $table->string('primary_color')->default('#3490dc');
            $table->string('secondary_color')->default('#ffed4a');
            $table->string('tertiary_color')->nullable();
            $table->string('font_family')->nullable();
            $table->string('font_size')->nullable();

            // Social Media
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('pinterest_url')->nullable();

            // SEO Settings
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->string('google_tag_manager_id')->nullable();
            $table->text('custom_head_scripts')->nullable();
            $table->text('custom_footer_scripts')->nullable();

            // Additional Settings

            $table->string('default_language')->default('en');
            $table->boolean('maintenance_mode')->default(false);
            $table->text('maintenance_message')->nullable();


            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
