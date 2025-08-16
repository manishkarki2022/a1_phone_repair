<!DOCTYPE html>
<html>
<head>
    <title>Service Completed - Booking #{{ $booking->booking_number }}</title>
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
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .content {
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #38a169;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 15px 0;
        }
        .details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Your Repair Service is Complete!</h2>
        <p>Booking #{{ $booking->booking_number }}</p>
    </div>

    <div class="content">
        <p>Dear {{ $booking->customer_name }},</p>

        <p>We're pleased to inform you that your repair service has been successfully completed.</p>

        <div class="details">
            <h3>Service Details:</h3>
            <ul>
                <li><strong>Device:</strong> {{ $booking->device_brand }} {{ $booking->device_model }}</li>
                <li><strong>Service:</strong> {{ $booking->repairService->service_name ?? 'N/A' }}</li>
                <li><strong>Completed On:</strong> {{ $booking->completed_at->format('F j, Y g:i A') }}</li>
                @if($booking->admin_final_price)
                <li><strong>Final Amount:</strong> {{ config('settings.currency_symbol') }}{{ number_format($booking->admin_final_price, 2) }}</li>
                @endif
            </ul>
        </div>


        <center>
            <a href="{{ route('status', $booking->booking_number) }}" class="button">
                View Booking Details
            </a>
        </center>
    </div>

    <div class="footer">
        <p>{{ websiteInfo()->website_name }} - {{ websiteInfo()->address }}, {{ websiteInfo()->city }}</p>
        <p>Contact us at {{ websiteInfo()->phone }} or <a href="mailto:{{ websiteInfo()->email }}">{{ websiteInfo()->email }}</a></p>
        <p>© {{ date('Y') }} {{ websiteInfo()->website_name }}. All rights reserved.</p>
    </div>
</body>
</html>

