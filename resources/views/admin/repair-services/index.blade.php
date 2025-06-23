@extends('admin.layouts.app')

@section('title', 'Repair Services')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Repair Services Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Repair Services</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <!-- Card Header -->
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-tools"></i> Repair Services List
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('repair-services.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New Service
                            </a>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="card-body border-bottom bg-light">
                        <form method="GET" action="{{ route('repair-services.index') }}" id="filterForm">
                            <!-- Basic Filters Row -->
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="search"><i class="fas fa-search"></i> Search Services</label>
                                        <div class="input-group">
                                            <input type="text"
                                                   name="search"
                                                   id="search"
                                                   class="form-control"
                                                   placeholder="Search by name, description..."
                                                   value="{{ request('search') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <label for="device_type"><i class="fas fa-mobile-alt"></i> Device Type</label>
                                        <select name="device_type" id="device_type" class="form-control">
                                            <option value="">All Device Types</option>
                                            @foreach(\App\Models\DeviceType::where('status', 'active')->orderBy('name')->get() as $deviceType)
                                                <option value="{{ $deviceType->id }}"
                                                        {{ request('device_type') == $deviceType->id ? 'selected' : '' }}>
                                                    {{ $deviceType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-4">
                                    <div class="form-group">
                                        <label for="status"><i class="fas fa-toggle-on"></i> Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">All Status</option>
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                                <i class="fas fa-check"></i> Active
                                            </option>
                                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                                <i class="fas fa-times"></i> Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-4">
                                    <div class="form-group">
                                        <label for="popular"><i class="fas fa-star"></i> Popular</label>
                                        <select name="popular" id="popular" class="form-control">
                                            <option value="">All Services</option>
                                            <option value="1" {{ request('popular') == '1' ? 'selected' : '' }}>Popular Only</option>
                                            <option value="0" {{ request('popular') == '0' ? 'selected' : '' }}>Non-Popular</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="btn-group d-block">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                            @if(request()->hasAny(['search', 'device_type', 'status', 'popular']))
                                                <a href="{{ route('repair-services.index') }}" class="btn btn-secondary">
                                                    <i class="fas fa-times"></i> Clear
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Active Filters Display -->
                    @if(request()->hasAny(['search', 'device_type', 'status', 'popular']))
                        <div class="card-header border-0 pt-2 pb-1 bg-light">
                            <div class="d-flex align-items-center flex-wrap">
                                <span class="text-muted mr-2"><i class="fas fa-filter"></i> Active filters:</span>

                                @if(request('search'))
                                    <span class="badge badge-secondary mr-1 mb-1">
                                        <i class="fas fa-search"></i> Search: "{{ request('search') }}"
                                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-white ml-1" title="Remove filter">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                @endif

                                @if(request('device_type'))
                                    @php
                                        $deviceTypeName = \App\Models\DeviceType::find(request('device_type'))->name ?? 'Unknown';
                                    @endphp
                                    <span class="badge badge-info mr-1 mb-1">
                                        <i class="fas fa-mobile-alt"></i> Device: {{ $deviceTypeName }}
                                        <a href="{{ request()->fullUrlWithQuery(['device_type' => null]) }}" class="text-white ml-1" title="Remove filter">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                @endif

                                @if(request('status'))
                                    <span class="badge badge-{{ request('status') == 'active' ? 'success' : 'danger' }} mr-1 mb-1">
                                        <i class="fas fa-{{ request('status') == 'active' ? 'check' : 'times' }}"></i>
                                        Status: {{ ucfirst(request('status')) }}
                                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-white ml-1" title="Remove filter">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                @endif

                                @if(request('popular'))
                                    <span class="badge badge-warning mr-1 mb-1">
                                        <i class="fas fa-star"></i> {{ request('popular') == '1' ? 'Popular Services' : 'Non-Popular Services' }}
                                        <a href="{{ request()->fullUrlWithQuery(['popular' => null]) }}" class="text-white ml-1" title="Remove filter">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Results Summary -->
                    <div class="card-header border-0 pt-1 pb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                @if($repairServices->total() > 0)
                                    <i class="fas fa-list"></i> Showing {{ $repairServices->firstItem() }} to {{ $repairServices->lastItem() }}
                                    of {{ $repairServices->total() }} results
                                @else
                                    <i class="fas fa-exclamation-circle"></i> No results found
                                @endif
                            </div>
                            <div class="text-right">
                                <small class="text-muted d-block">
                                    <i class="fas fa-tools text-primary"></i> Total: {{ $statistics['total'] ?? 0 }} |
                                    <i class="fas fa-check text-success"></i> Active: {{ $statistics['active'] ?? 0 }} |
                                    <i class="fas fa-star text-warning"></i> Popular: {{ $statistics['popular'] ?? 0 }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="8%">Image</th>
                                    <th width="25%">Service Name</th>
                                    <th width="12%">Device Type</th>
                                    <th width="8%">Price</th>
                                    <th width="8%">Cost</th>
                                    <th width="8%">Time</th>
                                    <th width="8%">Warranty</th>
                                    <th width="8%">Status</th>
                                    <th width="8%">Popular</th>
                                    <th width="5%">Order</th>
                                    <th width="12%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($repairServices as $service)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">#{{ $service->id }}</strong>
                                        </td>
                                        <td>
                                            <img src="{{ $service->image_url }}"
                                                 alt="{{ $service->service_name }}"
                                                 class="img-thumbnail shadow-sm"
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-dark">{{ $service->service_name }}</strong>
                                                @if($service->description)
                                                    <br><small class="text-muted">{{ Str::limit($service->description, 60) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                <i class="fas fa-mobile-alt"></i> {{ $service->deviceType->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-success">{{ $service->formatted_price }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $service->formatted_cost }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light">{{ $service->estimated_time_hours }}h</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-secondary">{{ $service->warranty_days }} days</span>
                                        </td>
                                        <td>{!! $service->status_badge !!}</td>
                                        <td>{!! $service->popular_badge !!}</td>
                                        <td>
                                            <span class="badge badge-outline-dark">{{ $service->display_order }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('repair-services.edit', $service) }}"
                                                   class="btn btn-info btn-sm"
                                                   title="Edit Service">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('repair-services.destroy', $service) }}"
                                                      method="POST"
                                                      style="display: inline-block;"
                                                      onsubmit="return confirm('Are you sure you want to delete this service?\n\nService: {{ $service->service_name }}\nThis action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Delete Service">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center py-5">
                                            <div class="alert alert-info mb-0 border-0">
                                                <i class="fas fa-info-circle fa-3x mb-3 text-info"></i>
                                                <h5 class="text-info">No repair services found</h5>
                                                @if(request()->hasAny(['search', 'device_type', 'status', 'popular']))
                                                    <p class="mb-3">
                                                        No services match your current filters.
                                                        <a href="{{ route('repair-services.index') }}" class="alert-link">
                                                            <i class="fas fa-times"></i> Clear all filters
                                                        </a> to see all services.
                                                    </p>
                                                @endif
                                                <a href="{{ route('repair-services.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus"></i> Create Your First Service
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($repairServices->hasPages())
                        <div class="card-footer clearfix">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Page {{ $repairServices->currentPage() }} of {{ $repairServices->lastPage() }}
                                </div>
                                <div>
                                    {{ $repairServices->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .badge-outline-dark {
        color: #343a40;
        border: 1px solid #343a40;
        background-color: transparent;
    }

    .card-outline-primary {
        border-top: 3px solid #007bff;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .img-thumbnail {
        transition: transform 0.2s;
    }

    .img-thumbnail:hover {
        transform: scale(1.1);
    }

    .badge {
        font-size: 0.75em;
    }

    .btn-group .btn {
        margin-right: 2px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .alert-dismissible .close {
        padding: 0.75rem 1.25rem;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form when basic filters change
    $('#device_type, #status, #popular').on('change', function() {
        $('#filterForm').submit();
    });

    // Enhanced search with Enter key
    $('#search').on('keypress', function(e) {
        if (e.which === 13) {
            $('#filterForm').submit();
        }
    });

    // Clear individual filter functionality
    $('.badge a').on('click', function(e) {
        e.preventDefault();
        window.location.href = $(this).attr('href');
    });

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').fadeOut('slow');
    }, 5000);

    // Tooltip initialization
    $('[title]').tooltip();

    // Image hover effect
    $('.img-thumbnail').hover(
        function() {
            $(this).addClass('shadow');
        },
        function() {
            $(this).removeClass('shadow');
        }
    );
});

// Loading state for form submissions
$('#filterForm').on('submit', function() {
    var $submitBtn = $(this).find('button[type="submit"]');
    $submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Filtering...');
    $submitBtn.prop('disabled', true);
});
</script>
@endpush
