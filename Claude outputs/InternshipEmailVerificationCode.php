<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Delivers the 6-digit code an applicant needs to verify their email before
 * submitting an internship application (Part 3). Sent as an on-demand
 * notification (Notification::route('mail', $email)->notify(...)) since
 * applicants aren't a Notifiable model -- see InternshipController.
 *
 * Uses Laravel's own mail/notification system, not a new package. Whatever
 * mailer is configured in .env (MAIL_MAILER) is what actually delivers this;
 * with the project's current MAIL_MAILER=log setting, the code is written to
 * storage/logs/laravel.log rather than sent to a real inbox until real SMTP
 * credentials are configured there.
 */
class InternshipEmailVerificationCode extends Notification
{
    public function __construct(private readonly string $code) {}

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
            ->subject('Your Avbodh Foundation internship application code')
            ->greeting('Verify your email')
            ->line('Use the code below to verify your email address and continue your internship application.')
            ->line(new \Illuminate\Support\HtmlString('<div style="font-size:28px;font-weight:700;letter-spacing:6px;text-align:center;margin:24px 0;">'.e($this->code).'</div>'))
            ->line('This code expires in 15 minutes.')
            ->line('If you did not request this, you can safely ignore this email.');
    }
}
