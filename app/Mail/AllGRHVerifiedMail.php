<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AllGRHVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $personName;
    public $startDate;
    public $endDate;
    public $totalTransactions;
    public $totalShifts;
    public $totalShiftCost;
    public $receivedAmount;

    /**
     * Create a new message instance.
     */
    public function __construct($personName, $startDate, $endDate, $totalTransactions, $totalShifts, $totalShiftCost, $receivedAmount)
    {
        $this->personName        = $personName;
        $this->startDate         = $startDate;
        $this->endDate           = $endDate;
        $this->totalTransactions = $totalTransactions;
        $this->totalShifts       = $totalShifts;
        $this->totalShiftCost    = $totalShiftCost;
        $this->receivedAmount    = $receivedAmount;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'تم استلام الحساب'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.all_grh_verified',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
