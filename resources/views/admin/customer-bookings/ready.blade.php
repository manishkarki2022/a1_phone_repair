@extends('admin.layouts.admin')

@section('title', 'Mark as Ready for Pickup')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Mark Booking as Ready for Pickup: {{ $customerBooking->booking_number }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer-bookings.ready-for-pickup', $customerBooking) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="admin_final_price">Final Price *</label>
                                    <input type="number" step="0.01" class="form-control" id="admin_final_price" name="admin_final_price" value="{{ $customerBooking->admin_final_price ?? $customerBooking->admin_quoted_price }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="internal_repair_notes">Internal Repair Notes</label>
                            <textarea class="form-control" id="internal_repair_notes" name="internal_repair_notes" rows="3">{{ $customerBooking->internal_repair_notes }}</textarea>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-box-open"></i> Mark as Ready for Pickup
                            </button>
                            <a href="{{ route('customer-bookings.show', $customerBooking) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
