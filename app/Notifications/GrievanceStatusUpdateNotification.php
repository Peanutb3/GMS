<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GrievanceStatusUpdateNotification extends Notification
{
    use Queueable;

    protected $caseId;
    protected $newStatus;
    protected $message;

    public function __construct($caseId, $newStatus, $message = null)
    {
        $this->caseId = $caseId;
        $this->newStatus = $newStatus;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $statusText = ucfirst(str_replace('_', ' ', $this->newStatus));

        $mailMessage = (new MailMessage)
            ->subject('Grievance Status Update - Case ' . $this->caseId)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your grievance case has been updated.')
            ->line('Case ID: ' . $this->caseId)
            ->line('New Status: ' . $statusText);

        if ($this->message) {
            $mailMessage->line('Message: ' . $this->message);
        }

        return $mailMessage->line('Thank you for using the OSAS Grievance Management System.');
    }
}
