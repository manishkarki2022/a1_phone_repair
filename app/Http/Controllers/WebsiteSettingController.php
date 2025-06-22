<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    /**
     * Display the website settings form
     */
    public function index()
    {
        $settings = WebsiteSetting::getSettings();
        return view('admin.websettings.edit', compact('settings'));
    }

    /**
     * Update the website settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'tertiary_color' => 'nullable|string|max:7',
            'default_language' => 'required|string|max:5',
            'maintenance_mode' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $settings = WebsiteSetting::getSettings();
        $data = $request->except(['logo', 'favicon', 'og_image']);

        // Handle file uploads
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo_path && Storage::exists('public/' . $settings->logo_path)) {
                Storage::delete('public/' . $settings->logo_path);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo_path'] = $logoPath;
        }

        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($settings->favicon_path && Storage::exists('public/' . $settings->favicon_path)) {
                Storage::delete('public/' . $settings->favicon_path);
            }
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            $data['favicon_path'] = $faviconPath;
        }

        if ($request->hasFile('og_image')) {
            // Delete old og_image if exists
            if ($settings->og_image_path && Storage::exists('public/' . $settings->og_image_path)) {
                Storage::delete('public/' . $settings->og_image_path);
            }
            $ogImagePath = $request->file('og_image')->store('og-images', 'public');
            $data['og_image_path'] = $ogImagePath;
        }

        // Convert maintenance_mode checkbox to boolean
        $data['maintenance_mode'] = $request->has('maintenance_mode');

        $settings->update($data);

        return redirect()->back()->with('success', 'Website settings updated successfully!');
    }
}
