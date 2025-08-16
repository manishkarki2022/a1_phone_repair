<!DOCTYPE html>
<html lang="{{ websiteInfo()->default_language ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed #{{ $booking->booking_number }}| {{ websiteInfo()->website_name }}</title>
    <style>
        body {
            font-family: '{{ websiteInfo()->font_family ?? 'Segoe UI' }}', Tahoma, Geneva, Verdana, sans-serif;
            font-size: {{ websiteInfo()->font_size ?? '16px' }};
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
            text-align: center;
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
            flex-wrap: wrap;
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
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: {{ websiteInfo()->primary_color ?? '#3490dc' }};
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            margin: 15px 0;
        }
        .status-confirmed {
            color: #38a169 !important;
        }
        .store-info {
            background-color: #f0f7ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .instructions {
            background-color: #fff8f0;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        @media only screen and (max-width: 600px) {
            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        @if(websiteInfo()->logo_path)
            <img src="{{ asset('storage/' . websiteInfo()->logo_path) }}" alt="{{ websiteInfo()->website_name }}" class="logo">
        @else
            <h1>{{ websiteInfo()->website_name }}</h1>
            @if(websiteInfo()->slogan)
                <p>{{ websiteInfo()->slogan }}</p>
            @endif
        @endif
    </div>

    <h2>Dear {{ $booking->customer_name }},</h2>

    <p>Your booking with <strong>{{ websiteInfo()->website_name }}</strong> has been <strong class="status-confirmed">confirmed</strong>! Please visit our store at the scheduled time below:</p>

    <div class="booking-details">
        <h3 style="margin-top: 0;">Booking Details</h3>

        <div class="detail-row">
            <span class="detail-label">Booking Number:</span>
            <span>{{ $booking->booking_number }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Service Date:</span>
            <span>{{ \Carbon\Carbon::parse($booking->confirmed_date)->format('l, F j, Y') }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Arrival Time:</span>
            <span>{{ \Carbon\Carbon::parse($booking->confirmed_time)->format('g:i A') }}</span>
        </div>

        @if($booking->estimated_completion_time)
        <div class="detail-row">
            <span class="detail-label">Estimated Ready By:</span>
            <span>{{ \Carbon\Carbon::parse($booking->estimated_completion_time)->format('l, F j, Y \a\t g:i A') }}</span>
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
            <span class="status-confirmed" style="font-weight: 600;">Confirmed</span>
        </div>
    </div>

    <div class="store-info">
        <h3 style="margin-top: 0;">Store Information</h3>
        <p><strong>Please visit us at:</strong></p>
        <p>
            {{ websiteInfo()->address }}<br>
            {{ websiteInfo()->city }}, {{ websiteInfo()->state }} {{ websiteInfo()->postal_code }}<br>
            {{ websiteInfo()->country }}
        </p>

        <p><strong>Store Hours:</strong><br>
            {!! nl2br(e(websiteInfo()->opening_hours)) !!}
            @if(websiteInfo()->special_hours)
                <br><br><strong>Special Hours:</strong><br>
                {!! nl2br(e(websiteInfo()->special_hours)) !!}
            @endif
        </p>

        @if(websiteInfo()->phone || websiteInfo()->mobile)
        <p><strong>Contact:</strong><br>
            @if(websiteInfo()->phone) Phone: {{ websiteInfo()->phone }}<br> @endif
            @if(websiteInfo()->mobile) Mobile: {{ websiteInfo()->mobile }} @endif
        </p>
        @endif
    </div>

    <div class="instructions">
        <h3 style="margin-top: 0;">What to Bring:</h3>
        <ul>
            <li>Your device needing repair</li>
            <li>Any power cables or accessories</li>
            <li>Proof of purchase (if applicable)</li>
            <li>This confirmation email or your booking number</li>
        </ul>

        <h3 style="margin-top: 20px;">Before You Visit:</h3>
        <ul>
            <li>Please arrive on time for your appointment</li>
            <li>Back up your device data if possible</li>
            <li>Remove any cases or screen protectors</li>
        </ul>
    </div>

    <p>If you need to reschedule or have any questions, please contact us:</p>
    <p>
        <strong>Email:</strong> <a href="mailto:{{ websiteInfo()->contact_email ?? websiteInfo()->email }}">{{ websiteInfo()->contact_email ?? websiteInfo()->email }}</a>
    </p>

    <center>
        <a href="{{ route('status', $booking->booking_number) }}" class="button">View Booking Status</a>
    </center>

    <div class="footer">
        <p>© {{ date('Y') }} {{ websiteInfo()->website_name }}. All rights reserved.</p>

        <div style="margin: 10px 0;">
            @if(websiteInfo()->facebook_url)
                <a href="{{ websiteInfo()->facebook_url }}" style="margin: 0 5px;">Facebook</a> |
            @endif
            @if(websiteInfo()->twitter_url)
                <a href="{{ websiteInfo()->twitter_url }}" style="margin: 0 5px;">Twitter</a> |
            @endif
            @if(websiteInfo()->instagram_url)
                <a href="{{ websiteInfo()->instagram_url }}" style="margin: 0 5px;">Instagram</a>
            @endif
        </div>

        <p>
            <a href="">Privacy Policy</a> |
            <a href="">Terms & Conditions</a>
        </p>
    </div>
</body>
</html>
