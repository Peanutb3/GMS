<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestSubmittedNotification extends Notification
{
    use Queueable;

    protected $requestType;
    protected $referenceNo;

    public function __construct($requestType, $referenceNo)
    {
        $this->requestType = $requestType;
        $this->referenceNo = $referenceNo;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Request Submitted - ' . $this->requestType)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your ' . $this->requestType . ' request has been successfully submitted.')
            ->line('Reference Number: ' . $this->referenceNo)
            ->line('Our staff will review your request and process it shortly.')
            ->line('You will receive another email once your request has been processed.')
            ->line('Thank you for using the OSAS Request System!');
    }
}
