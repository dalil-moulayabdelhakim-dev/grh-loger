<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShiftApproverMail extends Mailable
{
    use Queueable, SerializesModels;

    public $date;
    public $time;

    /**
     * Create a new message instance.
     */
    public function __construct($date, $time)
    {
        $this->date = $date;
        $this->time = $time;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ' تم قبول طلب الوردية',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.shift_approved',
        );
    }

    /**
     * Attachments
     */
    public function attachments(): array
    {
        return [];
    }
}
