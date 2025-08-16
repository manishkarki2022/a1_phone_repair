<?php

namespace App\Http\Controllers;

use App\Models\DeviceType;
use App\Models\DeviceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DeviceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $query = DeviceType::with('category')->orderedByDisplay();

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Search by name, brand, model, category
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('brand', 'like', "%{$searchTerm}%")
              ->orWhere('model', 'like', "%{$searchTerm}%")
              ->orWhereHas('category', function ($q2) use ($searchTerm) {
                  $q2->where('name', 'like', "%{$searchTerm}%");
              });
        });
    }

    $deviceTypes = $query->paginate(10)->appends($request->all());

    return view('admin.device-types.index', compact('deviceTypes'));
}

public function getBrands(Request $request)
{
    $search = $request->get('q');

    $query = DeviceType::select('brand')
        ->whereNotNull('brand')
        ->where('brand', '!=', '')
        ->distinct();

    if ($search) {
        $query->where('brand', 'LIKE', "%{$search}%");
    }

    $brands = $query->orderBy('brand')
        ->limit(20)
        ->pluck('brand')
        ->map(function ($brand) {
            return [
                'id' => $brand,
                'text' => $brand
            ];
        });

    return response()->json([
        'results' => $brands
    ]);
}

/**
 * Get models for Select2 AJAX
 */
public function getModels(Request $request)
{
    $search = $request->get('q');
    $brand = $request->get('brand');

    $query = DeviceType::select('model')
        ->whereNotNull('model')
        ->where('model', '!=', '')
        ->distinct();

    // Filter by brand if provided
    if ($brand) {
        $query->where('brand', $brand);
    }

    if ($search) {
        $query->where('model', 'LIKE', "%{$search}%");
    }

    $models = $query->orderBy('model')
        ->limit(20)
        ->pluck('model')
        ->map(function ($model) {
            return [
                'id' => $model,
                'text' => $model
            ];
        });

    return response()->json([
        'results' => $models
    ]);
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DeviceCategory::active()->orderBy('name')->get();
        return view('admin.device-types.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:device_categories,id',
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('device-types', 'public');
        }

        DeviceType::create($validated);

        return redirect()->route('device-types.index')
            ->with('success', 'Device type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeviceType $deviceType)
    {
        $categories = DeviceCategory::active()->orderBy('name')->get();
        return view('admin.device-types.edit', compact('deviceType', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeviceType $deviceType)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:device_categories,id',
            'name' => 'required|string|max:100',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer',
            'status' => 'required|in:active,inactive'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($deviceType->image) {
                Storage::disk('public')->delete($deviceType->image);
            }
            $validated['image'] = $request->file('image')->store('device-types', 'public');
        }

        $deviceType->update($validated);

        return redirect()->route('device-types.index')
            ->with('success', 'Device type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeviceType $deviceType)
    {
        // Delete image if exists
        if ($deviceType->image) {
            Storage::disk('public')->delete($deviceType->image);
        }

        $deviceType->delete();

        return redirect()->route('device-types.index')
            ->with('success', 'Device type deleted successfully.');
    }
}
