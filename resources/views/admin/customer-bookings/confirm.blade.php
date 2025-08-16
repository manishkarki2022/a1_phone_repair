@extends('admin.layouts.app')

@section('title', 'Confirm Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Confirm Booking: {{ $customerBooking->booking_number }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer-bookings.confirm', $customerBooking) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="confirmed_date">Confirmed Date</label>
                            <input type="date" class="form-control" id="confirmed_date" name="confirmed_date"
                                   value="{{ old('confirmed_date', $customerBooking->confirmed_date ? $customerBooking->confirmed_date->format('Y-m-d') : '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="confirmed_time">Confirmed Time</label>
                            <input type="time" class="form-control" id="confirmed_time" name="confirmed_time"
                                   value="{{ old('confirmed_time', $customerBooking->confirmed_time ? $customerBooking->confirmed_time->format('H:i') : '') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="admin_notes">Admin Notes</label>
                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3">{{ old('admin_notes', $customerBooking->admin_notes) }}</textarea>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Confirm Booking
                            </button>
                            <a href="{{ route('customer-bookings.show', $customerBooking) }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
