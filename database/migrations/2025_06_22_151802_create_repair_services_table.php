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
        Schema::create('repair_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_type_id')->constrained()->onDelete('cascade');
            $table->string('service_name', 150);
            $table->text('description')->nullable();
            $table->integer('estimated_time_hours');
            $table->decimal('admin_price', 10, 2);
            $table->decimal('admin_cost', 10, 2)->nullable();
            $table->integer('warranty_days')->default(30);
            $table->boolean('is_popular')->default(false);
            $table->integer('display_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            // Indexes
            $table->index('device_type_id');
            $table->index('status');
            $table->index('display_order');
            $table->index('is_popular');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_services');
    }
};
