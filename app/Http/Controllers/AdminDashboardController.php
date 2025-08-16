<?php

namespace App\Http\Controllers;

use App\Models\CustomerBooking;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalBookings' => CustomerBooking::count(),
            'pendingBookings' => CustomerBooking::where('status', 'pending')->count(),
            'confirmedBookings' => CustomerBooking::where('status', 'confirmed')->count(),
            'completedBookings' => CustomerBooking::where('status', 'completed')->count(),
            'recentBookings' => CustomerBooking::with('repairService')->latest()->take(5)->get(),
        ]);
    }
}
