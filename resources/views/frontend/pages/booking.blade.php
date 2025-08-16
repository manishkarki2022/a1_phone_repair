@extends('frontend.layout.app')

@section('title', 'Booking')

@section('content')
<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-black text-center py-4" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <h3 class="mb-1"><i class="fas fa-tools me-2"></i>Device Repair Booking</h3>
                    <p class="mb-0 opacity-75">Get your device fixed by our certified technicians</p>
                </div>

                <div class="card-body p-4">
                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please correct the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

{{-- Display validation errors --}}
@if(session('error_type') == 'validation')
    <div class="alert alert-danger">
        <h5>{{ session('error_title') }}</h5>
        <ul>
            @foreach(session('error_list') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Display system errors --}}
@if(session('error_type') == 'system')
    <div class="alert alert-danger">
        <h5>{{ session('error_title') }}</h5>
        <p>{{ session('error_message') }}</p>
    </div>
@endif

{{-- Display success message --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

                    <!-- Enhanced Progress Bar with Step Labels -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-center step-indicator" data-step="1">
                                <div class="step-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <small class="text-muted fw-semibold">Customer Info</small>
                            </div>
                            <div class="text-center step-indicator" data-step="2">
                                <div class="step-circle bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <small class="text-muted fw-semibold">Device Info</small>
                            </div>
                            <div class="text-center step-indicator" data-step="3">
                                <div class="step-circle bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-wrench"></i>
                                </div>
                                <small class="text-muted fw-semibold">Service</small>
                            </div>
                            <div class="text-center step-indicator" data-step="4">
                                <div class="step-circle bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width: 40px; height: 40px;">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <small class="text-muted fw-semibold">Schedule</small>
                            </div>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                 role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <!-- Alert Container for Messages -->
                    <div id="alertContainer"></div>

                    <!-- REGULAR LARAVEL FORM (No AJAX) -->
                    <form id="bookingForm" method="POST" action="{{ route('booking.store') }}">
                        @csrf

                        <!-- Step 1: Customer Information -->
                        <div class="step step-1 active">
                            <div class="text-center mb-4">
                                <h4 class="text-primary mb-2">👋 Let's Get Started</h4>
                                <p class="text-muted">Tell us a bit about yourself so we can contact you</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="customer_name" class="form-label fw-semibold">
                                        <i class="fas fa-user me-2 text-primary"></i>Full Name *
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('customer_name') is-invalid @enderror"
                                           id="customer_name" name="customer_name" value="{{ old('customer_name') }}"
                                           placeholder="Enter your full name" required>
                                    @error('customer_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope me-2 text-primary"></i>Email Address *
                                    </label>
                                    <input type="email" class="form-control form-control-lg @error('customer_email') is-invalid @enderror"
                                           id="customer_email" name="customer_email" value="{{ old('customer_email') }}"
                                           placeholder="your@email.com" required>
                                    @error('customer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_phone" class="form-label fw-semibold">
                                        <i class="fas fa-phone me-2 text-primary"></i>Phone Number *
                                    </label>
                                    <input type="tel" class="form-control form-control-lg @error('customer_phone') is-invalid @enderror"
                                           id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}"
                                           placeholder="+1 (555) 123-4567" required>
                                    @error('customer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="customer_city" class="form-label fw-semibold">
                                        <i class="fas fa-city me-2 text-primary"></i>City
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('customer_city') is-invalid @enderror"
                                           id="customer_city" name="customer_city" value="{{ old('customer_city') }}"
                                           placeholder="Your city">
                                    @error('customer_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="customer_address" class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i>Complete Address
                                    </label>
                                    <textarea class="form-control form-control-lg @error('customer_address') is-invalid @enderror"
                                              id="customer_address" name="customer_address" rows="3"
                                              placeholder="Street address, apartment, city, postal code">{{ old('customer_address') }}</textarea>
                                    @error('customer_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary btn-lg px-5 next-step">
                                    Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Device Information -->
                        <div class="step step-2">
                            <div class="text-center mb-4">
                                <h4 class="text-primary mb-2">📱 Tell Us About Your Device</h4>
                                <p class="text-muted">Help us identify your device so we can provide the best service options</p>
                            </div>

                            <!-- Device Category Selection -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="fas fa-th-large me-2 text-primary"></i>What type of device do you have? *
                                </label>
                                <div class="row g-3" id="categoryCards">
                                    @foreach($categories as $category)
                                    <div class="col-md-4">
                                        <div class="category-card border rounded-3 p-4 text-center h-100 cursor-pointer
                                                    {{ old('device_category_id') == $category->id ? 'border-primary bg-primary text-white' : '' }}"
                                             data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}">
                                            <i class="{{ $category->icon }} fa-3x text-primary mb-3"></i>
                                            <h6 class="fw-semibold mb-2">{{ $category->name }}</h6>
                                            <small class="text-muted">{{ $category->description }}</small>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="device_category_id" name="device_category_id" value="{{ old('device_category_id') }}" required>
                                @error('device_category_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                <div class="text-danger mt-2" id="category-error"></div>
                            </div>

                            <!-- Device Type Selection -->
                            <div class="mb-4 device-type-section" style="display: {{ old('device_category_id') ? 'block' : 'none' }};">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="fas fa-mobile-alt me-2 text-primary"></i>Select Your Device Model *
                                </label>
                                <div class="row g-3" id="deviceTypeCards">
                                    <!-- Device types will be loaded here -->
                                </div>
                                <input type="hidden" id="device_type_id" name="device_type_id" value="{{ old('device_type_id') }}" required>
                                @error('device_type_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                <div class="text-danger mt-2" id="device-type-error"></div>
                            </div>

                            <!-- Brand and Model Information -->
                            <div class="row g-4 brand-model-section" style="display: {{ old('device_type_id') ? 'block' : 'none' }};">
                                <div class="col-md-6">
                                    <label for="device_brand" class="form-label fw-semibold">
                                        <i class="fas fa-tag me-2 text-primary"></i><span id="brandLabel">Brand</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('device_brand') is-invalid @enderror"
                                           id="device_brand" name="device_brand" value="{{ old('device_brand') }}"
                                           placeholder="e.g., Apple, Samsung, Google">
                                    @error('device_brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="device_model" class="form-label fw-semibold">
                                        <i class="fas fa-barcode me-2 text-primary"></i><span id="modelLabel">Model</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('device_model') is-invalid @enderror"
                                           id="device_model" name="device_model" value="{{ old('device_model') }}"
                                           placeholder="e.g., iPhone 14 Pro, Galaxy S23">
                                    @error('device_model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Device Condition -->
                            <div class="mb-4 condition-section" style="display: {{ old('device_type_id') ? 'block' : 'none' }};">
                                <label for="device_condition" class="form-label fw-semibold">
                                    <i class="fas fa-info-circle me-2 text-info"></i>Overall Device Condition
                                </label>
                                <div class="row g-3 mb-3">
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-success w-100 condition-btn
                                                {{ old('device_condition') == 'Excellent - Like new, no visible damage' ? 'btn-success' : '' }}"
                                                data-condition="Excellent - Like new, no visible damage">
                                            <i class="fas fa-star mb-1"></i><br>
                                            <small>Excellent</small>
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-primary w-100 condition-btn
                                                {{ old('device_condition') == 'Good - Minor wear, fully functional' ? 'btn-primary' : '' }}"
                                                data-condition="Good - Minor wear, fully functional">
                                            <i class="fas fa-thumbs-up mb-1"></i><br>
                                            <small>Good</small>
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-warning w-100 condition-btn
                                                {{ old('device_condition') == 'Fair - Some damage but mostly working' ? 'btn-warning' : '' }}"
                                                data-condition="Fair - Some damage but mostly working">
                                            <i class="fas fa-exclamation mb-1"></i><br>
                                            <small>Fair</small>
                                        </button>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <button type="button" class="btn btn-outline-danger w-100 condition-btn
                                                {{ old('device_condition') == 'Poor - Significant damage, major issues' ? 'btn-danger' : '' }}"
                                                data-condition="Poor - Significant damage, major issues">
                                            <i class="fas fa-times mb-1"></i><br>
                                            <small>Poor</small>
                                        </button>
                                    </div>
                                </div>
                                <textarea class="form-control @error('device_condition') is-invalid @enderror"
                                          id="device_condition" name="device_condition" rows="2"
                                          placeholder="Additional details about condition (scratches, dents, etc.)">{{ old('device_condition') }}</textarea>
                                @error('device_condition')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary btn-lg px-4 prev-step">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary btn-lg px-5 next-step">
                                    Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Repair Service -->
                        <div class="step step-3">
                            <div class="text-center mb-4">
                                <h4 class="text-primary mb-2">🔧 Choose Your Service</h4>
                                <p class="text-muted">Select the repair service and describe what needs to be fixed</p>
                            </div>

                            <!-- Service Selection -->
                            <div class="mb-4 service-selection-section" style="display: {{ old('device_type_id') ? 'block' : 'none' }};">
                                <label class="form-label fw-semibold mb-3">
                                    <i class="fas fa-tools me-2 text-primary"></i>Available Services for Your <span id="selectedDeviceName">Device</span>
                                </label>
                                <p class="text-muted mb-3"><i class="fas fa-info-circle me-1"></i>Please select one service that best matches your repair needs</p>
                                <div class="row g-3" id="serviceCards">
                                    <!-- Services will be loaded here -->
                                </div>
                                <input type="hidden" id="repair_service_id" name="repair_service_id" value="{{ old('repair_service_id') }}">
                                @error('repair_service_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                <div class="text-danger mt-2" id="service-error"></div>
                            </div>

                            <!-- Custom Service Description -->
                            <div class="mb-4" id="customServiceSection">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-edit me-2 text-secondary"></i><span id="customServiceTitle">Additional Information & Custom Requests</span>
                                        </h6>
                                        <p class="card-text text-muted mb-3" id="customServiceDescription">
                                            Use this space to describe your specific repair needs or add any additional information that would help us serve you better.
                                        </p>
                                        <textarea class="form-control @error('custom_repair_description') is-invalid @enderror"
                                                  id="custom_repair_description" name="custom_repair_description" rows="4"
                                                  placeholder="Describe your repair requirements, device issues, or any special instructions. For example: 'Screen replacement needed - cracked from drop', 'Battery drains quickly', 'Please handle with care - device contains important data', etc.">{{ old('custom_repair_description') }}</textarea>
                                        @error('custom_repair_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted mt-2 d-block">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Our technicians will review your message and contact you with a detailed quote and service plan
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary btn-lg px-4 prev-step">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary btn-lg px-5 next-step">
                                    Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Schedule Appointment -->
                        <div class="step step-4">
                            <div class="text-center mb-4">
                                <h4 class="text-primary mb-2">📅 Schedule Your Appointment</h4>
                                <p class="text-muted">Choose when you'd like to bring in your device</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="preferred_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>Preferred Date *
                                    </label>
                                    <input type="date" class="form-control form-control-lg @error('preferred_date') is-invalid @enderror"
                                           id="preferred_date" name="preferred_date" value="{{ old('preferred_date') }}"
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('preferred_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="preferred_time_slot" class="form-label fw-semibold">
                                        <i class="fas fa-clock me-2 text-primary"></i>Time Preference *
                                    </label>
                                    <select class="form-select form-select-lg @error('preferred_time_slot') is-invalid @enderror"
                                            id="preferred_time_slot" name="preferred_time_slot" required>
                                        <option value="morning" {{ old('preferred_time_slot') == 'morning' ? 'selected' : '' }}>🌅 Morning (9AM - 12PM)</option>
                                        <option value="afternoon" {{ old('preferred_time_slot') == 'afternoon' ? 'selected' : '' }}>☀️ Afternoon (1PM - 5PM)</option>
                                        <option value="evening" {{ old('preferred_time_slot') == 'evening' ? 'selected' : '' }}>🌆 Evening (6PM - 8PM)</option>
                                        <option value="anytime" {{ old('preferred_time_slot', 'anytime') == 'anytime' ? 'selected' : '' }}>⏰ Anytime</option>
                                    </select>
                                    @error('preferred_time_slot')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="preferred_time" class="form-label fw-semibold">
                                        <i class="fas fa-clock me-2 text-secondary"></i>Specific Time (optional)
                                    </label>
                                    <input type="time" class="form-control form-control-lg @error('preferred_time') is-invalid @enderror"
                                           id="preferred_time" name="preferred_time" value="{{ old('preferred_time') }}">
                                    @error('preferred_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">If you have a specific time preference</small>
                                </div>
                            </div>

                            <!-- Booking Summary -->
                            <div class="card bg-light border-0 my-4" id="bookingSummary" style="display: none;">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Booking Summary</h6>
                                </div>
                                <div class="card-body">
                                    <div id="summaryContent">
                                        <!-- Summary will be populated here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-4">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input form-check-input-lg @error('agree_terms') is-invalid @enderror"
                                                   type="checkbox" id="agree_terms" name="agree_terms" value="1"
                                                   {{ old('agree_terms') ? 'checked' : '' }} required>
                                            <label class="form-check-label fw-semibold" for="agree_terms">
                                                <i class="fas fa-shield-alt me-2 text-success"></i>
                                                I agree to the
                                                <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#termsModal">
                                                    terms and conditions
                                                </a> *
                                            </label>
                                            @error('agree_terms')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            By proceeding, you acknowledge that you've read our service terms and privacy policy.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-secondary btn-lg px-4 prev-step">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </button>
                                <button type="submit" class="btn btn-success btn-lg px-5" id="submitBtn">
                                    <span class="submit-text">
                                        <i class="fas fa-check me-2"></i>Submit Booking
                                    </span>
                                    <span class="submit-loading d-none">
                                        <div class="spinner-border spinner-border-sm me-2" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="termsModalLabel">
                    <i class="fas fa-file-contract me-2"></i>Terms and Conditions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Please read our terms and conditions carefully before proceeding.
                </div>

                <h6 class="fw-bold">Service Agreement</h6>
                <p>By booking a repair service, you agree to our standard terms and conditions for device repair services.</p>

                <h6 class="fw-bold">Privacy Policy</h6>
                <p>Your personal information will be used solely for the purpose of providing repair services and will not be shared with third parties.</p>

                <h6 class="fw-bold">Warranty</h6>
                <p>All repairs come with a standard warranty period. Specific warranty terms depend on the type of repair performed.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="document.getElementById('agree_terms').checked = true;">
                    <i class="fas fa-check me-1"></i>I Agree
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 4;
    let selectedCategory = null;
    let selectedDeviceType = null;
    let selectedService = null; // Changed from selectedServices array to single service
    let availableServicesCount = 0;

    // Initialize - check if we have old data to restore state
    initializeFormState();
    updateProgressBar();
    showCurrentStep();
    updateStepIndicators();

    // Initialize form state from old() values
    function initializeFormState() {
        // Restore category selection if exists
        const oldCategoryId = document.getElementById('device_category_id').value;
        if (oldCategoryId) {
            const categoryCard = document.querySelector(`[data-category-id="${oldCategoryId}"]`);
            if (categoryCard) {
                categoryCard.classList.add('border-primary', 'bg-primary', 'text-white');
                selectedCategory = {
                    id: oldCategoryId,
                    name: categoryCard.dataset.categoryName
                };
                loadDeviceTypes(oldCategoryId);
            }
        }

        // Set current step based on how much data we have
        if (oldCategoryId && document.getElementById('device_type_id').value) {
            currentStep = 3; // Go to services step
        } else if (oldCategoryId) {
            currentStep = 2; // Go to device step
        }
    }

    // Next step button handlers
    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                currentStep++;
                showCurrentStep();
                updateProgressBar();
                updateStepIndicators();
                showSuccessMessage('Step completed successfully!');

                if (currentStep === 4) {
                    generateBookingSummary();
                }
            }
        });
    });

    // Previous step button handlers
    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function() {
            currentStep--;
            showCurrentStep();
            updateProgressBar();
            updateStepIndicators();
        });
    });

    // Category card selection
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('click', function() {
            // Remove previous selection
            document.querySelectorAll('.category-card').forEach(c => {
                c.classList.remove('border-primary', 'bg-primary', 'text-white');
                c.classList.add('border');
            });

            // Add selection to clicked card
            this.classList.remove('border');
            this.classList.add('border-primary', 'bg-primary', 'text-white');

            const categoryId = this.dataset.categoryId;
            const categoryName = this.dataset.categoryName;

            document.getElementById('device_category_id').value = categoryId;
            selectedCategory = {id: categoryId, name: categoryName};

            // Load device types with caching
            loadDeviceTypes(categoryId);

            // Show device type section
            document.querySelector('.device-type-section').style.display = 'block';
        });
    });

    // Condition buttons
    document.querySelectorAll('.condition-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove previous selection
            document.querySelectorAll('.condition-btn').forEach(b => {
                b.classList.remove('btn-success', 'btn-primary', 'btn-warning', 'btn-danger');
                b.classList.add('btn-outline-success', 'btn-outline-primary', 'btn-outline-warning', 'btn-outline-danger');
            });

            // Add selection to clicked button
            const condition = this.dataset.condition;
            this.classList.remove('btn-outline-success', 'btn-outline-primary', 'btn-outline-warning', 'btn-outline-danger');

            if (condition.includes('Excellent')) {
                this.classList.add('btn-success');
            } else if (condition.includes('Good')) {
                this.classList.add('btn-primary');
            } else if (condition.includes('Fair')) {
                this.classList.add('btn-warning');
            } else {
                this.classList.add('btn-danger');
            }

            document.getElementById('device_condition').value = condition;
        });
    });

    // Load device types function with caching
    function loadDeviceTypes(categoryId) {
        const container = document.getElementById('deviceTypeCards');

        // Check cache first
        const cacheKey = `device_types_${categoryId}`;
        const cached = sessionStorage.getItem(cacheKey);

        if (cached) {
            const data = JSON.parse(cached);
            renderDeviceTypes(data);
            return;
        }

        // Show loading
        container.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"></div></div>';

        fetch(`/device-types/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                // Cache the result
                sessionStorage.setItem(cacheKey, JSON.stringify(data));
                renderDeviceTypes(data);
            })
            .catch(error => {
                console.error('Error loading device types:', error);
                container.innerHTML = '<div class="col-12 text-center text-danger">Error loading device types</div>';
            });
    }

    function renderDeviceTypes(data) {
        const container = document.getElementById('deviceTypeCards');
        container.innerHTML = '';

        if (data.length === 0) {
            container.innerHTML = '<div class="col-12 text-center text-muted">No device types available for this category</div>';
            return;
        }

        data.forEach(type => {
            const imageUrl = type.image ? `/storage/${type.image}` : 'https://via.placeholder.com/100x80?text=Device';
            const oldTypeId = document.getElementById('device_type_id').value;
            const isSelected = oldTypeId == type.id;

            const card = document.createElement('div');
            card.className = 'col-md-4 col-sm-6';
            card.innerHTML = `
                <div class="device-type-card border rounded-3 p-3 text-center h-100 cursor-pointer ${isSelected ? 'border-primary bg-primary text-white' : ''}"
                     data-type-id="${type.id}" data-type-name="${type.name}"
                     data-brand="${type.brand || ''}" data-model="${type.model || ''}">
                    <img src="${imageUrl}" alt="${type.name}" class="img-fluid mb-2" style="height: 60px; object-fit: cover;">
                    <h6 class="fw-semibold mb-1">${type.name}</h6>
                    ${type.brand ? `<small class="text-muted d-block">${type.brand}</small>` : ''}
                    ${type.model ? `<small class="text-muted">${type.model}</small>` : ''}
                </div>
            `;
            container.appendChild(card);

            // If this was the previously selected type, restore the selection
            if (isSelected) {
                selectedDeviceType = {id: type.id, name: type.name, brand: type.brand, model: type.model};
                loadRepairServices(type.id);
                document.querySelector('.brand-model-section').style.display = 'block';
                document.querySelector('.condition-section').style.display = 'block';
            }
        });

        // Add click events to device type cards
        addDeviceTypeEventListeners();
    }

    // Add device type event listeners
    function addDeviceTypeEventListeners() {
        document.querySelectorAll('.device-type-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove previous selection
                document.querySelectorAll('.device-type-card').forEach(c => {
                    c.classList.remove('border-primary', 'bg-primary', 'text-white');
                    c.classList.add('border');
                });

                // Add selection to clicked card
                this.classList.remove('border');
                this.classList.add('border-primary', 'bg-primary', 'text-white');

                const typeId = this.dataset.typeId;
                const typeName = this.dataset.typeName;
                const brand = this.dataset.brand;
                const model = this.dataset.model;

                document.getElementById('device_type_id').value = typeId;
                selectedDeviceType = {id: typeId, name: typeName, brand: brand, model: model};

                // Clear any previously selected service
                selectedService = null;
                updateSelectedServiceDisplay();

                // Pre-fill brand and model
                const brandField = document.getElementById('device_brand');
                const modelField = document.getElementById('device_model');

                if (brand) {
                    brandField.value = brand;
                    brandField.setAttribute('readonly', 'readonly');
                    brandField.classList.add('bg-light');
                }
                if (model) {
                    modelField.value = model;
                    modelField.setAttribute('readonly', 'readonly');
                    modelField.classList.add('bg-light');
                }

                // Load repair services with caching
                loadRepairServices(typeId);

                // Show next sections
                document.querySelector('.brand-model-section').style.display = 'block';
                document.querySelector('.condition-section').style.display = 'block';
            });
        });
    }

    // Load repair services function with caching and image support
    function loadRepairServices(typeId) {
        const container = document.getElementById('serviceCards');
        const serviceSection = document.querySelector('.service-selection-section');
        const selectedDeviceName = document.getElementById('selectedDeviceName');

        if (selectedDeviceType) {
            selectedDeviceName.textContent = selectedDeviceType.name;
        }

        // Check cache first
        const cacheKey = `repair_services_${typeId}`;
        const cached = sessionStorage.getItem(cacheKey);

        if (cached) {
            const data = JSON.parse(cached);
            renderRepairServices(data);
            serviceSection.style.display = 'block';
            return;
        }

        // Show loading state
        container.innerHTML = `
            <div class="col-12 text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading services...</span>
                </div>
                <p class="mt-2 text-muted">Checking available services for your ${selectedDeviceType ? selectedDeviceType.name : 'device'}...</p>
            </div>
        `;
        serviceSection.style.display = 'block';

        fetch(`/repair-services/${typeId}`)
            .then(response => {
                if (!response.ok) throw new Error('Failed to load services');
                return response.json();
            })
            .then(data => {
                // Cache the result
                sessionStorage.setItem(cacheKey, JSON.stringify(data));
                renderRepairServices(data);
            })
            .catch(error => {
                console.error('Error loading repair services:', error);
                container.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Error loading services</strong><br>
                            <small>Please try again or contact support.</small>
                        </div>
                    </div>
                `;
            });
    }

    function renderRepairServices(data) {
        const container = document.getElementById('serviceCards');
        container.innerHTML = '';
        availableServicesCount = data.length;

        if (data.length === 0) {
            container.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-warning border-warning">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-2">No Pre-configured Services Available</h6>
                                <p class="mb-1">We don't have pre-configured repair services for <strong>${selectedDeviceType ? selectedDeviceType.name : 'this device model'}</strong> yet.</p>
                                <small class="text-muted">This doesn't mean we can't repair your device! Please describe your repair needs in the custom service section below.</small>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            updateCustomServiceSection(true);
            return;
        }

        // Display available services with images
        const servicesHeader = document.createElement('div');
        servicesHeader.className = 'col-12 mb-3';
        servicesHeader.innerHTML = `
            <div class="alert alert-success border-success">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Perfect! We have ${data.length} repair service${data.length > 1 ? 's' : ''} available</h6>
                        <small class="text-muted">Please select the service that best matches your repair needs for your ${selectedDeviceType ? selectedDeviceType.name : 'device'}</small>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(servicesHeader);

        // Get old selected service
        const oldServiceId = document.getElementById('repair_service_id').value;

        data.forEach(service => {
            const isSelected = oldServiceId == service.id;
            const serviceImageUrl = service.image ? `/storage/${service.image}` : '/images/default-service.png';

            const serviceCard = document.createElement('div');
            serviceCard.className = 'col-md-6 col-lg-4';
            serviceCard.innerHTML = `
                <div class="service-card border rounded-3 p-3 h-100 cursor-pointer position-relative ${isSelected ? 'border-primary bg-light' : ''}"
                     data-service-id="${service.id}"
                     data-service-name="${service.service_name}"
                     data-estimated-time="${service.estimated_time_hours}"
                     data-warranty="${service.warranty_days}">

                    <div class="service-card-content">
                        ${service.image ? `
                        <div class="text-center mb-3">
                            <img src="${serviceImageUrl}" alt="${service.service_name}"
                                 class="img-fluid rounded" style="height: 80px; object-fit: cover; width: 100%;">
                        </div>
                        ` : ''}

                        <div class="d-flex align-items-start mb-2">
                            <div class="form-check me-3 mt-1">
                                <input class="form-check-input service-radio" type="radio"
                                       id="service_${service.id}" name="service_selection"
                                       value="${service.id}" ${isSelected ? 'checked' : ''}>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-semibold mb-0">${service.service_name}</h6>
                                ${service.description ? `<p class="text-muted small mb-2 service-description">${service.description}</p>` : ''}
                            </div>
                        </div>

                        <div class="row g-2 text-center service-details">
                            <div class="col-6">
                                <div class="service-detail-item">
                                    <i class="fas fa-clock text-primary mb-1"></i>
                                    <small class="d-block fw-semibold">${service.estimated_time_hours}h</small>
                                    <small class="text-muted">Estimated time</small>
                                </div>
                            </div>
                            ${service.warranty_days ? `
                            <div class="col-6">
                                <div class="service-detail-item">
                                    <i class="fas fa-shield-alt text-success mb-1"></i>
                                    <small class="d-block fw-semibold">${service.warranty_days} days</small>
                                    <small class="text-muted">Warranty</small>
                                </div>
                            </div>
                            ` : `
                            <div class="col-6">
                                <div class="service-detail-item">
                                    <i class="fas fa-star text-warning mb-1"></i>
                                    <small class="d-block fw-semibold">Expert</small>
                                    <small class="text-muted">Certified tech</small>
                                </div>
                            </div>
                            `}
                        </div>
                    </div>

                    <!-- Selection indicator -->
                    <div class="service-selected-indicator position-absolute top-0 end-0 p-2" style="display: ${isSelected ? 'block' : 'none'};">
                        <i class="fas fa-check-circle text-primary fa-lg"></i>
                    </div>
                </div>
            `;
            container.appendChild(serviceCard);

            if (isSelected) {
                selectedService = {
                    id: service.id,
                    name: service.service_name,
                    estimatedTime: service.estimated_time_hours,
                    warranty: service.warranty_days
                };
            }
        });

        // Add click events to service cards
        addServiceCardEventListeners();
        updateSelectedServiceDisplay();
        updateCustomServiceSection(false);
    }

    // Add service card event listeners
    function addServiceCardEventListeners() {
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function(e) {
                if (e.target.type === 'radio') return;

                const radio = this.querySelector('.service-radio');
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            });
        });

        document.querySelectorAll('.service-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const card = this.closest('.service-card');
                const serviceId = this.value;
                const serviceName = card.dataset.serviceName;
                const estimatedTime = card.dataset.estimatedTime;
                const warranty = card.dataset.warranty;

                // Remove previous selections
                document.querySelectorAll('.service-card').forEach(c => {
                    c.classList.remove('border-primary', 'bg-light');
                    c.querySelector('.service-selected-indicator').style.display = 'none';
                });

                // Set new selection
                selectedService = {
                    id: serviceId,
                    name: serviceName,
                    estimatedTime: estimatedTime,
                    warranty: warranty
                };

                // Update hidden field
                document.getElementById('repair_service_id').value = serviceId;

                // Update visual selection
                card.classList.add('border-primary', 'bg-light');
                card.querySelector('.service-selected-indicator').style.display = 'block';

                updateSelectedServiceDisplay();
            });
        });
    }

    // Update selected service display (changed from multiple to single)
    function updateSelectedServiceDisplay() {
        const serviceSection = document.querySelector('.service-selection-section');
        let existingSummary = serviceSection.querySelector('.selected-service-summary');

        if (selectedService) {
            if (!existingSummary) {
                existingSummary = document.createElement('div');
                existingSummary.className = 'selected-service-summary mt-3 p-3 bg-primary bg-opacity-10 border border-primary rounded';
                serviceSection.appendChild(existingSummary);
            }

            let summaryHTML = `
                <h6 class="text-primary mb-2">
                    <i class="fas fa-check-circle me-2"></i>Selected Service
                </h6>
                <div class="selected-service-item p-3 bg-white rounded border">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong class="d-block">${selectedService.name}</strong>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>${selectedService.estimatedTime}h
                                ${selectedService.warranty ? ` | <i class="fas fa-shield-alt me-1"></i>${selectedService.warranty} days warranty` : ''}
                            </small>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                    </div>
                </div>
            `;
            existingSummary.innerHTML = summaryHTML;
        } else {
            if (existingSummary) {
                existingSummary.remove();
            }
        }
    }

    // Update custom service section
    function updateCustomServiceSection(isRequired) {
        const customServiceSection = document.getElementById('customServiceSection');
        const customServiceTitle = document.getElementById('customServiceTitle');
        const customServiceDescription = document.getElementById('customServiceDescription');
        const customTextarea = document.getElementById('custom_repair_description');

        if (isRequired) {
            customServiceSection.className = 'mb-4 border border-primary rounded p-3 bg-light';
            customServiceTitle.innerHTML = '<i class="fas fa-edit me-2 text-primary"></i>Describe Your Repair Needs (Required)';
            customServiceDescription.textContent = 'Since we don\'t have pre-configured services for your device, please describe what needs to be repaired.';
            customTextarea.setAttribute('required', 'required');
        } else {
            customServiceSection.className = 'mb-4';
            customServiceTitle.innerHTML = '<i class="fas fa-edit me-2 text-secondary"></i>Additional Information & Custom Requests';
            customServiceDescription.textContent = 'Use this space to describe additional repair needs or provide special instructions.';
            customTextarea.removeAttribute('required');
        }
    }

    // Generate booking summary
    function generateBookingSummary() {
        const summary = document.getElementById('summaryContent');
        const customerName = document.getElementById('customer_name').value;
        const customerEmail = document.getElementById('customer_email').value;
        const customerPhone = document.getElementById('customer_phone').value;
        const deviceBrand = document.getElementById('device_brand').value;
        const deviceModel = document.getElementById('device_model').value;
        const customService = document.getElementById('custom_repair_description').value;
        const preferredDate = document.getElementById('preferred_date').value;
        const timeSlot = document.getElementById('preferred_time_slot').selectedOptions[0].text;

        let summaryHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">👤 Customer Information</h6>
                    <p class="mb-1"><strong>Name:</strong> ${customerName}</p>
                    <p class="mb-1"><strong>Email:</strong> ${customerEmail}</p>
                    <p class="mb-0"><strong>Phone:</strong> ${customerPhone}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">📱 Device Information</h6>
                    <p class="mb-1"><strong>Category:</strong> ${selectedCategory ? selectedCategory.name : 'Not selected'}</p>
                    <p class="mb-1"><strong>Model:</strong> ${selectedDeviceType ? selectedDeviceType.name : 'Not selected'}</p>
                    <p class="mb-0"><strong>Brand:</strong> ${deviceBrand} ${deviceModel}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">🔧 Service</h6>
                    ${selectedService ?
                        `<div class="service-summary">
                            <div class="service-item p-3 bg-white rounded border">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong class="d-block">${selectedService.name}</strong>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>Est. ${selectedService.estimatedTime}h
                                            ${selectedService.warranty ? ` | <i class="fas fa-shield-alt me-1"></i>${selectedService.warranty} days warranty` : ''}
                                        </small>
                                    </div>
                                    <div class="text-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>` :
                        `<div class="custom-service-summary p-3 bg-warning bg-opacity-10 rounded border border-warning">
                            <p class="mb-1"><strong>Custom Service Requested</strong></p>
                            <small class="text-muted">Service will be determined after assessment</small>
                        </div>`
                    }
                    ${customService ? `<div class="mt-2 p-2 bg-info bg-opacity-10 rounded border border-info"><strong>Additional Notes:</strong><br><small class="text-muted">${customService}</small></div>` : ''}
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary mb-3">📅 Appointment</h6>
                    <p class="mb-1"><strong>Date:</strong> ${preferredDate}</p>
                    <p class="mb-0"><strong>Time:</strong> ${timeSlot}</p>
                </div>
            </div>
        `;

        summary.innerHTML = summaryHTML;
        document.getElementById('bookingSummary').style.display = 'block';
    }

    // Utility functions
    function showCurrentStep() {
        document.querySelectorAll('.step').forEach(step => {
            step.classList.remove('active');
            step.style.display = 'none';
        });

        const currentStepEl = document.querySelector('.step-' + currentStep);
        if (currentStepEl) {
            currentStepEl.style.display = 'block';
            setTimeout(() => {
                currentStepEl.classList.add('active');
            }, 50);
        }
    }

    function updateProgressBar() {
        const progress = (currentStep / totalSteps) * 100;
        const progressBar = document.querySelector('.progress-bar');
        progressBar.style.width = progress + '%';
        progressBar.setAttribute('aria-valuenow', progress);
    }

    function updateStepIndicators() {
        document.querySelectorAll('.step-indicator').forEach(indicator => {
            const stepNum = parseInt(indicator.dataset.step);
            const circle = indicator.querySelector('.step-circle');

            circle.classList.remove('bg-primary', 'bg-success', 'bg-secondary');

            if (stepNum < currentStep) {
                circle.classList.add('bg-success');
            } else if (stepNum === currentStep) {
                circle.classList.add('bg-primary');
            } else {
                circle.classList.add('bg-secondary');
            }
        });
    }

    function validateStep(step) {
        let isValid = true;

        if (step === 1) {
            const requiredFields = ['customer_name', 'customer_email', 'customer_phone'];
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    isValid = false;
                }
            });
        } else if (step === 2) {
            if (!document.getElementById('device_category_id').value || !document.getElementById('device_type_id').value) {
                isValid = false;
            }
        } else if (step === 3) {
            const customDescription = document.getElementById('custom_repair_description').value.trim();
            const serviceId = document.getElementById('repair_service_id').value;

            if (availableServicesCount === 0) {
                // No services available, custom description is required
                if (!customDescription) {
                    isValid = false;
                    showErrorMessage('Please describe your repair needs');
                }
            } else {
                // Services are available, either service selection or custom description is required
                if (!serviceId && !customDescription) {
                    isValid = false;
                    showErrorMessage('Please select a service or describe your custom repair needs');
                }
            }
        } else if (step === 4) {
            const requiredFields = ['preferred_date', 'preferred_time_slot'];
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value) isValid = false;
            });
            if (!document.getElementById('agree_terms').checked) isValid = false;
        }

        if (!isValid && step !== 3) {
            showErrorMessage('Please complete all required fields before proceeding');
        }

        return isValid;
    }

    function showErrorMessage(message) {
        const alertHtml = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.getElementById('alertContainer').innerHTML = alertHtml;
    }

    function showSuccessMessage(message) {
        const alertHtml = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.getElementById('alertContainer').innerHTML = alertHtml;

        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) {
                alert.remove();
            }
        }, 3000);
    }

    // REGULAR FORM SUBMISSION (No AJAX) with loading state
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = submitBtn.querySelector('.submit-text');
        const submitLoading = submitBtn.querySelector('.submit-loading');

        // Show loading state
        submitBtn.disabled = true;
        submitText.classList.add('d-none');
        submitLoading.classList.remove('d-none');

        // Form will submit normally to Laravel
        // Laravel will handle validation and redirect
    });
});
</script>

<style>
.step {
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.step.active {
    display: block;
    opacity: 1;
}

.category-card, .device-type-card, .service-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #e5e7eb !important;
}

.category-card:hover, .device-type-card:hover, .service-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.category-card.selected, .device-type-card.selected, .service-card.selected {
    border-color: #6366f1 !important;
    background-color: #6366f1 !important;
    color: white !important;
}

.step-circle {
    transition: all 0.3s ease;
}

.condition-btn {
    transition: all 0.2s ease;
}

.condition-btn:hover {
    transform: scale(1.05);
}

.form-control:focus, .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
}

.btn-primary {
    background-color: #6366f1;
    border-color: #6366f1;
}

.btn-primary:hover {
    background-color: #4f46e5;
    border-color: #4f46e5;
}

.progress-bar {
    transition: width 0.6s ease;
}

.device-type-card img {
    border-radius: 8px;
}

.service-card {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.service-card:hover {
    border-color: #6366f1 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
}

.service-card.border-primary {
    border-color: #6366f1 !important;
    background-color: rgba(99, 102, 241, 0.05) !important;
}

.service-detail-item {
    padding: 0.5rem;
}

.service-selected-indicator {
    background: rgba(99, 102, 241, 0.9);
    border-radius: 0 0 0 1rem;
}

.service-description {
    height: 2.5rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.service-radio {
    transform: scale(1.2);
    border-color: #6366f1;
}

.service-radio:checked {
    background-color: #6366f1;
    border-color: #6366f1;
}

.selected-service-summary {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.selected-service-item {
    transition: all 0.2s ease;
}

.selected-service-item:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.form-control[readonly] {
    background-color: #f8f9fa !important;
    border-color: #6c757d !important;
    color: #495057 !important;
    cursor: default;
}

.service-item {
    transition: all 0.2s ease;
}

.service-item:hover {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

@media (max-width: 768px) {
    .category-card, .device-type-card {
        margin-bottom: 1rem;
    }

    .step-indicator {
        margin-bottom: 1rem;
    }

    .service-card {
        margin-bottom: 1rem;
    }
}

.alert {
    border-radius: 0.5rem;
}

.alert-warning {
    background-color: #fff9e6;
}

.alert-success {
    background-color: #e8f5e8;
}
</style>
@endsection
