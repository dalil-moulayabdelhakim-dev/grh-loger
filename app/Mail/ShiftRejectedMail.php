<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShiftRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $date;
    public $time;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct($date, $time, $reason)
    {
        $this->date = $date;
        $this->time = $time;
        $this->reason = $reason;
    }

    /**
     * Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: ' تم رفض طلب الوردية',
        );
    }

    /**
     * Content
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.shift_rejected',
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
