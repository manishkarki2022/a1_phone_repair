@extends('admin.layouts.app')

@section('title', 'Device Types Create')

@extends('admin.layouts.app')

@section('title', 'Device Types Create')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Create New Device Type</h3>
                    <div class="card-tools">
                        <a href="{{ route('device-types.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('device-types.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Category Field -->
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Name Field -->
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Brand Field with Dynamic Select2 -->
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <select class="form-control select2-brand @error('brand') is-invalid @enderror"
                                            id="brand" name="brand" data-placeholder="Type or select brand">
                                        @if(old('brand'))
                                            <option value="{{ old('brand') }}" selected>{{ old('brand') }}</option>
                                        @endif
                                    </select>
                                    @error('brand')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">You can select an existing brand or type a new one</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Model Field with Dynamic Select2 -->
                                <div class="form-group">
                                    <label for="model">Model</label>
                                    <select class="form-control select2-model @error('model') is-invalid @enderror"
                                            id="model" name="model" data-placeholder="Type or select model">
                                        @if(old('model'))
                                            <option value="{{ old('model') }}" selected>{{ old('model') }}</option>
                                        @endif
                                    </select>
                                    @error('model')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">Models are filtered by selected brand. You can also create new ones</small>
                                </div>

                                <!-- Image Field -->
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                               id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    @error('image')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Display Order Field -->
                                <div class="form-group">
                                    <label for="display_order">Display Order</label>
                                    <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                                           id="display_order" name="display_order" value="{{ old('display_order', 0) }}">
                                    @error('display_order')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status Field -->
                        <div class="form-group">
                            <label>Status</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="status"
                                       id="status_active" value="active" {{ old('status', 'active') === 'active' ? 'checked' : '' }}>
                                <label for="status_active" class="custom-control-label">Active</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" name="status"
                                       id="status_inactive" value="inactive" {{ old('status') === 'inactive' ? 'checked' : '' }}>
                                <label for="status_inactive" class="custom-control-label">Inactive</label>
                            </div>
                            @error('status')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Save
                            </button>
                            <a href="{{ route('device-types.index') }}" class="btn btn-secondary float-right">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('customJs')


<script>
$(document).ready(function() {
    // Initialize Brand Select2
    $('.select2-brand').select2({
        theme: 'bootstrap4',
        placeholder: 'Type or select brand',
        allowClear: true,
        tags: true,
        tokenSeparators: [','],
        ajax: {
           url: '{{ url("admin/device-types/brands") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
                return null;
            }

            return {
                id: term,
                text: term,
                newTag: true
            };
        },
        templateResult: function (data) {
            var $result = $('<span></span>');
            $result.text(data.text);

            if (data.newTag) {
                $result.append(' <em style="color: #007bff;">(new)</em>');
            }

            return $result;
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });

    // Initialize Model Select2
    $('.select2-model').select2({
        theme: 'bootstrap4',
        placeholder: 'Type or select model',
        allowClear: true,
        tags: true,
        tokenSeparators: [','],
        ajax: {
            url: '{{ url("admin/device-types/models") }}',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    brand: $('#brand').val(),
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
                return null;
            }

            return {
                id: term,
                text: term,
                newTag: true
            };
        },
        templateResult: function (data) {
            var $result = $('<span></span>');
            $result.text(data.text);

            if (data.newTag) {
                $result.append(' <em style="color: #007bff;">(new)</em>');
            }

            return $result;
        },
        escapeMarkup: function (markup) {
            return markup;
        }
    });

    // When brand changes, refresh model options
    $('#brand').on('change', function() {
        var modelSelect = $('#model');
        modelSelect.val(null).trigger('change');

        // Clear Select2 cache
        modelSelect.select2('destroy');

        // Reinitialize with new brand filter
        modelSelect.select2({
            theme: 'bootstrap4',
            placeholder: 'Type or select model',
            allowClear: true,
            tags: true,
            tokenSeparators: [','],
            ajax: {
                url: "{{ route('device-types.models') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        brand: $('#brand').val(),
                        page: params.page || 1
                    };
                },
                processResults: function (data, params) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            },
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') return null;
                return { id: term, text: term, newTag: true };
            },
            templateResult: function (data) {
                var $result = $('<span></span>');
                $result.text(data.text);
                if (data.newTag) {
                    $result.append(' <em style="color: #007bff;">(new)</em>');
                }
                return $result;
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    });

    // File input label update
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>
@endsection





