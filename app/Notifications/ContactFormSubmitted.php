<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Emails the foundation a copy of a public "Send Us A Message" submission
 * from the /contact page. Sent as an on-demand notification (Notification::
 * route('mail', $to)->notify(...)) since the recipient is the foundation's
 * own inbox address (Website Settings' header_email), not a Notifiable
 * model -- same approach as InternshipEmailVerificationCode.
 *
 * Whatever mailer is configured in .env (MAIL_MAILER) is what actually
 * delivers this; with MAIL_MAILER=log the message is written to
 * storage/logs/laravel.log rather than sent to a real inbox until real SMTP
 * credentials are added there.
 */
class ContactFormSubmitted extends Notification
{
    /**
     * @param  array{name: string, email: string, number: ?string, message: string}  $data
     */
    public function __construct(private readonly array $data) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New contact form message from '.$this->data['name'])
            ->replyTo($this->data['email'], $this->data['name'])
            ->greeting('New message from your website')
            ->line('Someone submitted the "Send Us A Message" form on the Contact Us page.')
            ->line('**Name:** '.$this->data['name'])
            ->line('**Email:** '.$this->data['email'])
            ->when(filled($this->data['number'] ?? null), fn (MailMessage $mail) => $mail->line('**Phone:** '.$this->data['number']))
            ->line('**Message:**')
            ->line($this->data['message'])
            ->line('You can reply directly to this email to respond to '.$this->data['name'].'.');
    }
}
