@extends('admin.layouts.app')

@section('title', 'Banner Creation')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Create New Banner</h2>
        </div>
        <div class="card-body">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-times-circle me-2"></i>
                        <h5 class="mb-0">Please fix the following errors:</h5>
                    </div>
                    <ul class="mt-2 mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="3">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="imageInput" name="image" required onchange="previewImage(event)">
                    <small class="text-muted">Allowed formats: jpeg, png, jpg, gif, webp. Max size: 2MB. Recommended dimensions: 1200x600px</small>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div class="mt-2 position-relative" id="imagePreviewContainer" style="display: none;">
                        <img id="imagePreview" src="#" alt="Image Preview" class="img-thumbnail" style="max-height: 200px;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1" onclick="removeImage()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="display_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', 0) }}" min="0">
                        @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch mt-4 pt-2">
                            <input type="hidden" name="is_hero_slide" value="0">
                            <input class="form-check-input" type="checkbox" id="is_hero_slide" name="is_hero_slide" value="1" {{ old('is_hero_slide', false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_hero_slide">Hero Slide</label>
                        </div>
                        @error('is_hero_slide')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Active</label>
                    @error('is_active')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('banners.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to List
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Create Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview selected image
function previewImage(event) {
    const input = event.target;
    const previewContainer = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Remove selected image
function removeImage() {
    const input = document.getElementById('imageInput');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');

    input.value = '';
    previewContainer.style.display = 'none';
    preview.src = '#';
}

// Initialize old image preview if validation fails
document.addEventListener('DOMContentLoaded', function() {
    @if(old('image_preview'))
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        preview.src = '{{ old('image_preview') }}';
        previewContainer.style.display = 'block';
    @endif
});
</script>

<style>
/* Alert styling */
.alert {
    border-left: 4px solid;
}

.alert-success {
    border-left-color: #28a745;
}

.alert-danger {
    border-left-color: #dc3545;
}

/* Image preview styling */
#imagePreviewContainer {
    display: inline-block;
    max-width: 100%;
    position: relative;
}

#imagePreview {
    max-height: 200px;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
}

/* Form validation */
.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875em;
}
</style>
@endsection
