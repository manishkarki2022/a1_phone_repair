<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation #{{ $booking->booking_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            border-bottom: 1px solid #eeeeee;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        .booking-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .detail-row {
            margin-bottom: 10px;
            display: flex;
        }
        .detail-label {
            font-weight: 600;
            width: 150px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #777777;
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
    </style>
</head>
<body>
    <div class="header">
        @if(websiteInfo()->logo)
            <img src="{{ asset(websiteInfo()->logo) }}" alt="{{ websiteInfo()->website_name }}" class="logo">
        @else
            <h1>{{ websiteInfo()->website_name }}</h1>
        @endif
    </div>

    <h2>Dear {{ $booking->customer_name }},</h2>

    <p>Thank you for choosing {{ websiteInfo()->website_name }} for your repair needs. Your booking has been successfully received and is currently being processed.</p>

    <div class="booking-details">
        <h3 style="margin-top: 0;">Booking Summary</h3>

        <div class="detail-row">
            <span class="detail-label">Booking Number:</span>
            <span>{{ $booking->booking_number }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Service Date:</span>
            <span>{{ \Carbon\Carbon::parse($booking->preferred_date)->format('l, F j, Y') }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Time Slot:</span>
            <span>{{ ucfirst($booking->preferred_time_slot) }}</span>
        </div>

        @if($booking->preferred_time)
        <div class="detail-row">
            <span class="detail-label">Preferred Time:</span>
            <span>{{ \Carbon\Carbon::parse($booking->preferred_time)->format('g:i A') }}</span>
        </div>
        @endif

        @if($booking->admin_quoted_price)
        <div class="detail-row">
            <span class="detail-label">Estimated Cost:</span>
            <span>{{ config('settings.currency_symbol') }}{{ number_format($booking->admin_quoted_price, 2) }}</span>
        </div>
        @endif

        <div class="detail-row">
            <span class="detail-label">Status:</span>
            <span style="color: #3490dc; font-weight: 600;">{{ ucfirst($booking->status) }}</span>
        </div>
    </div>

    <h3>What Happens Next?</h3>
    <ol>
        <li>Our team will review your booking within 24 hours</li>
        <li>You'll receive a confirmation call/email to finalize details</li>
        <li>We'll provide updates on your repair progress</li>
    </ol>

    <p>If you need to modify your booking or have any questions, please contact our support team at <a href="mailto:{{ websiteInfo()->support_email }}">{{ websiteInfo()->support_email }}</a> or call us at {{ websiteInfo()->support_phone }}.</p>

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
