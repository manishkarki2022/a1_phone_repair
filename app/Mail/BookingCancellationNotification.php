<?php

namespace App\Mail;

use App\Models\CustomerBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCancellationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    // Changed: Only accept booking parameter
    public function __construct(CustomerBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Your Booking #'.$this->booking->booking_number.' Has Been Cancelled')
                    ->markdown('mails.booking-cancellation')
                    ->with([
                        'booking' => $this->booking,
                        'reason' => $this->booking->cancel_note // Get reason from booking
                    ]);
    }
}
