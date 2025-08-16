@extends('admin.layouts.app')

@section('title', 'Device Types Edit')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Device Type</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('device-types.update', $deviceType->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $deviceType->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $deviceType->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand', $deviceType->brand) }}">
                            @error('brand')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $deviceType->model) }}">
                            @error('model')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            @if($deviceType->image)
                                <div class="mb-2">
                                    <img src="{{ $deviceType->image_url }}" alt="{{ $deviceType->name }}" width="100" class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="{{ old('display_order', $deviceType->display_order) }}">
                            @error('display_order')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_active" value="active" {{ old('status', $deviceType->status) === 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_active">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive" {{ old('status', $deviceType->status) === 'inactive' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_inactive">Inactive</label>
                            </div>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('device-types.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
