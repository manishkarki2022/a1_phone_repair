@extends('admin.layouts.app')

@section('title', 'Edit Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Booking: {{ $customerBooking->booking_number }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer-bookings.update', $customerBooking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Customer Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Customer Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="customer_name">Customer Name *</label>
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $customerBooking->customer_name) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_email">Email *</label>
                                            <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email', $customerBooking->customer_email) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_phone">Phone *</label>
                                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $customerBooking->customer_phone) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_address">Address</label>
                                            <textarea class="form-control" id="customer_address" name="customer_address" rows="2">{{ old('customer_address', $customerBooking->customer_address) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_city">City</label>
                                            <input type="text" class="form-control" id="customer_city" name="customer_city" value="{{ old('customer_city', $customerBooking->customer_city) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Device Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Device Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="device_category_id">Device Category</label>
                                            <select class="form-control" id="device_category_id" name="device_category_id">
                                                <option value="">Select Category</option>
                                                @foreach($deviceCategories as $category)
                                                <option value="{{ $category->id }}" {{ old('device_category_id', $customerBooking->device_category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="device_type_id">Device Type</label>
                                            <select class="form-control" id="device_type_id" name="device_type_id">
                                                <option value="">Select Type</option>
                                                @foreach($deviceTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('device_type_id', $customerBooking->device_type_id) == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="device_brand">Brand</label>
                                            <input type="text" class="form-control" id="device_brand" name="device_brand" value="{{ old('device_brand', $customerBooking->device_brand) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="device_model">Model</label>
                                            <input type="text" class="form-control" id="device_model" name="device_model" value="{{ old('device_model', $customerBooking->device_model) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="device_condition">Condition</label>
                                            <textarea class="form-control" id="device_condition" name="device_condition" rows="2">{{ old('device_condition', $customerBooking->device_condition) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Service Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Service Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="repair_service_id">Repair Service</label>
                                           <select class="form-control" id="repair_service_id" name="repair_service_id">
                                                <option value="">Select Service</option>
                                                @foreach($repairServices as $service)
                                                <option value="{{ $service->id }}" {{ old('repair_service_id', $customerBooking->repair_service_id) == $service->id ? 'selected' : '' }}>
                                                    {{ $service->deviceType->name }} - {{ $service->service_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="custom_repair_description">Custom Service Description</label>
                                            <textarea class="form-control" id="custom_repair_description" name="custom_repair_description" rows="2">{{ old('custom_repair_description', $customerBooking->custom_repair_description) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="device_issue_description">Issue Description *</label>
                                            <textarea class="form-control" id="device_issue_description" name="device_issue_description" rows="3" required>{{ old('device_issue_description', $customerBooking->device_issue_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Scheduling & Status -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Scheduling & Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="preferred_date">Preferred Date *</label>
                                            <input type="date" class="form-control" id="preferred_date" name="preferred_date" value="{{ old('preferred_date', $customerBooking->preferred_date->format('Y-m-d')) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="preferred_time_slot">Preferred Time Slot *</label>
                                            <select class="form-control" id="preferred_time_slot" name="preferred_time_slot" required>
                                                <option value="morning" {{ old('preferred_time_slot', $customerBooking->preferred_time_slot) == 'morning' ? 'selected' : '' }}>Morning (9AM - 12PM)</option>
                                                <option value="afternoon" {{ old('preferred_time_slot', $customerBooking->preferred_time_slot) == 'afternoon' ? 'selected' : '' }}>Afternoon (12PM - 5PM)</option>
                                                <option value="evening" {{ old('preferred_time_slot', $customerBooking->preferred_time_slot) == 'evening' ? 'selected' : '' }}>Evening (5PM - 8PM)</option>
                                                <option value="anytime" {{ old('preferred_time_slot', $customerBooking->preferred_time_slot) == 'anytime' ? 'selected' : '' }}>Anytime</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="preferred_time">Specific Time (optional)</label>
                                            <input type="time" class="form-control" id="preferred_time" name="preferred_time" value="{{ old('preferred_time', $customerBooking->preferred_time ? date('H:i', strtotime($customerBooking->preferred_time)) : '') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmed_date">Confirmed Date</label>
                                            <input type="date" class="form-control" id="confirmed_date" name="confirmed_date" value="{{ old('confirmed_date', $customerBooking->confirmed_date ? $customerBooking->confirmed_date->format('Y-m-d') : '') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmed_time">Confirmed Time</label>
                                            <input type="time" class="form-control" id="confirmed_time" name="confirmed_time" value="{{ old('confirmed_time', $customerBooking->confirmed_time ? date('H:i', strtotime($customerBooking->confirmed_time)) : '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Status -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Pricing & Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="status">Status *</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="pending" {{ old('status', $customerBooking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ old('status', $customerBooking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="in_progress" {{ old('status', $customerBooking->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="ready_for_pickup" {{ old('status', $customerBooking->status) == 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                                                <option value="completed" {{ old('status', $customerBooking->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ old('status', $customerBooking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                <option value="rejected" {{ old('status', $customerBooking->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="priority">Priority *</label>
                                            <select class="form-control" id="priority" name="priority" required>
                                                <option value="low" {{ old('priority', $customerBooking->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                                <option value="normal" {{ old('priority', $customerBooking->priority) == 'normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="high" {{ old('priority', $customerBooking->priority) == 'high' ? 'selected' : '' }}>High</option>
                                                <option value="urgent" {{ old('priority', $customerBooking->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="admin_quoted_price">Quoted Price</label>
                                            <input type="number" step="0.01" class="form-control" id="admin_quoted_price" name="admin_quoted_price" value="{{ old('admin_quoted_price', $customerBooking->admin_quoted_price) }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="admin_final_price">Final Price</label>
                                            <input type="number" step="0.01" class="form-control" id="admin_final_price" name="admin_final_price" value="{{ old('admin_final_price', $customerBooking->admin_final_price) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Additional Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="estimated_completion_time">Estimated Completion</label>
                                            <input type="datetime-local" class="form-control" id="estimated_completion_time" name="estimated_completion_time" value="{{ old('estimated_completion_time', $customerBooking->estimated_completion_time ? $customerBooking->estimated_completion_time->format('Y-m-d\TH:i') : '') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="admin_notes">Admin Notes</label>
                                            <textarea class="form-control" id="admin_notes" name="admin_notes" rows="2">{{ old('admin_notes', $customerBooking->admin_notes) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="internal_repair_notes">Internal Repair Notes</label>
                                            <textarea class="form-control" id="internal_repair_notes" name="internal_repair_notes" rows="2">{{ old('internal_repair_notes', $customerBooking->internal_repair_notes) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Notes -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Customer Communication</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="customer_notes">Customer Notes</label>
                                            <textarea class="form-control" id="customer_notes" name="customer_notes" rows="2">{{ old('customer_notes', $customerBooking->customer_notes) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="special_instructions">Special Instructions</label>
                                            <textarea class="form-control" id="special_instructions" name="special_instructions" rows="2">{{ old('special_instructions', $customerBooking->special_instructions) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Update Booking</button>
                            <a href="{{ route('customer-bookings.show', $customerBooking) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Dynamic dropdown for device types based on category
    $('#device_category_id').change(function() {
        var categoryId = $(this).val();
        if (categoryId) {
            $.get('/api/device-types', { category_id: categoryId }, function(data) {
                $('#device_type_id').empty();
                $('#device_type_id').append('<option value="">Select Type</option>');
                $.each(data, function(key, value) {
                    $('#device_type_id').append('<option value="'+value.id+'">'+value.name+'</option>');
                });

                // Set the previously selected value if it exists for this category
                var oldValue = "{{ old('device_type_id', $customerBooking->device_type_id) }}";
                if (oldValue) {
                    $('#device_type_id').val(oldValue);
                }
            });
        } else {
            $('#device_type_id').empty();
            $('#device_type_id').append('<option value="">Select Type</option>');
        }
    });

    // Trigger the change event on page load if category is already selected
    @if($customerBooking->device_category_id)
        $('#device_category_id').trigger('change');
    @endif
</script>
@endsection
