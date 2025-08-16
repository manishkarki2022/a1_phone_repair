<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $submission;
    protected $table = 'contact_submissions';

    public function __construct(ContactSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function build()
    {
        return $this->subject('New Contact Form Submission: ' . $this->submission->subject)
                    ->markdown('emails.contact-submission');
    }
}
