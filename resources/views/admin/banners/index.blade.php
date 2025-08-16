@extends('admin.layouts.app')

@section('title', 'Banner Management')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Discount Banners</h1>
        <a href="{{ route('banners.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Banner
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="120">Image</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/'.$banner->image_path) }}"
                                     class="img-thumbnail"
                                     style="width: 100px; height: 60px; object-fit: cover;"
                                     alt="{{ $banner->title }}">
                            </td>
                            <td>{{ $banner->title }}</td>
                            <td>
                                <span class="badge {{ $banner->is_hero_slide ? 'bg-info' : 'bg-secondary' }}">
                                    {{ $banner->is_hero_slide ? 'Hero Slide' : 'Regular Banner' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $banner->display_order }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('banners.edit', $banner->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button class="btn btn-sm btn-outline-danger"
                                            title="Delete"
                                            onclick="confirmDelete({{ $banner->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-form-{{ $banner->id }}"
                                          action="{{ route('banners.destroy', $banner->id) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this banner?')) {
        event.preventDefault();
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .badge {
        font-size: 0.85em;
        font-weight: 500;
    }
</style>
@endsection
