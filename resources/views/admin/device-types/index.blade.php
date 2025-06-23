@extends('admin.layouts.app')

@section('title', 'Device Types')

@section('content')
<div class="container-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Device Types</h1>
        <a href="{{ route('device-types.create') }}" class="btn btn-primary">Create New</a>
    </div>

    <!-- Search and Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('device-types.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="search" class="form-label">Search</label>
                        <div class="input-group">
                            <input type="text"
                                   class="form-control"
                                   id="search"
                                   name="search"
                                   placeholder="Search by name, brand, model or category..."
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Search
                            </button>
                            @if(request()->has('search') || request()->has('status'))
                                <a href="{{ route('device-types.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fas fa-filter"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="card">
        <div class="card-body">
            @if($deviceTypes->isEmpty())
                <div class="alert alert-info">
                    @if(request()->has('search') || request()->has('status'))
                        No device types found matching your criteria.
                    @else
                        No device types available. <a href="{{ route('device-types.create') }}">Create one now</a>.
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand/Model</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deviceTypes as $deviceType)
                            <tr>
                                <td>{{ ($deviceTypes->currentPage() - 1) * $deviceTypes->perPage() + $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $deviceType->image_url }}"
                                         alt="{{ $deviceType->name }}"
                                         width="50"
                                         class="img-thumbnail rounded">
                                </td>
                                <td>{{ $deviceType->name }}</td>
                                <td>{{ $deviceType->category->name }}</td>
                                <td>
                                    @if($deviceType->brand)
                                        <strong>{{ $deviceType->brand }}</strong>
                                        @if($deviceType->model)
                                            <span class="text-muted">/ {{ $deviceType->model }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $deviceType->display_order }}</td>
                                <td>
                                    <span class="badge bg-{{ $deviceType->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($deviceType->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('device-types.edit', $deviceType->id) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('device-types.destroy', $deviceType->id) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this device type?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination with query parameters -->
                <div class="mt-4">
                    {{ $deviceTypes->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
