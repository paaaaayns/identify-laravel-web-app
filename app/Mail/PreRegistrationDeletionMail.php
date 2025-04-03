<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PreRegistrationDeletionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct() {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pre Registration Deleted!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.pre-registration.deletion',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
