<?php

namespace App\Http\Controllers;

use App\Models\RepairService;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RepairServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Use the comprehensive filter scope from the model
        $repairServices = RepairService::with('deviceType')
            ->filter($request)
            ->orderBy('display_order', 'asc')
            ->paginate(10);

        // Keep query parameters in pagination links
        $repairServices->appends($request->query());

        // Get statistics for the view
        $statistics = [
            'total' => RepairService::count(),
            'active' => RepairService::where('status', 'active')->count(),
            'popular' => RepairService::where('is_popular', true)->count(),
            'device_types' =>DeviceType::where('status', 'active')->count(),
        ];

        return view('admin.repair-services.index', compact('repairServices', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $deviceTypes = DeviceType::where('status', 'active')->get();
        return view('admin.repair-services.create', compact('deviceTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'service_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'estimated_time_hours' => 'required|integer|min:1',
            'admin_price' => 'required|numeric|min:0',
            'admin_cost' => 'nullable|numeric|min:0',
            'warranty_days' => 'required|integer|min:0|max:365',
            'is_popular' => 'boolean',
            'display_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('repair-services', 'public');
        }

        RepairService::create($data);

        return redirect()->route('repair-services.index')
            ->with('success', 'Repair service created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairService $repairService)
    {
        $deviceTypes = DeviceType::where('status', 'active')->get();
        return view('admin.repair-services.edit', compact('repairService', 'deviceTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepairService $repairService)
    {
        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'service_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'estimated_time_hours' => 'required|integer|min:1',
            'admin_price' => 'required|numeric|min:0',
            'admin_cost' => 'nullable|numeric|min:0',
            'warranty_days' => 'required|integer|min:0|max:365',
            'is_popular' => 'boolean',
            'display_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->all();

        // Handle image replacement
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($repairService->image && Storage::disk('public')->exists($repairService->image)) {
                Storage::disk('public')->delete($repairService->image);
            }

            $data['image'] = $request->file('image')->store('repair-services', 'public');
        }

        $repairService->update($data);

        return redirect()->route('repair-services.index')
            ->with('success', 'Repair service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairService $repairService)
    {
        try {
            // Delete image if exists
            if ($repairService->image && Storage::disk('public')->exists($repairService->image)) {
                Storage::disk('public')->delete($repairService->image);
            }

            $repairService->delete();

            return redirect()->route('repair-services.index')
                ->with('success', 'Repair service deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('repair-services.index')
                ->with('error', 'Error deleting repair service. It may be in use.');
        }
    }
}
