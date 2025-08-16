<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiscountBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class DiscountBannerController extends Controller
{
    public function index()
    {
        $banners = DiscountBanner::orderBy('display_order')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

  public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:10048',
                'dimensions:min_width=600,min_height=300' // Example dimensions
            ],
            'is_active' => 'sometimes|boolean',
            'is_hero_slide' => 'sometimes|boolean',
            'display_order' => 'required|integer|min:0',
            'start_date' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->end_date && $value > $request->end_date) {
                        $fail('The start date must be before or equal to the end date.');
                    }
                }
            ],
            'end_date' => 'nullable|date'
        ]);

        // Handle file upload with unique filename
        $imageName = time().'_'.Str::slug($validated['title']).'.'.$request->image->extension();
        $imagePath = $request->file('image')->storeAs('banners', $imageName, 'public');

        // Create banner with transaction for data integrity
        DB::beginTransaction();

        $banner = DiscountBanner::create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'image_path' => $imagePath,
            'is_active' => $validated['is_active'] ?? false,
            'is_hero_slide' => $validated['is_hero_slide'] ?? false,
            'display_order' => $validated['display_order'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'created_by' => auth()->id() // Track who created this
        ]);

        if (!$banner) {
            throw new \Exception('Failed to create banner record');
        }

        DB::commit();

        return redirect()
            ->route('banners.index')
            ->with([
                'success' => 'Banner created successfully',
                'banner_id' => $banner->id // Optional: if you want to reference it
            ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput()
            ->with('error', 'There were validation errors. Please correct them and try again.');

    } catch (\Exception $e) {
        DB::rollBack();

        // Delete the uploaded file if it exists
        if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        Log::error('Banner creation failed: '.$e->getMessage(), [
            'exception' => $e,
            'request' => $request->all(),
            'user_id' => auth()->id()
        ]);

        return redirect()
            ->back()
            ->with('error', 'Failed to create banner: '.$e->getMessage())
            ->withInput();
    }
}
    public function edit(DiscountBanner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

   public function update(Request $request, DiscountBanner $banner)
{
    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
                'dimensions:min_width=600,min_height=300'
            ],
            'is_active' => 'sometimes|boolean',
            'is_hero_slide' => 'sometimes|boolean',
            'display_order' => 'required|integer|min:0',
            'start_date' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->end_date && $value > $request->end_date) {
                        $fail('The start date must be before or equal to the end date.');
                    }
                }
            ],
            'end_date' => 'nullable|date'
        ]);

        // Begin database transaction
        DB::beginTransaction();

        $data = [
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'is_active' => $validated['is_active'] ?? false,
            'is_hero_slide' => $validated['is_hero_slide'] ?? false,
            'display_order' => $validated['display_order'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'updated_by' => auth()->id() // Track who updated this
        ];

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Generate unique filename
            $imageName = time().'_'.Str::slug($validated['title']).'.'.$request->image->extension();
            $imagePath = $request->file('image')->storeAs('banners', $imageName, 'public');

            // Store new image path
            $data['image_path'] = $imagePath;

            // Delete old image after successful upload
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
        }

        // Update the banner
        $updated = $banner->update($data);

        if (!$updated) {
            throw new \Exception('Failed to update banner record');
        }

        DB::commit();

        return redirect()
            ->route('banners.index')
            ->with([
                'success' => 'Banner updated successfully',
                'updated_id' => $banner->id
            ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()
            ->back()
            ->withErrors($e->validator)
            ->withInput()
            ->with('error', 'There were validation errors. Please correct them and try again.');

    } catch (\Exception $e) {
        DB::rollBack();

        // Delete the new uploaded file if it exists and update failed
        if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        Log::error('Banner update failed: '.$e->getMessage(), [
            'exception' => $e,
            'banner_id' => $banner->id,
            'request' => $request->except('image'), // Don't log file content
            'user_id' => auth()->id()
        ]);

        return redirect()
            ->back()
            ->with('error', 'Failed to update banner: '.$e->getMessage())
            ->withInput();
    }
}

   public function destroy(DiscountBanner $banner)
{
    try {
        // Get the image path before deleting the banner
        $imagePath = $banner->image_path;

        // Delete the banner record
        $banner->delete();

        // Delete the associated image file
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('banners.index')
            ->with('success', 'Banner deleted successfully');

    } catch (\Exception $e) {
        Log::error('Banner deletion failed: '.$e->getMessage(), [
            'exception' => $e,
            'banner_id' => $banner->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->back()
            ->with('error', 'Failed to delete banner: '.$e->getMessage());
    }
}
}
