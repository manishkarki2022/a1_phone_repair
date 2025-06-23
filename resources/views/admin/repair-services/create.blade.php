@extends('admin.layouts.app')

@section('title', 'Create Repair Service')

@section('content_header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Repair Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('repair-services.index') }}">Repair Services</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add New Repair Service</h3>
                    </div>

                    <form action="{{ route('repair-services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Service Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_name">Service Name <span class="text-danger">*</span></label>
                                        <input type="text"
                                               class="form-control @error('service_name') is-invalid @enderror"
                                               id="service_name"
                                               name="service_name"
                                               value="{{ old('service_name') }}"
                                               placeholder="Enter service name"
                                               required>
                                        @error('service_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Device Type -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="device_type_id">Device Type <span class="text-danger">*</span></label>
                                        <select class="form-control @error('device_type_id') is-invalid @enderror"
                                                id="device_type_id"
                                                name="device_type_id"
                                                required>
                                            <option value="">Select Device Type</option>
                                            @foreach($deviceTypes as $deviceType)
                                                <option value="{{ $deviceType->id }}"
                                                        {{ old('device_type_id') == $deviceType->id ? 'selected' : '' }}>
                                                    {{ $deviceType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('device_type_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="3"
                                          placeholder="Enter service description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Admin Price -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="admin_price">Admin Price <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number"
                                                   step="0.01"
                                                   class="form-control @error('admin_price') is-invalid @enderror"
                                                   id="admin_price"
                                                   name="admin_price"
                                                   value="{{ old('admin_price') }}"
                                                   placeholder="0.00"
                                                   required>
                                            @error('admin_price')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Admin Cost -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="admin_cost">Admin Cost</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number"
                                                   step="0.01"
                                                   class="form-control @error('admin_cost') is-invalid @enderror"
                                                   id="admin_cost"
                                                   name="admin_cost"
                                                   value="{{ old('admin_cost') }}"
                                                   placeholder="0.00">
                                            @error('admin_cost')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Estimated Time -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="estimated_time_hours">Estimated Time (Hours) <span class="text-danger">*</span></label>
                                        <input type="number"
                                               class="form-control @error('estimated_time_hours') is-invalid @enderror"
                                               id="estimated_time_hours"
                                               name="estimated_time_hours"
                                               value="{{ old('estimated_time_hours') }}"
                                               placeholder="Hours"
                                               required>
                                        @error('estimated_time_hours')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Warranty Days -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="warranty_days">Warranty (Days) <span class="text-danger">*</span></label>
                                        <input type="number"
                                               class="form-control @error('warranty_days') is-invalid @enderror"
                                               id="warranty_days"
                                               name="warranty_days"
                                               value="{{ old('warranty_days', 30) }}"
                                               placeholder="Days"
                                               required>
                                        @error('warranty_days')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Display Order -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="display_order">Display Order <span class="text-danger">*</span></label>
                                        <input type="number"
                                               class="form-control @error('display_order') is-invalid @enderror"
                                               id="display_order"
                                               name="display_order"
                                               value="{{ old('display_order', 0) }}"
                                               placeholder="0"
                                               required>
                                        @error('display_order')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select class="form-control @error('status') is-invalid @enderror"
                                                id="status"
                                                name="status"
                                                required>
                                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Image Upload -->
                                <div class="form-group">
                                    <label for="image">Service Image</label>
                                    <input type="file"
                                        class="form-control-file @error('image') is-invalid @enderror"
                                        id="image"
                                        name="image"
                                        accept="image/*">
                                    @error('image')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Recommended size: square image (e.g., 300x300px)</small>
                                </div>

                                <!-- Is Popular -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="is_popular">Popular Service</label>
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   id="is_popular"
                                                   name="is_popular"
                                                   value="1"
                                                   {{ old('is_popular') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_popular">
                                                Mark as popular service
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Service
                            </button>
                            <a href="{{ route('repair-services.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
