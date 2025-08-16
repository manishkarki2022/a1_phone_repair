<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CustomerBooking;

class RepairStarted extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(CustomerBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Repair Started - Booking #' . $this->booking->booking_number)
                    ->view('mails.repair-started');
    }
}
