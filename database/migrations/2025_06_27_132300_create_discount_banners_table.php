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
         Schema::create('discount_banners', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('image_path');

            // Display Control
            $table->boolean('is_active')->default(true);
            $table->boolean('is_hero_slide')->default(false);
            $table->integer('display_order')->default(0);

            // Simple Date Control
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Minimal Tracking
            $table->integer('views')->default(0);

            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_banners');
    }
};
