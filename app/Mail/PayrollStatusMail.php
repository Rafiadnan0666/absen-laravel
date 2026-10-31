<?php

namespace App\Mail;

use App\Models\Payroll;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayrollStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Payroll $payroll,
        public string $status,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payroll '.$this->status,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.payroll-status',
        );
    }
}
