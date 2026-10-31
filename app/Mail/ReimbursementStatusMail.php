<?php

namespace App\Mail;

use App\Models\Reimbursement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReimbursementStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Reimbursement $reimbursement,
        public string $status,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reimbursement request '.$this->status,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.reimbursement-status',
        );
    }
}
