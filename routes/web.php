<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteSettingController;
use App\Http\Controllers\DeviceCategoryController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\RepairServiceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //website settings
    Route::get('/settings', [WebsiteSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [WebsiteSettingController::class, 'update'])->name('settings.update');


    //Device Categories
     // Resource routes for Device Categories
         Route::resource('device-categories', DeviceCategoryController::class)->names('device-categories');


    // Additional routes for Device Categories
    Route::prefix('device-categories')->name('device-categories.')->group(function () {

        // Toggle status route
        Route::patch('{deviceCategory}/toggle-status', [DeviceCategoryController::class, 'toggleStatus'])
             ->name('toggle-status');

        // Bulk actions route
        Route::post('bulk-delete', [DeviceCategoryController::class, 'bulkDelete'])
         ->name('bulk-delete');

        // Update display order (for drag & drop)
        Route::post('update-order', [DeviceCategoryController::class, 'updateOrder'])
             ->name('update-order');
    });

    //Device Types
      // Main resource routes for device types
    Route::resource('device-types', DeviceTypeController::class);

    //Repair Services
    Route::resource('repair-services', RepairServiceController::class)->except(['show']);


});

require __DIR__.'/auth.php';
