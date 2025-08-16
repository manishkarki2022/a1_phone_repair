@extends('admin.layouts.app')

@section('title', 'Contact Submissions')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-md-6">
            <h1 class="h3"><i class="fas fa-envelope"></i> Contact Submissions</h1>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Submissions Table -->
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Inquiry Type</th>
                        <th>Message</th>
                        <th>Received At</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr class="{{ $submission->is_read ? '' : 'fw-bold' }}">
                            <td>{{ $loop->iteration + ($submissions->currentPage()-1) * $submissions->perPage() }}</td>
                            <td>{{ $submission->name }}</td>
                            <td>{{ $submission->email }}</td>
                            <td>{{ ucfirst($submission->inquiry_type) }}</td>
                            <td>{{ Str::limit($submission->message, 50) }}</td>
                            <td>{{ $submission->created_at->format('d M, Y H:i') }}</td>
                            <td>
                                @if($submission->is_read)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-warning text-dark">Unread</span>
                                @endif
                            </td>
                            <td class="text-center d-flex justify-content-center gap-1">
                                <a href="{{ route('contacts.show', $submission->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> View
                                </a>

                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $submission->id }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <!-- Hidden Delete Form -->
                                <form id="delete-form-{{ $submission->id }}" action="{{ route('contacts.destroy', $submission->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No contact submissions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $submissions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
