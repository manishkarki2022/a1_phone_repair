<!DOCTYPE html>
<html>
<head>
    <title>Repair Started - Booking #{{ $booking->booking_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3490dc;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            margin: 15px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Repair Work Started</h2>
    </div>

    <div class="content">
        <p>Dear {{ $booking->customer_name }},</p>

        <p>We have started working on your repair for booking #{{ $booking->booking_number }}.</p>

        <p><strong>Repair Details:</strong></p>
        <ul>
            <li>Device: {{ $booking->device_brand }} {{ $booking->device_model }}</li>
            {{-- <li>Issue: {{ $booking->device_issue_description }}</li> --}}
            <li>Repair Service: {{ $booking->repairService->name }}</li>
            <li>Estimated Completion: {{ $booking->estimated_completion_time ? $booking->estimated_completion_time->format('F j, Y') : 'N/A' }}</li>
            <li>Your note: {{$booking->custom_repair_description}}</li>
            <li>Started At: {{ $booking->started_at->format('F j, Y g:i A') }}</li>
            <li><strong>Admin Note: {{$booking->admin_notes}}</strong></li>
        </ul>

     <p><strong>What's happening now?</strong><br>
    We've completed diagnostic tests and are now performing the necessary repairs
    using genuine {{ $booking->device_brand }} parts.</p>

    <p><strong>Warranty:</strong><br>
    Your repair is covered by our {{ $booking->repairService->warranty_days ?? '30' }}-day
    warranty for parts and labor.</p>

    <p><strong>Need an update?</strong><br>
    Reply to this email or call {{ websiteInfo()->phone }} anytime.</p>
        <p>Thank you for choosing us for your repair needs!</p>

     <a href="{{ route('status', $booking->booking_number) }}" class="button">Track Your Booking Status</a>

      <div class="footer">
        <p>© {{ date('Y') }} {{ websiteInfo()->website_name }}. All rights reserved.</p>
        <p>
            {{ websiteInfo()->business_address }}<br>
            {{ websiteInfo()->business_city }}, {{ websiteInfo()->business_state }} {{ websiteInfo()->business_zip }}
        </p>
        <p>
            <a href="">Privacy Policy</a> |
            <a href="">Terms & Conditions</a>
        </p>
    </div>
</body>
</html>
