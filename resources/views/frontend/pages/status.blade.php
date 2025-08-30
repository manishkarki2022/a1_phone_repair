@extends('frontend.layout.app')

@section('title', 'Check Repair Status')

@section('content')
<div class="status-container">
    <div class="status-card">
        <h2 class="status-header">Repair Status Check</h2>

        <div class="search-section">
            <div class="form-group">
                <label for="bookingNumber">Enter Your Booking Number</label>
                <div class="input-group">
                    <input type="text" id="bookingNumber" class="form-control" placeholder="BK202507270001" autocomplete="off">
                    <button id="checkBtn" class="btn btn-primary">
                        <span class="btn-text">Check Status</span>
                        <span class="btn-loading">
                            <i class="fas fa-spinner fa-spin"></i> Searching...
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <div id="statusResult" class="result-section" style="display: none;">
            <div class="repair-summary">
                <h3 class="summary-title">Repair Summary</h3>
                <div class="status-badge" id="statusBadge"></div>

                <div class="summary-grid">
                    <div class="summary-item">
                        <span class="summary-label">Booking Number:</span>
                        <span id="bookingNo" class="summary-value"></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Customer Name:</span>
                        <span id="customerName" class="summary-value"></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Device:</span>
                        <span id="deviceInfo" class="summary-value"></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Issue:</span>
                        <span id="problemInfo" class="summary-value"></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Status:</span>
                        <span id="statusInfo" class="summary-value"></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Priority:</span>
                        <span id="priorityInfo" class="summary-value"></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Estimated Price:</span>
                        {{-- <span id="estimatedPrice" class="summary-value"></span> --}}
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Final Price:</span>
                        <span id="finalPrice" class="summary-value"></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Estimated Completion:</span>
                        <span id="completionDate" class="summary-value"></span>
                    </div>
                </div>
            </div>

            <div class="timeline-section">
                <h4 class="timeline-title">Repair Timeline</h4>
                <div class="timeline" id="statusTimeline">
                    <!-- Timeline will be populated by JavaScript -->
                </div>
            </div>

            <div class="notes-section">
                <div class="notes-card">
                    <h5 class="notes-title">Customer Notes</h5>
                    <p id="customerNotes" class="notes-content"></p>
                </div>
                <div class="notes-card">
                    <h5 class="notes-title">Admin Notes</h5>
                    <p id="specialInstructions" class="notes-content"></p>
                </div>
            </div>
        </div>

        <div id="errorResult" class="error-section" style="display: none;">
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorMessage"></span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingNumberInput = document.getElementById('bookingNumber');
    const checkBtn = document.getElementById('checkBtn');
    const statusResult = document.getElementById('statusResult');
    const errorResult = document.getElementById('errorResult');

    // Check status when button is clicked
    checkBtn.addEventListener('click', checkStatus);

    // Also check when pressing Enter
    bookingNumberInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') checkStatus();
    });

    // Check if URL has booking number parameter
    const urlParams = new URLSearchParams(window.location.search);
    const bookingParam = urlParams.get('booking');
    if (bookingParam) {
        bookingNumberInput.value = bookingParam;
        checkStatus();
    }

    function checkStatus() {
        const bookingNumber = bookingNumberInput.value.trim();

        if (!bookingNumber) {
            showError('Please enter your booking number');
            return;
        }

        // Show loading state
        toggleLoading(true);

        // Make API request
        fetch(`/check-status/${bookingNumber}`)
            .then(response => {
                if (!response.ok) throw new Error('Booking not found');
                return response.json();
            })
            .then(data => displayStatus(data))
            .catch(error => showError(error.message))
            .finally(() => toggleLoading(false));
    }

    function displayStatus(data) {
        // Basic Information
        document.getElementById('bookingNo').textContent = data.booking_number;
        document.getElementById('customerName').textContent = data.customer_name;
        document.getElementById('deviceInfo').textContent = `${data.device_brand} ${data.device_model}`;
        document.getElementById('problemInfo').textContent = data.device_issue_description;
        document.getElementById('statusInfo').textContent = formatStatus(data.status);
        document.getElementById('priorityInfo').textContent = formatPriority(data.priority);
        // document.getElementById('estimatedPrice').textContent = data.admin_quoted_price ? `$${data.admin_quoted_price.toFixed(2)}` : 'Not quoted yet';
        document.getElementById('finalPrice').textContent = data.admin_final_price ? `$${data.admin_final_price.toFixed(2)}` : 'Not finalized';
        document.getElementById('completionDate').textContent = data.estimated_completion_time ? formatDate(data.estimated_completion_time) : 'To be determined';

        // Notes
        document.getElementById('customerNotes').textContent = data.custom_repair_description || 'No notes provided';
        document.getElementById('specialInstructions').textContent = data.admin_notes || 'No admin notes';

        // Status badge
        const statusBadge = document.getElementById('statusBadge');
        statusBadge.textContent = formatStatus(data.status);
        statusBadge.className = 'status-badge ' + getStatusClass(data.status);

        // Build timeline
        buildTimeline(data);

        // Show results
        statusResult.style.display = 'block';
        errorResult.style.display = 'none';

        // Update URL without reload
        history.pushState(null, '', `?booking=${data.booking_number}`);
    }

    function buildTimeline(data) {
        const timeline = document.getElementById('statusTimeline');
        timeline.innerHTML = '';

        // Add timeline items based on status changes
        const events = [
            { date: data.created_at, event: 'Booking Created', description: 'Repair request submitted' },
            data.confirmed_at && { date: data.confirmed_at, event: 'Booking Confirmed', description: 'Appointment confirmed' },
            data.started_at && { date: data.started_at, event: 'Repair Started', description: 'Technician began working' },
            data.completed_at && { date: data.completed_at, event: 'Repair Completed', description: 'Ready for pickup/delivery' }
        ].filter(Boolean);

        if (events.length === 0) {
            timeline.innerHTML = '<p>No timeline events yet</p>';
            return;
        }

        events.forEach(event => {
            const timelineItem = document.createElement('div');
            timelineItem.className = 'timeline-item';
            timelineItem.innerHTML = `
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <div class="timeline-date">${formatDateTime(event.date)}</div>
                    <h5>${event.event}</h5>
                    <p>${event.description}</p>
                </div>
            `;
            timeline.appendChild(timelineItem);
        });
    }

    function showError(message) {
        document.getElementById('errorMessage').textContent = message;
        errorResult.style.display = 'block';
        statusResult.style.display = 'none';
    }

    function toggleLoading(loading) {
        const btnText = checkBtn.querySelector('.btn-text');
        const btnLoading = checkBtn.querySelector('.btn-loading');

        if (loading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-block';
            checkBtn.disabled = true;
        } else {
            btnText.style.display = 'inline-block';
            btnLoading.style.display = 'none';
            checkBtn.disabled = false;
        }
    }

    // Helper functions
    function formatStatus(status) {
        const statusMap = {
            'pending': 'Pending',
            'confirmed': 'Confirmed',
            'in_progress': 'In Progress',
            'ready_for_pickup': 'Ready for Pickup',
            'completed': 'Completed',
            'cancelled': 'Cancelled'
        };
        return statusMap[status] || status;
    }

    function formatPriority(priority) {
        return priority.charAt(0).toUpperCase() + priority.slice(1);
    }

    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
    }

    function formatDateTime(dateString) {
        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return new Date(dateString).toLocaleDateString(undefined, options);
    }

    function getStatusClass(status) {
        const statusClasses = {
            'pending': 'status-pending',
            'confirmed': 'status-confirmed',
            'in_progress': 'status-in-progress',
            'ready_for_pickup': 'status-ready',
            'completed': 'status-completed',
            'cancelled': 'status-cancelled'
        };
        return statusClasses[status] || 'status-pending';
    }
});
</script>

<style>
.status-container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.status-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    padding: 2rem;
}

.status-header {
    text-align: center;
    margin-bottom: 2rem;
    color: #333;
    font-weight: 600;
}

.search-section {
    margin-bottom: 2rem;
}

.input-group {
    display: flex;
    max-width: 600px;
    margin: 0 auto;
}

.form-control {
    flex: 1;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px 0 0 6px;
    font-size: 16px;
}

.btn {
    padding: 12px 20px;
    background: #4a6cf7;
    color: white;
    border: none;
    border-radius: 0 6px 6px 0;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s;
}

.btn:hover {
    background: #3a5ce4;
}

.btn-loading {
    display: none;
}

.result-section {
    animation: fadeIn 0.5s ease-out;
}

.repair-summary {
    background: #f9fafc;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    position: relative;
}

.summary-title {
    margin-top: 0;
    color: #333;
    display: inline-block;
}

.status-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    margin-left: 15px;
    position: relative;
    top: -2px;
}

.status-pending { background: #ffc107; color: #333; }
.status-confirmed { background: #17a2b8; color: white; }
.status-in-progress { background: #007bff; color: white; }
.status-ready { background: #28a745; color: white; }
.status-completed { background: #6c757d; color: white; }
.status-cancelled { background: #dc3545; color: white; }

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.summary-item {
    display: flex;
    flex-direction: column;
}

.summary-label {
    font-size: 14px;
    color: #666;
    margin-bottom: 4px;
}

.summary-value {
    font-weight: 500;
    color: #333;
}

.timeline-section {
    margin-bottom: 2rem;
}

.timeline-title {
    color: #333;
    margin-bottom: 1rem;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #4a6cf7;
    border: 4px solid white;
    box-shadow: 0 0 0 2px #4a6cf7;
}

.timeline-content {
    padding: 10px 15px;
    background: white;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.timeline-date {
    font-size: 13px;
    color: #666;
    margin-bottom: 5px;
}

.timeline-content h5 {
    margin: 0 0 5px 0;
    font-size: 16px;
    color: #333;
}

.timeline-content p {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.notes-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.notes-card {
    background: white;
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 1.25rem;
}

.notes-title {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 16px;
    color: #333;
}

.notes-content {
    margin: 0;
    color: #555;
    font-size: 14px;
    line-height: 1.5;
}

.error-section {
    animation: fadeIn 0.3s ease-out;
}

.alert {
    padding: 15px;
    border-radius: 6px;
    display: flex;
    align-items: center;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert i {
    margin-right: 10px;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 768px) {
    .status-card {
        padding: 1.5rem;
    }

    .input-group {
        flex-direction: column;
    }

    .form-control {
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .btn {
        border-radius: 6px;
        width: 100%;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .notes-section {
        grid-template-columns: 1fr;
    }

    .timeline:before {
        left: 9px;
    }

    .timeline-marker {
        left: -20px;
        width: 18px;
        height: 18px;
    }
}
</style>
@endsection
