<?php

namespace App\Mail;

use App\Models\GoodMoralRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GoodMoralCompletedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    public function __construct(GoodMoralRequest $request)
    {
        $this->request = $request;
    }

    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Good Moral Certificate Completed - OSAS',
        );
    }

    public function content()
    {
        return new \Illuminate\Mail\Mailables\Content(
            view: 'emails.good-moral-completed',
        );
    }

    public function attachments()
    {
        return [];
    }
}
