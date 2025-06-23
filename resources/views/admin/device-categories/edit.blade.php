{{-- resources/views/admin/device-categories/edit.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Edit Device Category')

@section('content')
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Device Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('device-categories.index') }}">Device Categories</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Validation Error!</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Success/Error Messages -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category Information</h3>
                        </div>

                        <form method="POST" action="{{ route('device-categories.update', $deviceCategory) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="card-body">

                                <!-- Category Name -->
                                <div class="form-group">
                                    <label for="name">Category Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $deviceCategory->name) }}"
                                           placeholder="Enter category name"
                                           required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="4"
                                              placeholder="Enter category description">{{ old('description', $deviceCategory->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Current Icon Display -->
                                @if($deviceCategory->icon)
                                    <div class="form-group">
                                        <label>Current Icon</label>
                                        <div class="border rounded p-3 bg-light d-inline-block">
                                            @if(str_starts_with($deviceCategory->icon, 'fa-') || str_starts_with($deviceCategory->icon, 'fas '))
                                                <i class="{{ $deviceCategory->icon }} fa-2x text-primary"></i>
                                                <br><small class="text-muted">{{ $deviceCategory->icon }}</small>
                                            @else
                                                <img src="{{ $deviceCategory->icon_url }}" alt="{{ $deviceCategory->name }}" style="max-width: 60px; max-height: 60px; object-fit: cover;">
                                                <br><small class="text-muted">Uploaded Image</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Icon Selection -->
                                <div class="form-group">
                                    <label>Update Category Icon</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Icon Type Selection -->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="icon_type"
                                                       id="icon_type_fa"
                                                       value="fontawesome"
                                                       {{ old('icon_type', (str_starts_with($deviceCategory->icon ?? '', 'fa-') || str_starts_with($deviceCategory->icon ?? '', 'fas ')) ? 'fontawesome' : 'fontawesome') === 'fontawesome' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="icon_type_fa">
                                                    Font Awesome Icon
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="icon_type"
                                                       id="icon_type_file"
                                                       value="file"
                                                       {{ old('icon_type') === 'file' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="icon_type_file">
                                                    Upload New Image
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="icon_type"
                                                       id="icon_type_keep"
                                                       value="keep"
                                                       {{ old('icon_type', 'keep') === 'keep' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="icon_type_keep">
                                                    Keep Current Icon
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Font Awesome Icon Input -->
                                    <div id="fontawesome_input" class="mt-2" style="display: none;">
                                        <input type="text"
                                               class="form-control @error('icon') is-invalid @enderror"
                                               id="icon"
                                               name="icon"
                                               value="{{ old('icon', (str_starts_with($deviceCategory->icon ?? '', 'fa-') || str_starts_with($deviceCategory->icon ?? '', 'fas ')) ? $deviceCategory->icon : 'fas fa-th-large') }}"
                                               placeholder="e.g., fas fa-mobile-alt">
                                        <small class="form-text text-muted">
                                            Enter Font Awesome class (e.g., fas fa-mobile-alt).
                                            <a href="https://fontawesome.com/icons" target="_blank">Browse icons</a>
                                        </small>
                                        @error('icon')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- File Upload Input -->
                                    <div id="file_input" class="mt-2" style="display: none;">
                                        <input type="file"
                                               class="form-control-file @error('icon_file') is-invalid @enderror"
                                               id="icon_file"
                                               name="icon_file"
                                               accept="image/*">
                                        <small class="form-text text-muted">
                                            Upload a new image file (JPEG, PNG, GIF, SVG). Max size: 2MB.
                                        </small>
                                        @error('icon_file')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Icon Preview -->
                                    <div id="icon_preview" class="mt-2" style="display: none;">
                                        <label class="form-label">Preview:</label>
                                        <div class="border rounded p-3 bg-light text-center" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <i id="preview_icon" class="fas fa-th-large fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Display Order -->
                                <div class="form-group">
                                    <label for="display_order">Display Order</label>
                                    <input type="number"
                                           class="form-control @error('display_order') is-invalid @enderror"
                                           id="display_order"
                                           name="display_order"
                                           value="{{ old('display_order', $deviceCategory->display_order) }}"
                                           min="0"
                                           placeholder="0">
                                    <small class="form-text text-muted">
                                        Lower numbers appear first in the list.
                                    </small>
                                    @error('display_order')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                        @foreach($statusOptions as $value => $label)
                                            <option value="{{ $value }}" {{ old('status', $deviceCategory->status) === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Update Category
                                </button>
                                <a href="{{ route('device-categories.show', $deviceCategory) }}" class="btn btn-info ml-2">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('device-categories.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar with category info and tips -->
                <div class="col-md-4">
                    <!-- Category Information -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Category Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    @if($deviceCategory->icon)
                                        @if(str_starts_with($deviceCategory->icon, 'fa-') || str_starts_with($deviceCategory->icon, 'fas '))
                                            <i class="{{ $deviceCategory->icon }}"></i>
                                        @else
                                            <img src="{{ $deviceCategory->icon_url }}" alt="{{ $deviceCategory->name }}" class="img-fluid">
                                        @endif
                                    @else
                                        <i class="fas fa-th-large"></i>
                                    @endif
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ $deviceCategory->name }}</span>
                                    <span class="info-box-number">{!! $deviceCategory->status_badge !!}</span>
                                </div>
                            </div>

                            <table class="table table-sm">
                                <tr>
                                    <td><strong>ID:</strong></td>
                                    <td>{{ $deviceCategory->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Display Order:</strong></td>
                                    <td>{{ $deviceCategory->display_order }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Device Types:</strong></td>
                                    <td>{{ $deviceCategory->device_types_count ?? $deviceCategory->deviceTypes()->count() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $deviceCategory->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $deviceCategory->updated_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Editing Tips</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Keep Current Icon:</strong> Select this option to maintain your existing icon without changes.
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Changing Icons:</strong> Uploading a new image will replace the current icon permanently.
                            </div>
                        </div>
                    </div>

                    <!-- Common Font Awesome Icons -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Common Icons</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4 mb-3 icon-option" style="cursor: pointer;">
                                    <i class="fas fa-mobile-alt fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-mobile-alt</small>
                                </div>
                                <div class="col-4 mb-3 icon-option" style="cursor: pointer;">
                                    <i class="fas fa-laptop fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-laptop</small>
                                </div>
                                <div class="col-4 mb-3 icon-option" style="cursor: pointer;">
                                    <i class="fas fa-tablet-alt fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-tablet-alt</small>
                                </div>
                                <div class="col-4 mb-3 icon-option" style="cursor: pointer;">
                                    <i class="fas fa-headphones fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-headphones</small>
                                </div>
                                <div class="col-4 mb-3 icon-option" style="cursor: pointer;">
                                    <i class="fas fa-tv fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-tv</small>
                                </div>
                                <div class="col-4 mb-3 icon-option" style="cursor: pointer;">
                                    <i class="fas fa-camera fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-camera</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Show/hide inputs based on selected icon type
    function toggleIconInputs() {
        var selectedType = $('input[name="icon_type"]:checked').val();

        $('#fontawesome_input, #file_input, #icon_preview').hide();

        if (selectedType === 'fontawesome') {
            $('#fontawesome_input').show();
            $('#icon_preview').show();
            updateIconPreview($('#icon').val());
        } else if (selectedType === 'file') {
            $('#file_input').show();
        }
        // For 'keep', we don't show any inputs
    }

    // Initialize on page load
    toggleIconInputs();

    // Toggle inputs when radio buttons change
    $('input[name="icon_type"]').change(function() {
        toggleIconInputs();

        if ($(this).val() !== 'fontawesome') {
            $('#icon').val(''); // Clear icon input if not using Font Awesome
        }
        if ($(this).val() !== 'file') {
            $('#icon_file').val(''); // Clear file input if not using file upload
        }
    });

    // Real-time icon preview
    $('#icon').on('input', function() {
        updateIconPreview($(this).val());
    });

    function updateIconPreview(iconClass) {
        if (iconClass) {
            $('#preview_icon').attr('class', iconClass + ' fa-2x text-primary');
        } else {
            $('#preview_icon').attr('class', 'fas fa-th-large fa-2x text-primary');
        }
    }

    // File upload preview
    $('#icon_file').change(function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#icon_preview').show();
                $('#preview_icon').replaceWith('<img id="preview_icon" src="' + e.target.result + '" class="img-fluid" style="max-width: 60px; max-height: 60px;">');
            };
            reader.readAsDataURL(file);
        }
    });

    // Copy icon class when clicking on common icons
    $('.icon-option').click(function() {
        var iconClass = $(this).find('small').text();
        $('#icon').val(iconClass);
        $('#icon_type_fa').prop('checked', true);
        toggleIconInputs();
        updateIconPreview(iconClass);
    });
});
</script>
@endpush
