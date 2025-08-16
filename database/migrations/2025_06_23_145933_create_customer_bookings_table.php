<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 20)->unique();

            // Customer Information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 20);
            $table->text('customer_address')->nullable();
            $table->string('customer_city', 100)->nullable();

            // Device Information
            $table->foreignId('device_category_id')->nullable()->constrained('device_categories')->nullOnDelete();
            $table->foreignId('device_type_id')->nullable()->constrained('device_types')->nullOnDelete();
            $table->string('device_brand', 100)->nullable();
            $table->string('device_model', 100)->nullable();

            // Repair Information
            $table->foreignId('repair_service_id')->nullable()->constrained('repair_services')->nullOnDelete();
            $table->text('custom_repair_description')->nullable();
            $table->text('device_issue_description');
            $table->text('device_condition')->nullable();

            // Booking Time Preferences
            $table->date('preferred_date');
            $table->enum('preferred_time_slot', ['morning', 'afternoon', 'evening', 'anytime'])->default('anytime');
            $table->time('preferred_time')->nullable();

            // Confirmed Schedule
            $table->date('confirmed_date')->nullable();
            $table->time('confirmed_time')->nullable();
            $table->timestamp('estimated_completion_time')->nullable();

            // Booking Status
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'ready_for_pickup', 'completed', 'cancelled', 'rejected'])->default('pending');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');

            // Admin Fields
            $table->decimal('admin_quoted_price', 10, 2)->nullable();
            $table->decimal('admin_final_price', 10, 2)->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('internal_repair_notes')->nullable();

            // Customer Notes
            $table->text('customer_notes')->nullable();
            $table->text('special_instructions')->nullable();

            // Timestamps
            $table->timestamp('booking_date')->useCurrent();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_bookings');
    }
};
