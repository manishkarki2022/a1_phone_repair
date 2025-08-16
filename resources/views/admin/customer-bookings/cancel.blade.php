@extends('admin.layouts.app')

@section('title', 'Cancel Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Cancel Booking: {{ $customerBooking->booking_number }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer-bookings.cancel', $customerBooking) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="alert alert-warning">
                            <strong>Warning!</strong> Are you sure you want to cancel this booking? This action cannot be undone.
                        </div>

                        <div class="form-group mb-4">
                            <label for="admin_notes">Cancellation Reason (Optional)</label>
                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ $customerBooking->admin_notes }}</textarea>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times"></i> Confirm Cancellation
                            </button>
                            <a href="{{ route('customer-bookings.show', $customerBooking) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Go Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
