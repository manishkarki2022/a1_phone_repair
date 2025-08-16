@extends('admin.layouts.app')

@section('title', 'Customer Bookings')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Customer Bookings</h5>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="ready_for_pickup" {{ request('status') == 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="">All Priorities</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="date_from">From Date</label>
                                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="date_to">To Date</label>
                                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-8">
                                <input type="text" name="search" class="form-control" placeholder="Search by booking number, customer name, email or phone" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">Filter</button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('customer-bookings.index') }}" class="btn btn-secondary btn-block">Reset</a>
                            </div>
                        </div>
                    </form>

                    <!-- Bookings Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Booking #</th>
                                    <th>Customer</th>
                                    <th>Device</th>
                                    <th>Service</th>
                                    <th>Preferred Date</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->booking_number }}</td>
                                    <td>
                                        <strong>{{ $booking->customer_name }}</strong><br>
                                        <small>{{ $booking->customer_phone }}</small><br>
                                        <small>{{ $booking->customer_email }}</small>
                                    </td>
                                    <td>
                                        @if($booking->deviceType)
                                            {{ $booking->deviceType->name }}<br>
                                        @endif
                                        {{ $booking->device_brand }} {{ $booking->device_model }}
                                    </td>
                                    <td>
                                        @if($booking->repairService)
                                            {{ $booking->repairService->name }}
                                        @elseif($booking->custom_repair_description)
                                            {{ $booking->custom_repair_description }}
                                        @endif
                                    </td>
                                    <td>{{ $booking->preferred_date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $booking->status_badge }}">
                                            {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $booking->priority_badge }}">
                                            {{ ucfirst($booking->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('customer-bookings.show', $booking) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customer-bookings.edit', $booking) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($booking->status == 'pending')
                                        <form action="{{ route('customer-bookings.confirm', $booking) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success" title="Confirm">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No bookings found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
