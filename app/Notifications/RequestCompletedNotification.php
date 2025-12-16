<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestCompletedNotification extends Notification
{
    use Queueable;

    protected $requestType;
    protected $referenceNo;
    protected $viewUrl;

    public function __construct($requestType, $referenceNo, $viewUrl = null)
    {
        $this->requestType = $requestType;
        $this->referenceNo = $referenceNo;
        $this->viewUrl = $viewUrl;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Request Completed - ' . $this->requestType)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Good news! Your ' . $this->requestType . ' request has been completed.')
            ->line('Reference Number: ' . $this->referenceNo);

        if ($this->viewUrl) {
            $message->action('View Certificate/Document', $this->viewUrl);
        }

        return $message->line('Thank you for using the OSAS Request System!');
    }
}
