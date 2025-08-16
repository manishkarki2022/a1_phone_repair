@extends('admin.layouts.app')

@section('title', 'View Contact Submission')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-md-8">
            <h1 class="h3"><i class="fas fa-envelope"></i> Contact Submission Details</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Submission Card -->
    <div class="card card-primary card-outline shadow-sm">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Submission Information</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Inquiry Type:</strong>
                    <p class="mb-0">{{ ucfirst($contact->inquiry_type) }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Status:</strong>
                    <p class="mb-0">
                        @if($contact->is_read)
                            <span class="badge bg-success">Read</span>
                        @else
                            <span class="badge bg-warning text-dark">Unread</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Name:</strong>
                    <p class="mb-0">{{ $contact->name }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Email:</strong>
                    <p class="mb-0">{{ $contact->email }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Phone:</strong>
                    <p class="mb-0">{{ $contact->phone ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <strong>Subject:</strong>
                    <p class="mb-0">{{ $contact->subject ?? '-' }}</p>
                </div>
            </div>

            <div class="mb-3">
                <strong>Message:</strong>
                <div class="border p-3 rounded bg-light">
                    <p class="mb-0">{{ $contact->message }}</p>
                </div>
            </div>

            <div class="mb-3">
                <strong>Received At:</strong>
                <p class="mb-0">{{ $contact->created_at->format('d M, Y H:i') }}</p>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 d-flex flex-wrap gap-2">
                @if(!$contact->is_read)
                    <form action="{{ route('contacts.markAsRead', $contact->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Mark as Read
                        </button>
                    </form>
                @endif

                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $contact->id }})">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>

                <!-- Hidden Delete Form -->
                <form id="delete-form-{{ $contact->id }}"
                      action="{{ route('contacts.destroy', $contact->id) }}"
                      method="POST"
                      style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
