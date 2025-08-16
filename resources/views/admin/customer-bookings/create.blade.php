@extends('admin.layouts.app')

@section('title', 'Create New Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Create New Booking</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer-bookings.store') }}" method="POST">
                        @csrf

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
                                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_email">Email *</label>
                                            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_phone">Phone *</label>
                                            <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_address">Address</label>
                                            <textarea class="form-control" id="customer_address" name="customer_address" rows="2"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_city">City</label>
                                            <input type="text" class="form-control" id="customer_city" name="customer_city">
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
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="device_type_id">Device Type</label>
                                            <select class="form-control" id="device_type_id" name="device_type_id">
                                                <option value="">Select Type</option>
                                                @foreach($deviceTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="device_brand">Brand</label>
                                            <input type="text" class="form-control" id="device_brand" name="device_brand">
                                        </div>
                                        <div class="form-group">
                                            <label for="device_model">Model</label>
                                            <input type="text" class="form-control" id="device_model" name="device_model">
                                        </div>
                                        <div class="form-group">
                                            <label for="device_condition">Condition</label>
                                            <textarea class="form-control" id="device_condition" name="device_condition" rows="2"></textarea>
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
                                     {{-- @dd($repairServices) --}}
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="repair_service_id">Repair Service</label>
                                            <select class="form-control" id="repair_service_id" name="repair_service_id">
                                                <option value="">Select Service</option>
                                                @foreach($repairServices as $service)
                                                <option value="{{ $service->id }}">{{ $service->deviceType->name }} - {{ $service->service_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="custom_repair_description">Custom Service Description</label>
                                            <textarea class="form-control" id="custom_repair_description" name="custom_repair_description" rows="2"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="device_issue_description">Issue Description *</label>
                                            <textarea class="form-control" id="device_issue_description" name="device_issue_description" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Scheduling & Priority -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Scheduling & Priority</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="preferred_date">Preferred Date *</label>
                                            <input type="date" class="form-control" id="preferred_date" name="preferred_date" min="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="preferred_time_slot">Preferred Time Slot *</label>
                                            <select class="form-control" id="preferred_time_slot" name="preferred_time_slot" required>
                                                <option value="morning">Morning (9AM - 12PM)</option>
                                                <option value="afternoon">Afternoon (12PM - 5PM)</option>
                                                <option value="evening">Evening (5PM - 8PM)</option>
                                                <option value="anytime">Anytime</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="preferred_time">Specific Time (optional)</label>
                                            <input type="time" class="form-control" id="preferred_time" name="preferred_time">
                                        </div>
                                        <div class="form-group">
                                            <label for="priority">Priority *</label>
                                            <select class="form-control" id="priority" name="priority" required>
                                                <option value="low">Low</option>
                                                <option value="normal" selected>Normal</option>
                                                <option value="high">High</option>
                                                <option value="urgent">Urgent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Additional Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="customer_notes">Customer Notes</label>
                                            <textarea class="form-control" id="customer_notes" name="customer_notes" rows="2"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="special_instructions">Special Instructions</label>
                                            <textarea class="form-control" id="special_instructions" name="special_instructions" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Create Booking</button>
                            <a href="{{ route('customer-bookings.index') }}" class="btn btn-secondary">Cancel</a>
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
            });
        } else {
            $('#device_type_id').empty();
            $('#device_type_id').append('<option value="">Select Type</option>');
        }
    });
</script>
@endsection
