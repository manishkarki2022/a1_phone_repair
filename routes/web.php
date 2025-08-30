<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteSettingController;
use App\Http\Controllers\DeviceCategoryController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\RepairServiceController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\DiscountBannerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ReportController;



Route::get('/errors-404', function () {
    abort(404);
});
Route::get('/', [FrontendController::class, 'home'])->name('home');
    Route::get('/book-repair', [FrontendController::class, 'create'])->name('booking.create');

  // Main booking routes

Route::post('/booking', [FrontendController::class, 'store'])->name('booking.store');
Route::get('/success/{bookingNumber}', [FrontendController::class, 'success'])->name('success');

// AJAX routes for dynamic content
Route::get('/device-types/{category}', [FrontendController::class, 'getDeviceTypes'])->name('device-types');
Route::get('/repair-services/{type}', [FrontendController::class, 'getRepairServices'])->name('repair-services');

// Additional utility routes

Route::post('/booking/{bookingNumber}/cancel', [FrontendController::class, 'cancelBooking'])->name('booking.cancel');

Route::get('/check-status/{booking_number}', [FrontendController::class, 'checkStatus'])->name('check-status');

Route::get('/check-status', function () {
    return view('frontend.pages.status');
})->name('status');

Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

//submit contact form
Route::post('/contact/submit', [FrontendController::class, 'submitContactForm'])->name('contact.submit');
Route::get('/about', [FrontendController::class, 'about'])->name('about');




Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



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
    Route::get('device-types/brands', [DeviceTypeController::class, 'getBrands'])->name('device-types.brands');
    Route::get('device-types/models', [DeviceTypeController::class, 'getModels'])->name('device-types.models');




    //Repair Services
    Route::resource('repair-services', RepairServiceController::class)->except(['show']);



    Route::resource('banners',DiscountBannerController::class)->except(['show']);

    //Contact Submissions
    Route::get('/contact-admin', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts-admin/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts-admin/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::patch('/contacts-admin/{contact}/read', [ContactController::class, 'markAsRead'])->name('contacts.read');


    //Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');





    //Customer Bookings

Route::resource('customer-bookings', CustomerBookingController::class);

// Additional custom routes for booking management
Route::prefix('customer-bookings')->name('customer-bookings.')->group(function () {

    // Status management routes
    Route::patch('{customerBooking}/status', [CustomerBookingController::class, 'updateStatus'])
        ->name('update-status');

    // Booking workflow routes
    Route::patch('{customerBooking}/confirm', [CustomerBookingController::class, 'confirm'])
        ->name('confirm');

    Route::patch('{customerBooking}/start-repair', [CustomerBookingController::class, 'startRepair'])
        ->name('start-repair');

    Route::patch('{customerBooking}/ready-for-pickup', [CustomerBookingController::class, 'readyForPickup'])
        ->name('ready-for-pickup');

    Route::patch('{customerBooking}/complete', [CustomerBookingController::class, 'complete'])
        ->name('complete');

    Route::patch('{customerBooking}/cancel', [CustomerBookingController::class, 'cancel'])
        ->name('cancel');
});


});

require __DIR__.'/auth.php';
