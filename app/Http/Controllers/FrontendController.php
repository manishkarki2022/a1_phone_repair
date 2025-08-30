<?php

// 1. UPDATED FRONTEND CONTROLLER WITH CACHING
namespace App\Http\Controllers;

use App\Models\CustomerBooking;
use App\Models\DeviceCategory;
use App\Models\DeviceType;
use App\Models\RepairService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\DiscountBanner;
// use App\Mail\ContactSubmission;
use App\Models\ContactSubmission;
use SEOMeta;
use OpenGraph;
use Twitter;
use App\Models\WebsiteSetting;


class FrontendController extends Controller
{
    private function setSeo($title = null, $description = null, $keywords = [])
    {
        $settings = WebsiteSetting::getSettings();

        $title = $title ?? $settings->meta_title ?? $settings->website_name;
        $description = $description ?? $settings->meta_description ?? '';
        $keywords = !empty($keywords) ? $keywords : explode(',', $settings->meta_keywords ?? '');

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        if (!empty($keywords)) {
            SEOMeta::setKeywords($keywords);
        }

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'website');
        if($settings->og_image_path){
            OpenGraph::addImage(asset($settings->og_image_path));
        }

        Twitter::setTitle($title);
        Twitter::setSite('@yourtwitterhandle'); // Replace with actual handle if needed
    }

public function home()
{
    $heroSliders = DiscountBanner::activeHeroSlides()->get();

    // Track views (optional)
    if ($heroSliders->isNotEmpty()) {
        DiscountBanner::whereIn('id', $heroSliders->pluck('id'))->increment('views');
    }

    // If no hero sliders, prepare a default one
    if ($heroSliders->isEmpty()) {
        $heroSliders = collect([
            (object)[
                'title' => websiteInfo()->website_name,
                'content' => 'Professional repair services for all your devices',
                'image_url' => asset('images/default-hero.png'), // keep a default image in public/images
            ]
        ]);
    }

    $this->setSeo(); // Uses default website settings

    return view('frontend.pages.home', compact('heroSliders'));
}
public function contact()
{
    $this->setSeo('Contact Us - ' . websiteInfo()->website_name, 'Get in touch with us for service inquiries.');
    return view('frontend.pages.contact');
}

public function about()
{
     $this->setSeo('About Us - ' . websiteInfo()->website_name, 'Learn more about our repair shop and services.');
    return view('frontend.pages.about');
}



  public function create()
{
    $categories = Cache::remember('device_categories_active', 3600, function () {
        return DeviceCategory::where('status', 'active')
            ->orderBy('display_order')
            ->get();
    });

    $this->setSeo(
        'Book a Repair - ' . websiteInfo()->website_name,
        'Schedule your device repair with our expert technicians. Fast, reliable service for all your devices.',
        ['book repair', 'schedule repair', 'device repair appointment']
    );

    return view('frontend.pages.booking', compact('categories'));
}

public function store(Request $request)
{
// dd($request->all());
    // Define validation rules
    $rules = [
        'customer_name' => 'required|string|max:255|min:2',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|max:20|min:10',
        'customer_address' => 'nullable|string|max:500',
        'customer_city' => 'nullable|string|max:100',
        'device_category_id' => 'required|exists:device_categories,id',
        'device_type_id' => 'required|exists:device_types,id',
        'device_brand' => 'required|string|max:100',
        'device_model' => 'required|string|max:100',
        'device_condition' => 'nullable|string|max:500',
        'repair_service_id' => 'nullable|exists:repair_services,id',
        'custom_repair_description' => 'nullable|string|max:2000',
        'preferred_date' => 'required|date|after_or_equal:today',
        'preferred_time_slot' => 'required|in:morning,afternoon,evening,anytime',
        'preferred_time' => 'nullable|date_format:H:i',
        'agree_terms' => 'required|accepted'
    ];

    // Custom error messages
    $messages = [
        'customer_name.required' => 'Your full name is required.',
        'customer_name.min' => 'Name must be at least 2 characters.',
        'customer_email.required' => 'Email address is required.',
        'customer_email.email' => 'Please enter a valid email address.',
        'customer_phone.required' => 'Phone number is required.',
        'customer_phone.min' => 'Phone number must be at least 10 digits.',
        'device_category_id.required' => 'Please select a device category.',
        'device_category_id.exists' => 'Invalid device category selected.',
        'device_type_id.required' => 'Please select a device type.',
        'device_type_id.exists' => 'Invalid device type selected.',
        'device_brand.required' => 'Please enter the device brand.',
        'device_model.required' => 'Please enter the device model.',
        'preferred_date.required' => 'Please select your preferred date.',
        'preferred_date.after_or_equal' => 'Date must be today or later.',
        'preferred_time_slot.required' => 'Please select a time slot.',
        'preferred_time_slot.in' => 'Invalid time slot selected.',
        'preferred_time.date_format' => 'Invalid time format (use HH:MM).',
        'agree_terms.required' => 'You must accept the terms and conditions.',
        'repair_service_id.exists' => 'Invalid repair service selected.'
    ];

    // Perform validation
    $validator = Validator::make($request->all(), $rules, $messages);

    // Additional custom validation
    $validator->after(function ($validator) use ($request) {
        if (empty($request->repair_service_id) && empty(trim($request->custom_repair_description))) {
            $validator->errors()->add(
                'service_selection',
                'You must either select a repair service or provide a custom repair description.'
            );
        }
    });

    // If validation fails
    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput()
            ->with([
                'error_type' => 'validation',
                'error_title' => 'Please fix these errors',
                'error_list' => $validator->errors()->all()
            ]);
    }

    try {
        DB::beginTransaction();

        // Process selected service
        $service = null;
        $totalPrice = 0;
        $estimatedTime = 0;

        if ($request->repair_service_id) {
            $service = RepairService::find($request->repair_service_id);
            if (!$service) {
                throw new \Exception('The selected repair service was not found.');
            }
            $totalPrice = $service->admin_price;
            $estimatedTime = $service->estimated_time_hours;
        }

        // Create booking
       // Create booking
$booking = CustomerBooking::create([
    'booking_number' => CustomerBooking::generateBookingNumber(),
    'customer_name' => $request->customer_name,
    'customer_email' => $request->customer_email,
    'customer_phone' => $request->customer_phone,
    'customer_address' => $request->customer_address,
    'customer_city' => $request->customer_city,
    'device_category_id' => $request->device_category_id,
    'device_type_id' => $request->device_type_id,
    'device_brand' => $request->device_brand,
    'device_model' => $request->device_model,
    'device_condition' => $request->device_condition,
    'repair_service_id' => $request->repair_service_id,
    'custom_repair_description' => $request->custom_repair_description,
    'device_issue_description' => 'Customer did not specify any issues.', // ✅ Hardcoded message
    'preferred_date' => $request->preferred_date,
    'preferred_time_slot' => $request->preferred_time_slot,
    'preferred_time' => $request->preferred_time,
    'admin_quoted_price' => $totalPrice > 0 ? $totalPrice : null,
    'status' => 'pending',
    'priority' => 'normal',
    'booking_date' => now(),
    'estimated_completion_time' => $this->calculateEstimatedCompletion(
        $request->preferred_date,
        $estimatedTime
    )
]);


        DB::commit();
        // Send email
        Mail::to($booking->customer_email)->send(new BookingConfirmationMail($booking));



        return redirect()
            ->route('success', $booking->booking_number)
            ->with('success', 'Your booking #'.$booking->booking_number.' has been submitted successfully!');

    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Booking Error', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()
            ->back()
            ->withInput()
            ->with([
                'error_type' => 'system',
                'error_title' => 'Booking Failed',
                'error_message' => 'Error: ' . $e->getMessage()
            ]);
    }
}
  public function success($bookingNumber)
{
    $booking = CustomerBooking::with(['deviceCategory', 'deviceType'])
        ->where('booking_number', $bookingNumber)
        ->firstOrFail();

    // Get the selected service as a collection (even if null)
    $selectedServices = collect();

    if ($booking->repair_service_id) {
        $service = RepairService::find($booking->repair_service_id);
        if ($service) {
            $selectedServices->push($service);
        }
    }

    return view('frontend.pages.success', compact('booking', 'selectedServices'));
}

    /**
     * AJAX endpoint to get device types for a category (WITH CACHING)
     */
    public function getDeviceTypes($category_id)
    {
        try {
            $cacheKey = "device_types_category_{$category_id}";

            $types = Cache::remember($cacheKey, 3600, function() use ($category_id) {
                return DeviceType::where('category_id', $category_id)
                    ->where('status', 'active')
                    ->orderBy('display_order')
                    ->get(['id', 'name', 'brand', 'model', 'image']);
            });

            return response()->json($types);
        } catch (\Exception $e) {
            Log::error('Failed to fetch device types', [
                'category_id' => $category_id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to load device types'], 500);
        }
    }

    /**
     * AJAX endpoint to get repair services for a device type (WITH CACHING AND IMAGES)
     */
    public function getRepairServices($type_id)
    {
        try {
            $cacheKey = "repair_services_type_{$type_id}";

            $services = Cache::remember($cacheKey, 1800, function() use ($type_id) {
                return RepairService::where('device_type_id', $type_id)
                    ->where('status', 'active')
                    ->orderBy('display_order')
                    ->get(['id', 'service_name', 'description', 'estimated_time_hours', 'warranty_days', 'image']);
            });

            return response()->json($services);
        } catch (\Exception $e) {
            Log::error('Failed to fetch repair services', [
                'type_id' => $type_id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to load services'], 500);
        }
    }

    public function checkStatus($booking_number)
{
    $repair = CustomerBooking::where('booking_number', $booking_number)->first();

    if (!$repair) {
        return response()->json([
            'error' => 'No repair found with this booking number.'
        ], 404);
    }

    return response()->json($repair);
}
    /**
     * Clear cache when needed (for admin panel)
     */
    public function clearCache()
    {
        Cache::forget('device_categories_active');

        // Clear device types cache
        $categories = DeviceCategory::pluck('id');
        foreach ($categories as $categoryId) {
            Cache::forget("device_types_category_{$categoryId}");
        }

        // Clear repair services cache
        $deviceTypes = DeviceType::pluck('id');
        foreach ($deviceTypes as $typeId) {
            Cache::forget("repair_services_type_{$typeId}");
        }

        return response()->json(['message' => 'Cache cleared successfully']);
    }

    // ... (rest of your existing methods remain the same)

    private function calculateEstimatedCompletion($preferredDate, $estimatedHours)
    {
        try {
            $startDate = Carbon::parse($preferredDate);
            $hoursToAdd = (int) $estimatedHours;

            if ($hoursToAdd == 0) {
                return $startDate->addWeekdays(3)->setTime(17, 0, 0);
            }

            if ($hoursToAdd > 8) {
                $daysToAdd = ceil($hoursToAdd / 8);
                $completionDate = $startDate->addWeekdays($daysToAdd);
            } else {
                $completionDate = $startDate->addHours($hoursToAdd);
            }

            return $completionDate->setTime(17, 0, 0);
        } catch (\Exception $e) {
            Log::warning('Failed to calculate completion time', ['error' => $e->getMessage()]);
            return Carbon::parse($preferredDate)->addWeekdays(3)->setTime(17, 0, 0);
        }
    }
public function submitContactForm(Request $request)
{
    try {
        // Validate the contact form
        $request->validate([
            'inquiry_type' => 'required|string|max:100',
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'subject'      => 'nullable|string|max:255',
            'message'      => 'required|string|max:2000'
        ]);

        // Save contact
        ContactSubmission::create([
            'inquiry_type' => $request->inquiry_type,
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'subject'      => $request->subject,
            'message'      => $request->message
        ]);

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    } catch (\Exception $e) {
        // DEBUG: Show the real error
        dd('Error:', $e->getMessage());
    }
}



}
