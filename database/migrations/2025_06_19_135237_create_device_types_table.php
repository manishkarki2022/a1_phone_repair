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
         Schema::create('device_types', function (Blueprint $table) {
            $table->id(); // BigInt auto-increment
            $table->unsignedBigInteger('category_id');
            $table->string('name', 100);
            $table->string('brand', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('image')->nullable();
            $table->integer('display_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps(); // created_at & updated_at

            // Foreign key constraint
            $table->foreign('category_id')
                  ->references('id')
                  ->on('device_categories')
                  ->onDelete('cascade');

            // Indexes for better performance
            $table->index('category_id');
            $table->index('status');
            $table->index('display_order');
            $table->index(['category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_types');
    }
};
