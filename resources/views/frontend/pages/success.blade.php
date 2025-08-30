@extends('frontend.layout.app')

@section('title', 'Booking Confirmed')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Header -->
            <div class="text-center mb-5">
                <div class="success-icon mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h1 class="text-success mb-3">Booking Confirmed!</h1>
                <p class="lead text-muted">Thank you for choosing our repair service. Your booking has been successfully submitted.</p>
            </div>

            <!-- Booking Details Card -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-success text-white text-center py-4">
                    <h4 class="mb-1"><i class="fas fa-ticket-alt me-2"></i>Booking Details</h4>
                    <h5 class="mb-0 fw-bold">{{ $booking->booking_number }}</h5>
                </div>

                <div class="card-body p-4">
                    <!-- Quick Info Bar -->
                    <div class="alert alert-info mb-4">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <i class="fas fa-calendar-alt text-primary mb-2 d-block" style="font-size: 1.5rem;"></i>
                                <strong>Appointment Date</strong><br>
                                <span class="text-muted">{{ $booking->preferred_date->format('F j, Y') }}</span>
                            </div>
                            <div class="col-md-4">
                                <i class="fas fa-clock text-warning mb-2 d-block" style="font-size: 1.5rem;"></i>
                                <strong>Time Slot</strong><br>
                                <span class="text-muted">{{ $booking->formatted_time_slot }}</span>
                            </div>
                            <div class="col-md-4">
                                <i class="fas fa-hourglass-half text-info mb-2 d-block" style="font-size: 1.5rem;"></i>
                                <strong>Status</strong><br>
                                <span class="badge bg-{{ $booking->status_badge }} text-white px-3 py-2">{{ ucfirst($booking->status) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="text-primary mb-3 border-bottom pb-2">
                                    <i class="fas fa-user me-2"></i>Customer Information
                                </h6>
                                <div class="info-item mb-2">
                                    <strong>Name:</strong> {{ $booking->customer_name }}
                                </div>
                                <div class="info-item mb-2">
                                    <strong>Email:</strong> {{ $booking->customer_email }}
                                </div>
                                <div class="info-item mb-2">
                                    <strong>Phone:</strong> {{ $booking->customer_phone }}
                                </div>
                                @if($booking->customer_city)
                                <div class="info-item mb-2">
                                    <strong>City:</strong> {{ $booking->customer_city }}
                                </div>
                                @endif
                                @if($booking->customer_address)
                                <div class="info-item">
                                    <strong>Address:</strong><br>
                                    <span class="text-muted">{{ $booking->customer_address }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Device Information -->
                        <div class="col-md-6">
                            <div class="info-section">
                                <h6 class="text-primary mb-3 border-bottom pb-2">
                                    <i class="fas fa-mobile-alt me-2"></i>Device Information
                                </h6>
                                <div class="info-item mb-2">
                                    <strong>Category:</strong> {{ $booking->deviceCategory->name ?? 'N/A' }}
                                </div>
                                <div class="info-item mb-2">
                                    <strong>Device Type:</strong> {{ $booking->deviceType->name ?? 'N/A' }}
                                </div>
                                <div class="info-item mb-2">
                                    <strong>Brand:</strong> {{ $booking->device_brand }}
                                </div>
                                <div class="info-item mb-2">
                                    <strong>Model:</strong> {{ $booking->device_model }}
                                </div>
                                @if($booking->device_condition)
                                <div class="info-item">
                                    <strong>Condition:</strong><br>
                                    <span class="text-muted">{{ $booking->device_condition }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Services Information -->
                        <div class="col-12">
                            <div class="info-section">
                                <h6 class="text-primary mb-3 border-bottom pb-2">
                                    <i class="fas fa-tools me-2"></i>Repair Services
                                </h6>

                                @if($selectedServices && $selectedServices->count() > 0)
                                    <!-- Selected Services -->
                                    <div class="row g-3 mb-3">
                                        @foreach($selectedServices as $service)
                                        <div class="col-md-6">
                                            <div class="service-card p-3 border rounded bg-light">
                                                @if($service->image)
                                                <div class="text-center mb-2">
                                                    <img src="{{ Storage::url($service->image) }}" alt="{{ $service->service_name }}"
                                                         class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                                                </div>
                                                @endif
                                                <h6 class="fw-semibold mb-1">{{ $service->service_name }}</h6>
                                                @if($service->description)
                                                <p class="text-muted small mb-2">{{ $service->description }}</p>
                                                @endif
                                                <div class="d-flex justify-content-between text-sm">
                                                    <span><i class="fas fa-clock text-primary me-1"></i>{{ $service->estimated_time_hours }}h</span>
                                                    @if($service->warranty_days)
                                                    <span><i class="fas fa-shield-alt text-success me-1"></i>{{ $service->warranty_days }} days warranty</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- Service Summary -->
                                    <div class="alert alert-success">
                                        <div class="row text-center">
                                            <div class="col-md-4">
                                                <strong>{{ $selectedServices->count() }}</strong><br>
                                                <small class="text-muted">Services Selected</small>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>{{ $booking->total_estimated_time }}h</strong><br>
                                                <small class="text-muted">Estimated Time</small>
                                            </div>
                                            <div class="col-md-4">
                                                @if($booking->has_warranty)
                                                <strong>{{ $booking->max_warranty_days }} days</strong><br>
                                                <small class="text-muted">Max Warranty</small>
                                                @else
                                                <strong>Expert Service</strong><br>
                                                <small class="text-muted">Certified Technicians</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Custom Service -->
                                    <div class="alert alert-warning">
                                        <h6 class="mb-1"><i class="fas fa-wrench me-2"></i>Custom Repair Service</h6>
                                        <p class="mb-0">Our technicians will assess your device and provide a detailed quote based on your specific repair needs.</p>
                                    </div>
                                @endif

                                @if($booking->custom_repair_description)
                                <div class="mt-3">
                                    <h6 class="text-secondary mb-2">Additional Information:</h6>
                                    <div class="bg-light p-3 rounded">
                                        <p class="mb-0 text-muted">{{ $booking->custom_repair_description }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Appointment Details -->
                        <div class="col-12">
                            <div class="info-section">
                                <h6 class="text-primary mb-3 border-bottom pb-2">
                                    <i class="fas fa-calendar-check me-2"></i>Appointment Details
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item mb-2">
                                            <strong>Preferred Date:</strong> {{ $booking->preferred_date->format('l, F j, Y') }}
                                        </div>
                                        <div class="info-item mb-2">
                                            <strong>Time Slot:</strong> {{ $booking->formatted_time_slot }}
                                        </div>
                                        @if($booking->preferred_time)
                                        <div class="info-item mb-2">
                                            <strong>Specific Time:</strong> {{ $booking->preferred_time->format('g:i A') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($booking->estimated_completion_time)
                                        <div class="info-item mb-2">
                                            <strong>Estimated Completion:</strong> {{ $booking->estimated_completion_time->format('l, F j, Y \a\t g:i A') }}
                                        </div>
                                        @endif
                                        <div class="info-item">
                                            <strong>Booking Date:</strong> {{ $booking->formatted_booking_date }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps Card -->
            <div class="card border-primary mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list-check me-2"></i>Next Steps</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="step-item">
                                <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">1</div>
                                <div class="step-content">
                                    <h6 class="mb-1">Confirmation Call</h6>
                                    <p class="text-muted mb-0">We'll contact you within 24 hours to confirm your appointment details.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="step-item">
                                <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">2</div>
                                <div class="step-content">
                                    <h6 class="mb-1">Prepare Your Device</h6>
                                    <p class="text-muted mb-0">Back up your data and remove any personal accessories.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="step-item">
                                <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">3</div>
                                <div class="step-content">
                                    <h6 class="mb-1">Bring Required Items</h6>
                                    <p class="text-muted mb-0">Valid ID, device charger, and this booking confirmation.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="step-item">
                                <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">4</div>
                                <div class="step-content">
                                    <h6 class="mb-1">Visit Our Store</h6>
                                    <p class="text-muted mb-0">Arrive at your scheduled time for device assessment and repair.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="alert alert-info">
                <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Important Information</h6>
                <ul class="mb-0">
                    <li><strong>Confirmation Email:</strong> A detailed confirmation has been sent to {{ $booking->customer_email }}</li>
                    <li><strong>Changes:</strong> To modify your appointment, please contact us at least 4 hours in advance</li>
                    <li><strong>Data Backup:</strong> We recommend backing up your device before bringing it in for repair</li>
                    @if($selectedServices && $selectedServices->where('warranty_days', '>', 0)->count() > 0)
                    <li><strong>Warranty:</strong> Selected services include warranty coverage as specified above</li>
                    @endif
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="text-center">
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <button onclick="window.print()" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-print me-2"></i>Print Confirmation
                    </button>
                    <a href="mailto:{{ $booking->customer_email }}?subject=Booking {{ $booking->booking_number }} - Questions&body=Hi, I have questions about my booking {{ $booking->booking_number }}..."
                       class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-envelope me-2"></i>Email Us
                    </a>
                    <a href="{{ route('booking.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus me-2"></i>Book Another Repair
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.success-icon {
    animation: bounceIn 1s ease-out;
}

@keyframes bounceIn {
    0% { transform: scale(0); opacity: 0; }
    50% { transform: scale(1.1); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
}

.info-section {
    padding: 1rem;
    border-radius: 0.5rem;
    background-color: #f8f9fa;
    height: 100%;
}

.info-item {
    padding: 0.25rem 0;
}

.service-card {
    transition: all 0.3s ease;
    height: 100%;
}

.service-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.step-item {
    display: flex;
    align-items-flex-start;
    margin-bottom: 1rem;
}

.step-number {
    flex-shrink: 0;
    font-weight: bold;
    font-size: 0.875rem;
}

.step-content {
    flex-grow: 1;
}

@media print {
    .btn, .alert-info:last-child {
        display: none !important;
    }

    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }

    .text-primary, .text-success {
        color: #000 !important;
    }
}

.card-header.bg-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.card-header.bg-primary {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
}
</style>
@endsection
