<?php

namespace App\Mail;

use App\Models\Grievance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GrievanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $grievance;
    public $type; // 'new' or 'status_update'
    public $oldStatus;

    /**
     * Create a new message instance.
     */
    public function __construct(Grievance $grievance, string $type = 'new', ?string $oldStatus = null)
    {
        $this->grievance = $grievance;
        $this->type = $type;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->type === 'new'
            ? 'New Grievance Filed - ' . $this->grievance->case_id
            : 'Grievance Status Updated - ' . $this->grievance->case_id;

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.grievance-notification',
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
