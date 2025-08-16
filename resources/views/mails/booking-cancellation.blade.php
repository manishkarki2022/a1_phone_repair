
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Cancellation Notification</title>
    <style>
        /* Main email styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #e74c3c;
            color: white;
            padding: 25px;
            text-align: center;
        }
        .email-body {
            padding: 30px;
        }
        .email-footer {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .divider {
            border-top: 1px solid #eee;
            margin: 25px 0;
        }

        /* Typography */
        h1 {
            color: #e74c3c;
            font-size: 24px;
            margin-top: 0;
        }
        h2 {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        p {
            margin-bottom: 15px;
        }

        /* Components */
        .alert-box {
            background-color: #f8d7da;
            border-left: 4px solid #e74c3c;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .info-card {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: 600;
            width: 120px;
            color: #555;
        }
        .info-value {
            flex: 1;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 600;
            margin-top: 15px;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }
            .info-row {
                flex-direction: column;
            }
            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Booking Cancellation Notice</h1>
            <p>We regret to inform you about changes to your booking</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="alert-box">
                <h2 style="color: #e74c3c; margin-top: 0;">
                    <i class="fas fa-exclamation-triangle"></i> Your booking has been cancelled
                </h2>
                <p><strong>Cancellation Reason:</strong> {{ $booking->cancel_note }}</p>
            </div>

            <h2>Booking Details</h2>
            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">Booking Number:</span>
                    <span class="info-value">{{ $booking->booking_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Customer Name:</span>
                    <span class="info-value">{{ $booking->customer_name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Device:</span>
                    <span class="info-value">
                        {{ $booking->device_brand }} {{ $booking->device_model }}
                        @if($booking->device_type)
                            ({{ $booking->device_type->name }})
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Issue:</span>
                    <span class="info-value">{{ $booking->device_issue_description }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value" style="color: #e74c3c; font-weight: 600;">Cancelled</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Cancellation Date:</span>
                    <span class="info-value">{{ now()->format('F j, Y \a\t g:i A') }}</span>
                </div>
            </div>

            @if($booking->admin_final_price > 0)
            <div class="info-card" style="background-color: #e8f4fd;">
                <h2 style="margin-top: 0;">Refund Information</h2>
                <div class="info-row">
                    <span class="info-label">Amount Paid:</span>
                    <span class="info-value">${{ number_format($booking->admin_final_price, 2) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Refund Status:</span>
                    <span class="info-value">Processing (3-5 business days)</span>
                </div>
                <p style="font-size: 13px; margin-top: 10px; margin-bottom: 0;">
                    The refund will be credited back to your original payment method.
                </p>
            </div>
            @endif

            <div class="divider"></div>

            <h2>Next Steps</h2>
            <p>We apologize for any inconvenience this may have caused. If you would like to:</p>
            <ul style="padding-left: 20px; margin-bottom: 20px;">
                <li>Reschedule your booking</li>
                <li>Get more information about this cancellation</li>
                <li>Discuss alternative solutions</li>
            </ul>
            <p>Please don't hesitate to contact our support team.</p>

            <a href="{{ route('contact') }}" class="button">
                Contact Support Team
            </a>
        </div>

        <!-- Footer -->
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
    </div>
</body>
</html>
