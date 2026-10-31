<?php

namespace App\Mail;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Leave $leave,
        public string $status,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave request '.$this->status,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.leave-status',
        );
    }
}
