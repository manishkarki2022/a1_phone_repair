<?php

namespace App\Http\Controllers;

use App\Models\CustomerBooking;
use App\Models\DeviceCategory;
use App\Models\DeviceType;
use App\Models\RepairService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Mail\RepairStarted;
use App\Mail\DeviceReadyForPickup;
use App\Mail\ServiceCompleted;
use App\Mail\BookingCancellationNotification;





class CustomerBookingController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = CustomerBooking::with(['deviceCategory', 'deviceType', 'repairService']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by date range
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->byDateRange($request->date_from, $request->date_to);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.customer-bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $deviceCategories = DeviceCategory::all();
        $deviceTypes = DeviceType::all();
        $repairServices = RepairService::all();

        return view('admin.customer-bookings.create', compact(
            'deviceCategories',
            'deviceTypes',
            'repairServices'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'customer_city' => 'nullable|string|max:100',
            'device_category_id' => 'nullable|exists:device_categories,id',
            'device_type_id' => 'nullable|exists:device_types,id',
            'device_brand' => 'nullable|string|max:100',
            'device_model' => 'nullable|string|max:100',
            'repair_service_id' => 'nullable|exists:repair_services,id',
            'custom_repair_description' => 'nullable|string',
            'device_issue_description' => 'required|string',
            'device_condition' => 'nullable|string',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time_slot' => 'required|in:morning,afternoon,evening,anytime',
            'preferred_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:low,normal,high,urgent',
            'customer_notes' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        $booking = CustomerBooking::create($validated);

        return redirect()->route('customer-bookings.show', $booking)
            ->with('success', 'Booking created successfully! Booking Number: ' . $booking->booking_number);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerBooking $customerBooking): View
    {
        $customerBooking->load(['deviceCategory', 'deviceType', 'repairService']);

        return view('admin.customer-bookings.show', compact('customerBooking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerBooking $customerBooking): View
    {
        $deviceCategories = DeviceCategory::all();
        $deviceTypes = DeviceType::all();
        $repairServices = RepairService::all();

        return view('admin.customer-bookings.edit', compact(
            'customerBooking',
            'deviceCategories',
            'deviceTypes',
            'repairServices'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerBooking $customerBooking): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'customer_city' => 'nullable|string|max:100',
            'device_category_id' => 'nullable|exists:device_categories,id',
            'device_type_id' => 'nullable|exists:device_types,id',
            'device_brand' => 'nullable|string|max:100',
            'device_model' => 'nullable|string|max:100',
            'repair_service_id' => 'nullable|exists:repair_services,id',
            'custom_repair_description' => 'nullable|string',
            'device_issue_description' => 'required|string',
            'device_condition' => 'nullable|string',
            'preferred_date' => 'required|date',
            'preferred_time_slot' => 'required|in:morning,afternoon,evening,anytime',
            'preferred_time' => 'nullable|date_format:H:i',
            'confirmed_date' => 'nullable|date',
            'confirmed_time' => 'nullable|date_format:H:i',
            'estimated_completion_time' => 'nullable|date',
            'status' => 'required|in:pending,confirmed,in_progress,ready_for_pickup,completed,cancelled,rejected',
            'priority' => 'required|in:low,normal,high,urgent',
            'admin_quoted_price' => 'nullable|numeric|min:0',
            'admin_final_price' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
            'internal_repair_notes' => 'nullable|string',
            'customer_notes' => 'nullable|string',
            'special_instructions' => 'nullable|string',
        ]);

        $customerBooking->update($validated);

        return redirect()->route('customer-bookings.show', $customerBooking)
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerBooking $customerBooking): RedirectResponse
    {
        $customerBooking->delete();

        return redirect()->route('customer-bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, CustomerBooking $customerBooking): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,ready_for_pickup,completed,cancelled,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $updateData = ['status' => $validated['status']];

        // Set timestamps based on status
        switch ($validated['status']) {
            case 'confirmed':
                $updateData['confirmed_at'] = now();
                break;
            case 'in_progress':
                $updateData['started_at'] = now();
                break;
            case 'completed':
                $updateData['completed_at'] = now();
                break;
        }

        if (isset($validated['admin_notes'])) {
            $updateData['admin_notes'] = $validated['admin_notes'];
        }

        $customerBooking->update($updateData);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully!',
                'booking' => $customerBooking->fresh()
            ]);
        }

        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }

    /**
     * Confirm a booking with scheduled date and time.
     */
   public function confirm(Request $request, CustomerBooking $customerBooking): RedirectResponse
{
    // Validate the request data
    $validated = $request->validate([
        'confirmed_date' => 'required|date|after_or_equal:today',
        'confirmed_time' => 'required|date_format:H:i',
        'estimated_completion_time' => 'nullable|date|after:confirmed_date',
        'admin_quoted_price' => 'nullable|numeric|min:0',
        'admin_notes' => 'nullable|string|max:500',
    ]);

    try {
        // Update the booking
        $customerBooking->update([
            'status' => 'confirmed',
            'confirmed_date' => $validated['confirmed_date'],
            'confirmed_time' => $validated['confirmed_time'],
            'estimated_completion_time' => $validated['estimated_completion_time'] ?? null,
            'admin_quoted_price' => $validated['admin_quoted_price'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'confirmed_at' => now(),
        ]);

        // Send confirmation email
        try {
            if (empty($customerBooking->customer_email)) {
                throw new \Exception('Customer email address is empty');
            }

            Mail::to($customerBooking->customer_email)
                ->send(new BookingConfirmed($customerBooking));

            return redirect()
                ->route('customer-bookings.show', $customerBooking)
                ->with('success', 'Booking confirmed successfully! Notification sent to customer.');

        } catch (\Exception $emailException) {
            Log::error('Email sending failed for booking #' . $customerBooking->id, [
                'error' => $emailException->getMessage(),
                'email' => $customerBooking->customer_email,
                'trace' => $emailException->getTraceAsString()
            ]);

            return redirect()
                ->route('customer-bookings.show', $customerBooking)
                ->with('success', 'Booking confirmed successfully!')
                ->with('warning', 'Confirmation email could not be sent: ' . $emailException->getMessage());
        }

    } catch (\Illuminate\Validation\ValidationException $e) {
        // This will automatically handle validation errors
        throw $e;

    } catch (\Exception $e) {
        Log::error('Booking confirmation failed: ' . $e->getMessage(), [
            'booking_id' => $customerBooking->id,
            'error' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        return redirect()
            ->back()
            ->with('error', 'Failed to confirm booking. Please try again or contact support if the problem persists.')
            ->withInput();
    }
}
    /**
     * Start repair work.
     */
   public function startRepair(CustomerBooking $customerBooking): RedirectResponse
{

    try {
        // Update the booking status
        $customerBooking->update([
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        // Send email notification
        try {
            if (empty($customerBooking->customer_email)) {
                throw new \Exception('No customer email address available');
            }

            Mail::to($customerBooking->customer_email)
                ->send(new RepairStarted($customerBooking));

            return redirect()->back()
                ->with('success', 'Repair work started! Notification sent to customer.');

        } catch (\Exception $emailException) {
            Log::error('Failed to send repair started email for booking #' . $customerBooking->id, [
                'error' => $emailException->getMessage(),
                'email' => $customerBooking->customer_email,
                'trace' => $emailException->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('success', 'Repair work started!')
                ->with('warning', 'Could not send notification email: ' . $emailException->getMessage());
        }

    } catch (\Exception $e) {
        Log::error('Failed to start repair for booking #' . $customerBooking->id, [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->back()
            ->with('error', 'Failed to start repair. Please try again.');
    }
}

    /**
     * Mark as ready for pickup.
     */
    public function readyForPickup(Request $request, CustomerBooking $customerBooking): RedirectResponse
    {
        $validated = $request->validate([
            'admin_final_price' => 'nullable|numeric|min:0',
            'internal_repair_notes' => 'nullable|string',
        ]);

        $customerBooking->update([
            'status' => 'ready_for_pickup',
            'admin_final_price' => $validated['admin_final_price'] ?? null,
            'internal_repair_notes' => $validated['internal_repair_notes'] ?? null,
            'ready_for_pickup_at' => now(),
            'completed_at' => now()
        ]);
        // Send email notification
        Mail::to($customerBooking->customer_email)
            ->send(new DeviceReadyForPickup($customerBooking));

        return redirect()->back()->with('success', 'Booking marked as ready for pickup!');
    }

    /**
     * Complete the booking.
     */
  public function complete(CustomerBooking $customerBooking): RedirectResponse
{
    try {
        // Update the booking status
        $updateResult = $customerBooking->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        if (!$updateResult) {
            throw new \RuntimeException('Failed to update booking record');
        }

        // Send completion email
        try {
            if (!empty($customerBooking->customer_email)) {
                Mail::to($customerBooking->customer_email)
                    ->send(new ServiceCompleted($customerBooking));

                return redirect()->back()
                    ->with('success', 'Service completed! Notification sent to customer.');
            }

            Log::warning('Service completed but no customer email available', [
                'booking_id' => $customerBooking->id
            ]);

            return redirect()->back()
                ->with('success', 'Service completed successfully!')
                ->with('warning', 'No customer email available for notification');

        } catch (\Exception $emailException) {
            Log::error('Failed to send completion email: ' . $emailException->getMessage(), [
                'booking_id' => $customerBooking->id,
                'error' => $emailException->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('success', 'Service completed successfully!')
                ->with('warning', 'Completion notification failed to send');
        }

    } catch (\Exception $e) {
        Log::error('Failed to complete booking: ' . $e->getMessage(), [
            'booking_id' => $customerBooking->id,
            'error' => $e->getTraceAsString()
        ]);

        return redirect()->back()
            ->with('error', 'Failed to complete booking. Please try again.');
    }
}
    /**
     * Cancel the booking.
     */
public function cancel(Request $request, CustomerBooking $customerBooking): RedirectResponse
{
    $validated = $request->validate([
        'cancel_note' => 'required|string|min:10|max:500',
        'admin_notes' => 'nullable|string',
    ]);

    $customerBooking->update([
        'status' => 'cancelled',
        'cancel_note' => $validated['cancel_note'],
        'admin_notes' => $validated['admin_notes'] ?? $customerBooking->admin_notes,
        'completed_at' => now(),
    ]);

    if ($customerBooking->customer_email) {
        Mail::to($customerBooking->customer_email)->send(
            new BookingCancellationNotification(
                $customerBooking,
                $validated['cancel_note'] // Add this second parameter
            )
        );
    }

    return redirect()->back()->with([
        'success' => 'Booking cancelled successfully!',
        'cancellation_reason' => $validated['cancel_note']
    ]);
}
    public function showConfirmForm(Request $request, CustomerBooking $customerBooking)
{

     $validated = $request->validate([
            'confirmed_date' => 'required|date|after_or_equal:today',
            'confirmed_time' => 'required|date_format:H:i',
            'estimated_completion_time' => 'nullable|date|after:confirmed_date',
            'admin_quoted_price' => 'nullable|numeric|min:0',
            'admin_notes' => 'nullable|string',
        ]);

        $customerBooking->update([
            'status' => 'confirmed',
            'confirmed_date' => $validated['confirmed_date'],
            'confirmed_time' => $validated['confirmed_time'],
            'estimated_completion_time' => $validated['estimated_completion_time'] ?? null,
            'admin_quoted_price' => $validated['admin_quoted_price'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'confirmed_at' => now(),
        ]);

        return redirect()->route('customer-bookings.show', $customerBooking)
            ->with('success', 'Booking confirmed successfully!');
}
}
