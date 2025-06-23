{{-- resources/views/admin/device-categories/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Device Categories')

@section('content')
<div class="content-fluid">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Device Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Device Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Filters Card -->
            <div class="card card-secondary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i> Search & Filters
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('device-categories.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search categories..." value="{{ request('search') }}">
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form method="GET" action="{{ route('device-categories.index') }}">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-3">
                            @if(request()->has('search') || request()->has('status'))
                                <a href="{{ route('device-categories.index') }}" class="btn btn-default">
                                    <i class="fas fa-times-circle"></i> Clear Filters
                                </a>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('device-categories.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Categories Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-th-large"></i> Categories List
                        @if($categories->total() > 0)
                            <span class="badge badge-info ml-2">{{ $categories->total() }} Total</span>
                        @endif
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-secondary">{{ $categories->count() }} Showing</span>
                    </div>
                </div>

                <div class="card-body p-0">
                    <!-- Bulk Actions Form -->
                    <form id="bulk-action-form" method="POST" action="{{ route('device-categories.bulk-delete') }}">
                        @csrf


                         <!-- Bulk Delete Button -->
    <div class="row m-3">
        <div class="col-md-6">
            <button type="submit" class="btn btn-danger btn-sm" id="bulk-delete-btn">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
        <div class="col-md-6 text-right">
            <small class="text-muted">Select items below to delete</small>
        </div>
    </div>

                        <!-- Categories Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 40px;">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id="select-all">
                                                <label for="select-all"></label>
                                            </div>
                                        </th>
                                        <th style="width: 70px;" class="text-center">Icon</th>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                        <th style="width: 100px;" class="text-center">Order</th>
                                        <th style="width: 100px;" class="text-center">Types</th>
                                        <th style="width: 100px;" class="text-center">Status</th>
                                        <th style="width: 140px;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td>
                                                <div class="icheck-primary">
                                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}" class="category-checkbox">
                                                    <label for="category-{{ $category->id }}"></label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($category->icon)
                                                    @if(str_starts_with($category->icon, 'fa-') || str_starts_with($category->icon, 'fas '))
                                                        <span class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                            <i class="{{ $category->icon }} text-white"></i>
                                                        </span>
                                                    @else
                                                        <img src="{{ $category->icon_url }}" alt="{{ $category->name }}" class="img-circle elevation-2" style="width: 35px; height: 35px; object-fit: cover;">
                                                    @endif
                                                @else
                                                    <span class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                        <i class="fas fa-th-large text-white"></i>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="user-block">
                                                    <span class="username">
                                                        <strong>{{ $category->name }}</strong>
                                                    </span>
                                                    <span class="description">ID: {{ $category->id }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($category->description)
                                                    <span class="text-muted">{{ Str::limit($category->description, 60) }}</span>
                                                @else
                                                    <span class="text-muted font-italic">No description</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info badge-lg">{{ $category->display_order }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-primary badge-lg">{{ $category->device_types_count ?? 0 }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($category->status === 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('device-categories.edit', $category) }}" class="btn btn-warning btn-sm" title="Edit Category">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('device-categories.destroy', $category) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Category" onclick="return confirm('Are you sure you want to delete this category?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <div class="text-center py-5">
                                                    <div class="mb-3">
                                                        <i class="fas fa-th-large fa-4x text-muted"></i>
                                                    </div>
                                                    <h5 class="text-muted">No Categories Found</h5>
                                                    <p class="text-muted">
                                                        @if(request()->has('search') || request()->has('status'))
                                                            Try adjusting your search criteria or
                                                            <a href="{{ route('device-categories.index') }}">clear filters</a>
                                                        @else
                                                            Get started by creating your first device category
                                                        @endif
                                                    </p>
                                                    <a href="{{ route('device-categories.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i> Create Your First Category
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>

                <!-- Pagination Footer -->
                @if($categories->hasPages())
                    <div class="card-footer clearfix">
                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" role="status" aria-live="polite">
                                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} entries
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers float-right">
                                    {{ $categories->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Select all checkboxes functionality
    $('#select-all').change(function() {
        $('.category-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Update select all checkbox when individual checkboxes change
    $('.category-checkbox').change(function() {
        var totalCheckboxes = $('.category-checkbox').length;
        var checkedCheckboxes = $('.category-checkbox:checked').length;

        if (checkedCheckboxes === totalCheckboxes) {
            $('#select-all').prop('checked', true).prop('indeterminate', false);
        } else if (checkedCheckboxes === 0) {
            $('#select-all').prop('checked', false).prop('indeterminate', false);
        } else {
            $('#select-all').prop('checked', false).prop('indeterminate', true);
        }
    });

    // Bulk action form validation
    $('#bulk-action-form').submit(function(e) {
        var selectedAction = $('select[name="action"]').val();
        var selectedItems = $('.category-checkbox:checked').length;

        if (!selectedAction) {
            e.preventDefault();
            toastr.error('Please select an action from the dropdown.');
            return false;
        }

        if (selectedItems === 0) {
            e.preventDefault();
            toastr.error('Please select at least one category.');
            return false;
        }

        // Show confirmation message based on action
        var actionText = $('select[name="action"] option:selected').text();
        var confirmMessage = 'Are you sure you want to ' + actionText.toLowerCase() + ' ' + selectedItems + ' category(ies)?';

        if (!confirm(confirmMessage)) {
            e.preventDefault();
            return false;
        }
    });

    // Auto-expand filters if there are active filters
    @if(request()->has('search') || request()->has('status'))
        $('.card[data-card-widget="collapse"]').CardWidget('expand');
    @endif
});
</script>
@endpush
