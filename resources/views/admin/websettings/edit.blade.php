@extends('admin.layouts.app')

@section('title', 'Website Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Website Settings</h3>
                </div>



                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <!-- Basic Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Basic Information</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website_name" class="form-label">Website Name *</label>
                                    <input type="text" class="form-control" id="website_name" name="website_name"
                                           value="{{ old('website_name', $settings->website_name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slogan" class="form-label">Slogan</label>
                                    <input type="text" class="form-control" id="slogan" name="slogan"
                                           value="{{ old('slogan', $settings->slogan) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                    @if($settings->logo_path)
                                        <small class="text-muted">Current: <a href="{{ Storage::url($settings->logo_path) }}" target="_blank">View Logo</a></small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="favicon" class="form-label">Favicon</label>
                                    <input type="file" class="form-control" id="favicon" name="favicon" accept=".ico,.png">
                                    @if($settings->favicon_path)
                                        <small class="text-muted">Current: <a href="{{ Storage::url($settings->favicon_path) }}" target="_blank">View Favicon</a></small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="default_language" class="form-label">Default Language *</label>
                                    <select class="form-control" id="default_language" name="default_language" required>
                                        <option value="en" {{ old('default_language', $settings->default_language) == 'en' ? 'selected' : '' }}>English</option>
                                        <option value="es" {{ old('default_language', $settings->default_language) == 'es' ? 'selected' : '' }}>Spanish</option>
                                        <option value="fr" {{ old('default_language', $settings->default_language) == 'fr' ? 'selected' : '' }}>French</option>
                                        <option value="de" {{ old('default_language', $settings->default_language) == 'de' ? 'selected' : '' }}>German</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Contact Information</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email', $settings->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email"
                                           value="{{ old('contact_email', $settings->contact_email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{ old('phone', $settings->phone) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                           value="{{ old('mobile', $settings->mobile) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2">{{ old('address', $settings->address) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city"
                                           value="{{ old('city', $settings->city) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" name="state"
                                           value="{{ old('state', $settings->state) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                           value="{{ old('country', $settings->country) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="postal_code" class="form-label">Postal Code</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                                           value="{{ old('postal_code', $settings->postal_code) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Business Hours Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Business Hours</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="opening_hours" class="form-label">Opening Hours</label>
                                    <textarea class="form-control" id="opening_hours" name="opening_hours" rows="3"
                                              placeholder="Mon-Fri: 9:00 AM - 6:00 PM">{{ old('opening_hours', $settings->opening_hours) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="special_hours" class="form-label">Special Hours</label>
                                    <textarea class="form-control" id="special_hours" name="special_hours" rows="3"
                                              placeholder="Holiday hours, etc.">{{ old('special_hours', $settings->special_hours) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Design Settings Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Design Settings</h5>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="primary_color" class="form-label">Primary Color</label>
                                    <input type="color" class="form-control form-control-color" id="primary_color" name="primary_color"
                                           value="{{ old('primary_color', $settings->primary_color) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="secondary_color" class="form-label">Secondary Color</label>
                                    <input type="color" class="form-control form-control-color" id="secondary_color" name="secondary_color"
                                           value="{{ old('secondary_color', $settings->secondary_color) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="tertiary_color" class="form-label">Tertiary Color</label>
                                    <input type="color" class="form-control form-control-color" id="tertiary_color" name="tertiary_color"
                                           value="{{ old('tertiary_color', $settings->tertiary_color) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="font_family" class="form-label">Font Family</label>
                                    <select class="form-control" id="font_family" name="font_family">
                                        <option value="">Default</option>
                                        <option value="Arial, sans-serif" {{ old('font_family', $settings->font_family) == 'Arial, sans-serif' ? 'selected' : '' }}>Arial</option>
                                        <option value="Georgia, serif" {{ old('font_family', $settings->font_family) == 'Georgia, serif' ? 'selected' : '' }}>Georgia</option>
                                        <option value="'Times New Roman', serif" {{ old('font_family', $settings->font_family) == "'Times New Roman', serif" ? 'selected' : '' }}>Times New Roman</option>
                                        <option value="Helvetica, sans-serif" {{ old('font_family', $settings->font_family) == 'Helvetica, sans-serif' ? 'selected' : '' }}>Helvetica</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Social Media</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="facebook_url" class="form-label">Facebook URL</label>
                                    <input type="url" class="form-control" id="facebook_url" name="facebook_url"
                                           value="{{ old('facebook_url', $settings->facebook_url) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="twitter_url" class="form-label">Twitter URL</label>
                                    <input type="url" class="form-control" id="twitter_url" name="twitter_url"
                                           value="{{ old('twitter_url', $settings->twitter_url) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instagram_url" class="form-label">Instagram URL</label>
                                    <input type="url" class="form-control" id="instagram_url" name="instagram_url"
                                           value="{{ old('instagram_url', $settings->instagram_url) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                                    <input type="url" class="form-control" id="linkedin_url" name="linkedin_url"
                                           value="{{ old('linkedin_url', $settings->linkedin_url) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="youtube_url" class="form-label">YouTube URL</label>
                                    <input type="url" class="form-control" id="youtube_url" name="youtube_url"
                                           value="{{ old('youtube_url', $settings->youtube_url) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pinterest_url" class="form-label">Pinterest URL</label>
                                    <input type="url" class="form-control" id="pinterest_url" name="pinterest_url"
                                           value="{{ old('pinterest_url', $settings->pinterest_url) }}">
                                </div>
                            </div>
                        </div>

                        <!-- SEO Settings Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">SEO Settings</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <textarea class="form-control" id="meta_title" name="meta_title" rows="2">{{ old('meta_title', $settings->meta_title) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $settings->meta_description) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="2"
                                              placeholder="keyword1, keyword2, keyword3">{{ old('meta_keywords', $settings->meta_keywords) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="og_image" class="form-label">Open Graph Image</label>
                                    <input type="file" class="form-control" id="og_image" name="og_image" accept="image/*">
                                    @if($settings->og_image_path)
                                        <small class="text-muted">Current: <a href="{{ Storage::url($settings->og_image_path) }}" target="_blank">View Image</a></small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                                    <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id"
                                           value="{{ old('google_analytics_id', $settings->google_analytics_id) }}" placeholder="G-XXXXXXXXXX">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="google_tag_manager_id" class="form-label">Google Tag Manager ID</label>
                                    <input type="text" class="form-control" id="google_tag_manager_id" name="google_tag_manager_id"
                                           value="{{ old('google_tag_manager_id', $settings->google_tag_manager_id) }}" placeholder="GTM-XXXXXXX">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="custom_head_scripts" class="form-label">Custom Head Scripts</label>
                                    <textarea class="form-control" id="custom_head_scripts" name="custom_head_scripts" rows="3"
                                              placeholder="<script>...</script>">{{ old('custom_head_scripts', $settings->custom_head_scripts) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="custom_footer_scripts" class="form-label">Custom Footer Scripts</label>
                                    <textarea class="form-control" id="custom_footer_scripts" name="custom_footer_scripts" rows="3"
                                              placeholder="<script>...</script>">{{ old('custom_footer_scripts', $settings->custom_footer_scripts) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Maintenance Mode Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2">Maintenance Mode</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="maintenance_mode" name="maintenance_mode"
                                               {{ old('maintenance_mode', $settings->maintenance_mode) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">
                                            Enable Maintenance Mode
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="maintenance_message" class="form-label">Maintenance Message</label>
                                    <textarea class="form-control" id="maintenance_message" name="maintenance_message" rows="3"
                                              placeholder="We are currently under maintenance. Please check back later.">{{ old('maintenance_message', $settings->maintenance_message) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Settings
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


