<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\TwilioSmsMessage;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $applicationName;

    public function __construct($status, $applicationName)
    {
        $this->status = $status;  // approved or rejected
        $this->applicationName = $applicationName;
    }

    public function via($notifiable)
    {
        return ['mail', 'twilio'];  // send both email and SMS
    }

    public function toMail($notifiable)
    {
        $message = "Your application for {$this->applicationName} has been {$this->status}.";

        return (new MailMessage)
                    ->subject('Application Status Update')
                    ->line($message)
                    ->action('View Application', url('/applications'))
                    ->line('Thank you for using BSAS!');
    }

    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
                    ->content("BSAS: Your application for {$this->applicationName} is {$this->status}.");
    }
}
