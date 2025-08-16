@extends('admin.layouts.app')

@section('title', 'Banner Edit')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Edit Banner</h2>
        </div>
        <div class="card-body">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    @if(session('updated_id'))
                        <span class="fw-bold">(ID: {{ session('updated_id') }})</span>
                    @endif
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

            <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           id="title" name="title"
                           value="{{ old('title', $banner->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control @error('content') is-invalid @enderror"
                              id="content" name="content" rows="3">{{ old('content', $banner->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="imageInput" name="image" onchange="previewImage(event)">
                    <small class="text-muted">Allowed formats: jpeg, png, jpg, gif, webp. Max size: 2MB</small>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <div class="mt-3">
                        <small class="text-muted">Current image:</small>
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('storage/'.$banner->image_path) }}"
                                 width="200" class="img-thumbnail mt-2" id="currentImage">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                    onclick="document.getElementById('imageInput').value = ''">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mt-2 position-relative" id="newImagePreviewContainer" style="display: none;">
                        <small class="text-muted">New image preview:</small>
                        <img id="newImagePreview" src="#" alt="New Image Preview"
                             class="img-thumbnail d-block mt-2" style="max-height: 200px;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                onclick="removeNewImage()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="display_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                               id="display_order" name="display_order"
                               value="{{ old('display_order', $banner->display_order) }}" min="0">
                        @error('display_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch mt-4 pt-2">
                            <input type="hidden" name="is_hero_slide" value="0">
                            <input class="form-check-input @error('is_hero_slide') is-invalid @enderror"
                                   type="checkbox" id="is_hero_slide" name="is_hero_slide" value="1"
                                   {{ old('is_hero_slide', $banner->is_hero_slide) ? 'checked' : '' }}>
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
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                               id="start_date" name="start_date"
                               value="{{ old('start_date', $banner->start_date ? $banner->start_date->format('Y-m-d') : '') }}">
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                               id="end_date" name="end_date"
                               value="{{ old('end_date', $banner->end_date ? $banner->end_date->format('Y-m-d') : '') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input @error('is_active') is-invalid @enderror"
                           type="checkbox" id="is_active" name="is_active" value="1"
                           {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
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
                        <i class="fas fa-save me-2"></i> Update Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview new selected image
function previewImage(event) {
    const input = event.target;
    const previewContainer = document.getElementById('newImagePreviewContainer');
    const preview = document.getElementById('newImagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Remove new selected image
function removeNewImage() {
    const input = document.getElementById('imageInput');
    const previewContainer = document.getElementById('newImagePreviewContainer');
    const preview = document.getElementById('newImagePreview');

    input.value = '';
    previewContainer.style.display = 'none';
    preview.src = '#';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // You can add any initialization code here if needed
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
#newImagePreviewContainer, #currentImage {
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

/* Position utilities */
.position-relative {
    position: relative;
}

.position-absolute {
    position: absolute;
}

.top-0 {
    top: 0;
}

.end-0 {
    right: 0;
}

.m-1 {
    margin: 0.25rem;
}
</style>
@endsection
