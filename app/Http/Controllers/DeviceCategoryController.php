<?php

namespace App\Http\Controllers;

use App\Models\DeviceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeviceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = DeviceCategory::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->inactive();
            }
        }

        // Order by display order by default
        $categories = $query->byDisplayOrder()
                           ->paginate(10)
                           ->withQueryString();

        return view('admin.device-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $statusOptions = DeviceCategory::getStatusOptions();
        return view('admin.device-categories.create', compact('statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:device_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'display_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            // Handle icon file upload
            if ($request->hasFile('icon_file')) {
                $iconPath = $request->file('icon_file')->store('device-categories', 'public');
                $validated['icon'] = $iconPath;
            }

            DeviceCategory::create($validated);

            return redirect()
                ->route('device-categories.index')
                ->with('success', 'Device category created successfully!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create device category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param DeviceCategory $deviceCategory
     * @return View
     */
    public function show(DeviceCategory $deviceCategory): View
    {
        // Load device types count
        $deviceCategory->loadCount('deviceTypes');

        return view('admin.device-categories.show', compact('deviceCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DeviceCategory $deviceCategory
     * @return View
     */
    public function edit(DeviceCategory $deviceCategory): View
    {
        $statusOptions = DeviceCategory::getStatusOptions();
        return view('admin.device-categories.edit', compact('deviceCategory', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DeviceCategory $deviceCategory
     * @return RedirectResponse
     */
    public function update(Request $request, DeviceCategory $deviceCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:device_categories,name,' . $deviceCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'display_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            // Handle icon file upload
            if ($request->hasFile('icon_file')) {
                // Delete old icon file if it exists and is not a Font Awesome class
                if ($deviceCategory->icon &&
                    !str_starts_with($deviceCategory->icon, 'fa-') &&
                    !str_starts_with($deviceCategory->icon, 'fas ')) {
                    Storage::disk('public')->delete($deviceCategory->icon);
                }

                $iconPath = $request->file('icon_file')->store('device-categories', 'public');
                $validated['icon'] = $iconPath;
            }

            $deviceCategory->update($validated);

            return redirect()
                ->route('device-categories.index')
                ->with('success', 'Device category updated successfully!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update device category. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeviceCategory $deviceCategory
     * @return RedirectResponse
     */
    public function destroy(DeviceCategory $deviceCategory): RedirectResponse
    {
        try {
            // Check if category has device types
            if ($deviceCategory->deviceTypes()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot delete category that has device types associated with it.');
            }

            // Delete icon file if it exists and is not a Font Awesome class
            if ($deviceCategory->icon &&
                !str_starts_with($deviceCategory->icon, 'fa-') &&
                !str_starts_with($deviceCategory->icon, 'fas ')) {
                Storage::disk('public')->delete($deviceCategory->icon);
            }

            $deviceCategory->delete();

            return redirect()
                ->route('device-categories.index')
                ->with('success', 'Device category deleted successfully!');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete device category. Please try again.');
        }
    }

    /**
     * Toggle the status of the specified resource.
     *
     * @param DeviceCategory $deviceCategory
     * @return RedirectResponse
     */
    public function toggleStatus(DeviceCategory $deviceCategory): RedirectResponse
    {
        try {
            $newStatus = $deviceCategory->status === 'active' ? 'inactive' : 'active';
            $deviceCategory->update(['status' => $newStatus]);

            $message = "Device category " . ($newStatus === 'active' ? 'activated' : 'deactivated') . " successfully!";

            return redirect()
                ->back()
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update status. Please try again.');
        }
    }

    /**
     * Update display order via AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:device_categories,id',
            'items.*.display_order' => 'required|integer|min:0',
        ]);

        try {
            foreach ($request->items as $item) {
                DeviceCategory::where('id', $item['id'])
                             ->update(['display_order' => $item['display_order']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Display order updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update display order.'
            ], 500);
        }
    }

    /**
     * Get categories for API/AJAX requests.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(Request $request)
    {
        $query = DeviceCategory::active()->byDisplayOrder();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $categories = $query->get(['id', 'name', 'icon']);

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Bulk actions for multiple categories.
     *
     * @param Request $request
     * @return RedirectResponse
     */
   public function bulkDelete(Request $request): RedirectResponse
{
    $request->validate([
        'categories' => 'required|array|min:1',
        'categories.*' => 'exists:device_categories,id',
    ]);

    try {
        $categories = DeviceCategory::whereIn('id', $request->categories)
                        ->withCount('deviceTypes')
                        ->get();

        // Check if any category has device types
        $categoriesWithTypes = $categories->where('device_types_count', '>', 0);

        if ($categoriesWithTypes->count() > 0) {
            return back()->with('error',
                'Cannot delete categories that have device types associated with them.');
        }

        DeviceCategory::whereIn('id', $request->categories)->delete();

        return back()->with('success', 'Selected categories deleted successfully!');

    } catch (\Exception $e) {
        return back()->with('error', 'Failed to perform bulk delete. Please try again.');
    }
}

}
