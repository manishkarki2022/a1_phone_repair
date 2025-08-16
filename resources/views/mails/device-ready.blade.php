<!DOCTYPE html>
<html>
<head>
    <title>Device Ready for Pickup - Booking #{{ $booking->booking_number }}</title>
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
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
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
        .price {
            font-size: 18px;
            font-weight: bold;
            color: #2d3748;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Your Device Is Ready for Pickup!</h2>
    </div>

    <div class="content">
        <p>Dear {{ $booking->customer_name }},</p>

        <p>We're pleased to inform you that your {{ $booking->device_brand }}
           {{ $booking->device_model }} is ready for pickup!</p>

        <p><strong>Repair Details:</strong></p>
        <ul>
            <li>Booking Number: #{{ $booking->booking_number }}</li>
            <li>Device: {{ $booking->device_brand }} {{ $booking->device_model }}</li>
            <li>Service: {{ $booking->repairService->service_name }}</li>
            @if($booking->admin_final_price)
            <li>
                Final Price:
                <span class="price">
                    {{ config('settings.currency_symbol') }}{{ number_format($booking->admin_final_price, 2) }}
                </span>
            </li>
            @endif
           <li>Marked Ready: {{ $booking->updated_at->format('F j, Y g:i A') }}</li>
        </ul>

        <p><strong>Pickup Information:</strong></p>
        <ul>
            <li>Location: {{ websiteInfo()->address }}, {{ websiteInfo()->city }}</li>
            {{-- <li>Hours: {!! nl2br(e(websiteInfo()->opening_hours)) !!}</li> --}}
            <li>Please bring your ID and this confirmation</li>
        </ul>

        <center>
            <a href="{{ route('status', $booking->booking_number) }}" class="button">
                View Complete Details
            </a>
        </center>


    </div>
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
