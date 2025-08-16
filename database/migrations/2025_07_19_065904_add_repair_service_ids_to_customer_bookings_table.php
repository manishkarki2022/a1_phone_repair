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
        Schema::table('customer_bookings', function (Blueprint $table) {
            // Add JSON field for multiple repair service IDs
            $table->json('repair_service_ids')->nullable()->after('repair_service_id');

            // Optional: Make the old single repair_service_id field nullable if it's not already
            // $table->bigInteger('repair_service_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_bookings', function (Blueprint $table) {
            $table->dropColumn('repair_service_ids');
        });
    }
};
