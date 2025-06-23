{{-- resources/views/admin/device-categories/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Create Device Category')

@section('content')
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Device Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('device-categories.index') }}">Device Categories</a></li>
                        <li class="breadcrumb-item active">Create</li>
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

            <!-- Success Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Category Information</h3>
                        </div>

                        <form method="POST" action="{{ route('device-categories.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">

                                <!-- Category Name -->
                                <div class="form-group">
                                    <label for="name">Category Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
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
                                              placeholder="Enter category description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Icon Selection -->
                                <div class="form-group">
                                    <label>Category Icon</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Icon Type Selection -->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="icon_type"
                                                       id="icon_type_fa"
                                                       value="fontawesome"
                                                       {{ old('icon_type', 'fontawesome') === 'fontawesome' ? 'checked' : '' }}>
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
                                                    Upload Image
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Font Awesome Icon Input -->
                                    <div id="fontawesome_input" class="mt-2">
                                        <input type="text"
                                               class="form-control @error('icon') is-invalid @enderror"
                                               id="icon"
                                               name="icon"
                                               value="{{ old('icon', 'fas fa-th-large') }}"
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
                                            Upload an image file (JPEG, PNG, GIF, SVG). Max size: 2MB.
                                        </small>
                                        @error('icon_file')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Icon Preview -->
                                    <div id="icon_preview" class="mt-2">
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
                                           value="{{ old('display_order', 0) }}"
                                           min="0"
                                           placeholder="0">
                                    <small class="form-text text-muted">
                                        Leave 0 to auto-assign the next available order.
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
                                            <option value="{{ $value }}" {{ old('status', 'active') === $value ? 'selected' : '' }}>
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Create Category
                                </button>
                                <a href="{{ route('device-categories.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar with tips -->
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Tips</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-lightbulb"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Category Name</span>
                                    <span class="info-box-number">Keep it short and descriptive</span>
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-icons"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Icons</span>
                                    <span class="info-box-number">Use Font Awesome for consistency</span>
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-sort-numeric-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Display Order</span>
                                    <span class="info-box-number">Lower numbers appear first</span>
                                </div>
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
                                <div class="col-4 mb-3">
                                    <i class="fas fa-mobile-alt fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-mobile-alt</small>
                                </div>
                                <div class="col-4 mb-3">
                                    <i class="fas fa-laptop fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-laptop</small>
                                </div>
                                <div class="col-4 mb-3">
                                    <i class="fas fa-tablet-alt fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-tablet-alt</small>
                                </div>
                                <div class="col-4 mb-3">
                                    <i class="fas fa-headphones fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-headphones</small>
                                </div>
                                <div class="col-4 mb-3">
                                    <i class="fas fa-tv fa-2x text-primary mb-1"></i>
                                    <br><small>fas fa-tv</small>
                                </div>
                                <div class="col-4 mb-3">
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
    // Toggle between Font Awesome and File input
    $('input[name="icon_type"]').change(function() {
        if ($(this).val() === 'fontawesome') {
            $('#fontawesome_input').show();
            $('#file_input').hide();
            $('#icon_preview').show();
            $('#icon_file').val(''); // Clear file input
        } else {
            $('#fontawesome_input').hide();
            $('#file_input').show();
            $('#icon_preview').hide();
            $('#icon').val(''); // Clear icon input
        }
    });

    // Real-time icon preview
    $('#icon').on('input', function() {
        var iconClass = $(this).val();
        if (iconClass) {
            $('#preview_icon').attr('class', iconClass + ' fa-2x text-primary');
        } else {
            $('#preview_icon').attr('class', 'fas fa-th-large fa-2x text-primary');
        }
    });

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
    $('.card-secondary .col-4').click(function() {
        var iconClass = $(this).find('small').text();
        $('#icon').val(iconClass);
        $('#icon_type_fa').prop('checked', true).trigger('change');
        $('#preview_icon').attr('class', iconClass + ' fa-2x text-primary');
    });
});
</script>
@endpush
