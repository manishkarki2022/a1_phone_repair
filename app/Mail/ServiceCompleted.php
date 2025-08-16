<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\CustomerBooking;

class ServiceCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(CustomerBooking $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Service Completed - Booking #' . $this->booking->booking_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.service-completed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
