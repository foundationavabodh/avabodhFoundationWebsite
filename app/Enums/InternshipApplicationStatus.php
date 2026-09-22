<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InternshipApplicationStatus: string implements HasColor, HasLabel
{
    case Pending = 'pending';
    case UnderReview = 'under_review';
    case Shortlisted = 'shortlisted';
    case Selected = 'selected';
    case Rejected = 'rejected';
    case Completed = 'completed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::UnderReview => 'Under Review',
            self::Shortlisted => 'Shortlisted',
            self::Selected => 'Selected',
            self::Rejected => 'Rejected',
            self::Completed => 'Completed',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::UnderReview => 'info',
            self::Shortlisted => 'warning',
            self::Selected => 'success',
            self::Rejected => 'danger',
            self::Completed => 'primary',
        };
    }

    /**
     * A short, applicant-facing "what happens next" message for the public status
     * tracker (Part 5) -- deliberately generic, never anything from `notes`.
     */
    public function nextStepMessage(): string
    {
        return match ($this) {
            self::Pending => 'Your application has been received and is waiting to be reviewed.',
            self::UnderReview => 'Our team is currently reviewing your application.',
            self::Shortlisted => 'You\'ve been shortlisted. We\'ll be in touch with next steps.',
            self::Selected => 'Congratulations -- you\'ve been selected! We\'ll contact you with onboarding details.',
            self::Rejected => 'We won\'t be moving forward with this application at this time. Thank you for your interest.',
            self::Completed => 'This internship has been completed. Thank you for your contribution!',
        };
    }
}
