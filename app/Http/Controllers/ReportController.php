<?php

namespace App\Http\Controllers;

use App\Models\CustomerBooking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
  public function index(Request $request)
{
    // Get filters with validation
    $validated = $request->validate([
        'from' => 'nullable|date',
        'to' => 'nullable|date',
        'status' => 'nullable|in:pending,confirmed,completed,cancelled'
    ]);

    $from = $validated['from'] ?? now()->subMonth()->format('Y-m-d');
    $to = $validated['to'] ?? now()->format('Y-m-d');
    $status = $validated['status'] ?? null;

    // Ensure to date is not before from date
    if (Carbon::parse($from)->gt(Carbon::parse($to))) {
        $from = $to;
    }

    // Query bookings with pagination
    $bookingsQuery = CustomerBooking::with(['repairService'])
        ->whereBetween('booking_date', [$from, $to])
        ->orderBy('booking_date', 'desc');

    if ($status) {
        $bookingsQuery->where('status', $status);
    }

    $bookings = $bookingsQuery->paginate(15)->appends($request->query());

    // Summary counts
    $summary = [
        'total' => $bookings->total(),
        'pending' => CustomerBooking::whereBetween('booking_date', [$from, $to])
                        ->where('status', 'pending')
                        ->count(),
        'confirmed' => CustomerBooking::whereBetween('booking_date', [$from, $to])
                        ->where('status', 'confirmed')
                        ->count(),
        'completed' => CustomerBooking::whereBetween('booking_date', [$from, $to])
                        ->where('status', 'completed')
                        ->count(),
        'cancelled' => CustomerBooking::whereBetween('booking_date', [$from, $to])
                        ->where('status', 'cancelled')
                        ->count(),
    ];

    return view('admin.reports.index', compact('bookings', 'summary', 'from', 'to', 'status'));
}
}
