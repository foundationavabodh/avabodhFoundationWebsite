<?php

namespace App\Notifications;

use App\Models\Partner;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Emails the foundation when an NGO registers itself on /ngo/register, so an admin
 * knows there's a new pending registration to review. Sent as an on-demand
 * notification to the Website Settings' header_email, like ContactFormSubmitted.
 */
class PartnerRegistrationSubmitted extends Notification
{
    public function __construct(private readonly Partner $partner, private readonly ?string $reviewUrl = null) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('New NGO registration awaiting approval: '.$this->partner->name)
            ->greeting('New NGO registration')
            ->line('An NGO registered through the website and is waiting for your approval. It will not appear on the NGO network until you approve it.')
            ->line('**NGO:** '.($this->partner->legal_name ?: $this->partner->name))
            ->line('**Contact person:** '.$this->partner->contact_person)
            ->line('**Email:** '.$this->partner->contact_email)
            ->line('**Phone:** '.$this->partner->contact_phone)
            ->line('**Location:** '.$this->partner->location);

        if ($this->reviewUrl) {
            $mail->action('Review registration', $this->reviewUrl);
        }

        if ($this->partner->contact_email) {
            $mail->replyTo($this->partner->contact_email, $this->partner->contact_person ?: $this->partner->name);
        }

        return $mail;
    }
}
