@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard Overview</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info Boxes -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>{{ $totalBookings }}</h3>
                        <p>Total Bookings</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <a href="{{ route('customer-bookings.index') }}" class="small-box-footer">
                        View All <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ $pendingBookings }}</h3>
                        <p>Pending Bookings</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="{{ route('customer-bookings.index', ['status' => 'pending']) }}" class="small-box-footer">
                        View Pending <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ $confirmedBookings }}</h3>
                        <p>Confirmed Bookings</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ route('customer-bookings.index', ['status' => 'confirmed']) }}" class="small-box-footer">
                        View Confirmed <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3>{{ $completedBookings }}</h3>
                        <p>Completed Bookings</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <a href="{{ route('customer-bookings.index', ['status' => 'completed']) }}" class="small-box-footer">
                        View Completed <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Card -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-2"></i>Recent Bookings
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="bg-lightblue">
                                    <tr>
                                        <th>Booking #</th>
                                        <th>Customer</th>
                                        <th>Device</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBookings as $booking)
                                    <tr>
                                        <td><strong>{{ $booking->booking_number }}</strong></td>
                                        <td>{{ $booking->customer_name }}</td>
                                        <td>{{ $booking->device_brand }} {{ $booking->device_model }}</td>
                                        <td>{{ $booking->repairService->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge
                                                @if($booking->status == 'pending') bg-warning
                                                @elseif($booking->status == 'confirmed') bg-primary
                                                @elseif($booking->status == 'completed') bg-success
                                                @else bg-secondary @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('customer-bookings.show', $booking->id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="View Details"
                                               data-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                            No recent bookings found
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="{{ route('customer-bookings.index') }}" class="btn btn-sm btn-primary float-right">
                            <i class="fas fa-list mr-1"></i> View All Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Refresh dashboard every 60 seconds
    setInterval(function() {
        window.location.reload();
    }, 60000);
});
</script>
@endpush

@push('styles')
<style>
    .small-box {
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .small-box:hover {
        transform: translateY(-5px);
    }
    .small-box .icon {
        font-size: 70px;
        opacity: 0.3;
        transition: all 0.3s ease;
    }
    .small-box:hover .icon {
        opacity: 0.5;
    }
    .bg-lightblue {
        background-color: #e8f4fc;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }
    .card-outline {
        border-top: 3px solid #007bff;
    }
</style>
@endpush
