<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\CustomerBooking;

class DeviceReadyForPickup extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new message instance.
     */
      use Queueable, SerializesModels;



    public function __construct(CustomerBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject(subject: 'Device Ready for Pickup - Booking #' . $this->booking->booking_number,)
                    ->view(view: 'mails.device-ready');
    }

}
