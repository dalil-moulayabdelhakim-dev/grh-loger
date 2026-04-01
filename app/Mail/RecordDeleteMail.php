<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecordDeleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $amount;
    public $type;
    public $date;
    public $time;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $amount, $type, $date, $time)
    {
        $this->name   = $name;
        $this->amount = $amount;
        $this->type   = $type;
        $this->date   = $date;
        $this->time   = $time;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '❌ حذف معاملة',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.record_deleted',
            // with: [
            //     'name'   => $this->name,
            //     'amount' => $this->amount,
            //     'type'   => $this->type,
            //     'date'   => $this->date,
            //     'time'   => $this->time,
            // ]
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
