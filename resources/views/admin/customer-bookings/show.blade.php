@extends('admin.layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Booking Details: {{ $customerBooking->booking_number }}</h5>
                    <div>
                        <span class="badge badge-{{ $customerBooking->status_badge }}">
                            {{ str_replace('_', ' ', ucfirst($customerBooking->status)) }}
                        </span>
                        <span class="badge badge-{{ $customerBooking->priority_badge }}">
                            {{ ucfirst($customerBooking->priority) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Booking Status Actions -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="d-flex flex-wrap justify-content-between">
                                @if($customerBooking->status == 'pending')
                                <form action="{{ route('customer-bookings.confirm', $customerBooking) }}" method="POST" class="mb-4">
                                    @csrf
                                    @method('PATCH')

                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <label for="confirmed_date">Confirmed Date</label>
                                            <input type="date"
                                                   name="confirmed_date"
                                                   id="confirmed_date"
                                                   class="form-control @error('confirmed_date') is-invalid @enderror"
                                                   value="{{ old('confirmed_date') }}"
                                                   min="{{ date('Y-m-d') }}"
                                                   required>
                                            @error('confirmed_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="confirmed_time">Confirmed Time</label>
                                            <input type="time"
                                                   name="confirmed_time"
                                                   id="confirmed_time"
                                                   class="form-control @error('confirmed_time') is-invalid @enderror"
                                                   value="{{ old('confirmed_time') }}"
                                                   required>
                                            @error('confirmed_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="estimated_completion_time">Estimated Completion</label>
                                            <input type="datetime-local"
                                                   name="estimated_completion_time"
                                                   id="estimated_completion_time"
                                                   class="form-control @error('estimated_completion_time') is-invalid @enderror"
                                                   value="{{ old('estimated_completion_time') }}">
                                            @error('estimated_completion_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label for="admin_quoted_price">Quoted Price (optional)</label>
                                            <input type="number"
                                                   step="0.01"
                                                   name="admin_quoted_price"
                                                   id="admin_quoted_price"
                                                   class="form-control @error('admin_quoted_price') is-invalid @enderror"
                                                   value="{{ old('admin_quoted_price') }}">
                                            @error('admin_quoted_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-8 mb-2">
                                            <label for="admin_notes">Admin Notes (optional)</label>
                                            <textarea name="admin_notes"
                                                      id="admin_notes"
                                                      class="form-control @error('admin_notes') is-invalid @enderror"
                                                      rows="2">{{ old('admin_notes') }}</textarea>
                                            @error('admin_notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check"></i> Confirm Booking
                                    </button>
                                </form>
                                @endif

                                @if($customerBooking->status == 'confirmed')
                                <form action="{{ route('customer-bookings.start-repair', $customerBooking) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-tools"></i> Start Repair
                                    </button>
                                </form>
                                @endif

                                @if($customerBooking->status == 'in_progress')
                                <form action="{{ route('customer-bookings.ready-for-pickup', $customerBooking) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-box-open"></i> Ready for Pickup
                                    </button>
                                </form>
                                @endif

                                @if($customerBooking->status == 'ready_for_pickup')
                                <form action="{{ route('customer-bookings.complete', $customerBooking) }}" method="POST" class="mb-2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check-circle"></i> Complete Booking
                                    </button>
                                </form>
                                @endif

                                @if(in_array($customerBooking->status, ['pending', 'confirmed', 'in_progress']))
<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelBookingModal{{ $customerBooking->id }}">
    <i class="fas fa-times"></i> Cancel Booking
</button>

<!-- Modal -->
<div class="modal fade" id="cancelBookingModal{{ $customerBooking->id }}" tabindex="-1" aria-labelledby="cancelBookingModalLabel{{ $customerBooking->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('customer-bookings.cancel', $customerBooking) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="cancelBookingModalLabel{{ $customerBooking->id }}">
                        <i class="fas fa-exclamation-triangle"></i> Confirm Cancellation
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cancel_note{{ $customerBooking->id }}" class="form-label">
                            <strong>Cancellation Reason*</strong>
                        </label>
                        <textarea class="form-control" id="cancel_note{{ $customerBooking->id }}"
                                  name="cancel_note" rows="4" required
                                  placeholder="Please explain the cancellation reason..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

                                <a href="{{ route('customer-bookings.edit', $customerBooking) }}" class="btn btn-info mb-2">
                                    <i class="fas fa-edit"></i> Edit Booking
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Rest of your content remains the same -->
                    <div class="row">
                        <!-- Left Column - Customer & Device Info -->
                        <div class="col-md-6">
                            <!-- Customer Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0">Customer Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Name:</strong><br>
                                            {{ $customerBooking->customer_name }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Phone:</strong><br>
                                            {{ $customerBooking->customer_phone }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Email:</strong><br>
                                            {{ $customerBooking->customer_email }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Address:</strong><br>
                                            {{ $customerBooking->customer_address }}<br>
                                            {{ $customerBooking->customer_city }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Device Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0">Device Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Category:</strong><br>
                                            {{ $customerBooking->deviceCategory->name ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Type:</strong><br>
                                            {{ $customerBooking->deviceType->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Brand:</strong><br>
                                            {{ $customerBooking->device_brand }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Model:</strong><br>
                                            {{ $customerBooking->device_model }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Condition:</strong><br>
                                            {{ $customerBooking->device_condition ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Service & Scheduling -->
                        <div class="col-md-6">
                            <!-- Service Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0">Service Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Service:</strong><br>
                                            {{ $customerBooking->repairService->name ?? $customerBooking->custom_repair_description }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Issue Description:</strong><br>
                                            {{ $customerBooking->device_issue_description }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Quoted Price:</strong><br>
                                            {{ $customerBooking->admin_quoted_price ? '$'.number_format($customerBooking->admin_quoted_price, 2) : 'N/A' }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Final Price:</strong><br>
                                            {{ $customerBooking->admin_final_price ? '$'.number_format($customerBooking->admin_final_price, 2) : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Scheduling Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0">Scheduling Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Preferred Date:</strong><br>
                                            {{ $customerBooking->preferred_date->format('M d, Y') }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Time Slot:</strong><br>
                                            {{ ucfirst($customerBooking->preferred_time_slot) }}
                                            @if($customerBooking->preferred_time)
                                                ({{ date('g:i A', strtotime($customerBooking->preferred_time)) }})
                                            @endif
                                        </div>
                                    </div>
                                    @if($customerBooking->confirmed_date)
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Confirmed Date:</strong><br>
                                            {{ $customerBooking->confirmed_date->format('M d, Y') }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Confirmed Time:</strong><br>
                                            {{ $customerBooking->confirmed_time ? date('g:i A', strtotime($customerBooking->confirmed_time)) : 'N/A' }}
                                        </div>
                                    </div>
                                    @endif
                                    @if($customerBooking->estimated_completion_time)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Estimated Completion:</strong><br>
                                            {{ $customerBooking->estimated_completion_time->format('M d, Y g:i A') }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0">Additional Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Customer Notes:</strong><br>
                                            {{ $customerBooking->customer_notes ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Special Instructions:</strong><br>
                                            {{ $customerBooking->special_instructions ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <strong>Admin Notes:</strong><br>
                                            {{ $customerBooking->admin_notes ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Internal Repair Notes:</strong><br>
                                            {{ $customerBooking->internal_repair_notes ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Booking Timeline</h5>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-point"></div>
                                    <div class="timeline-event">
                                        <div class="timeline-header">
                                            Booking Created
                                        </div>
                                        <div class="timeline-body">
                                            {{ $customerBooking->created_at->format('M d, Y g:i A') }}
                                        </div>
                                    </div>
                                </div>

                                @if($customerBooking->confirmed_at)
                                <div class="timeline-item">
                                    <div class="timeline-point timeline-point-success"></div>
                                    <div class="timeline-event">
                                        <div class="timeline-header">
                                            Booking Confirmed
                                        </div>
                                        <div class="timeline-body">
                                            {{ $customerBooking->confirmed_at->format('M d, Y g:i A') }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($customerBooking->started_at)
                                <div class="timeline-item">
                                    <div class="timeline-point timeline-point-primary"></div>
                                    <div class="timeline-event">
                                        <div class="timeline-header">
                                            Repair Started
                                        </div>
                                        <div class="timeline-body">
                                            {{ $customerBooking->started_at->format('M d, Y g:i A') }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($customerBooking->status == 'ready_for_pickup' || $customerBooking->status == 'completed')
                                <div class="timeline-item">
                                    <div class="timeline-point timeline-point-warning"></div>
                                    <div class="timeline-event">
                                        <div class="timeline-header">
                                            Ready for Pickup
                                        </div>
                                        <div class="timeline-body">
                                            {{ $customerBooking->updated_at->format('M d, Y g:i A') }}
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($customerBooking->completed_at)
                                <div class="timeline-item">
                                    <div class="timeline-point timeline-point-success"></div>
                                    <div class="timeline-event">
                                        <div class="timeline-header">
                                            Booking Completed
                                        </div>
                                        <div class="timeline-body">
                                            {{ $customerBooking->completed_at->format('M d, Y g:i A') }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('customer-bookings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 50px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-point {
        position: absolute;
        left: -25px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #6c757d;
    }
    .timeline-point-success {
        background-color: #28a745;
    }
    .timeline-point-primary {
        background-color: #007bff;
    }
    .timeline-point-warning {
        background-color: #ffc107;
    }
    .timeline-event {
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
        border-left: 3px solid #6c757d;
    }
    .timeline-header {
        font-weight: bold;
        margin-bottom: 5px;
    }
    .is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }
</style>
@endsection
