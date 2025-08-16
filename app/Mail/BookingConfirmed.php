<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\CustomerBooking;

class BookingConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The booking instance.
     *
     * @var \App\Models\CustomerBooking
     */
    public $booking;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\CustomerBooking $booking
     */
    public function __construct(CustomerBooking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Confirmed - #' . $this->booking->id,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.booking-confirmed',
            with: [
                'booking' => $this->booking,
                'customer' => $this->booking->customer, // Make sure this relationship exists
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
