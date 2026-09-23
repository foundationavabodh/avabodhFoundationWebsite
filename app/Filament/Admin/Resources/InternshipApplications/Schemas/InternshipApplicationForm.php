<?php

namespace App\Filament\Admin\Resources\InternshipApplications\Schemas;

use App\Enums\InternshipApplicationStatus;
use App\Models\InternshipApplication;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InternshipApplicationForm
{
    /**
     * Applications only ever originate from the public application form (see
     * InternshipController::store()) -- there is no admin "create" page for this
     * resource. Every field here is read-only display EXCEPT `status` and `notes`,
     * which are the only two things an admin is meant to change once an application
     * has been submitted.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Placeholder::make('application_id')
                    ->label('Application ID')
                    ->content(fn (?InternshipApplication $record) => $record?->application_id ?? '—'),

                Placeholder::make('internship')
                    ->label('Applied For')
                    ->content(fn (?InternshipApplication $record) => $record?->internship?->title ?? '—'),

                Placeholder::make('full_name')
                    ->label('Full Name')
                    ->content(fn (?InternshipApplication $record) => $record?->full_name ?? '—'),

                Placeholder::make('email')
                    ->label('Email')
                    ->content(fn (?InternshipApplication $record) => $record
                        ? $record->email.($record->email_verified_at ? ' (verified)' : ' (not verified)')
                        : '—'),

                Placeholder::make('phone')
                    ->label('Phone')
                    ->content(fn (?InternshipApplication $record) => $record
                        ? trim(($record->country_code ?? '').' '.($record->phone ?? ''))
                        : '—'),

                Placeholder::make('preferred_domain')
                    ->label('Preferred Domain')
                    ->content(fn (?InternshipApplication $record) => $record?->preferredDomain?->name ?? '—'),

                Placeholder::make('college_name')
                    ->label('College / Institution')
                    ->content(fn (?InternshipApplication $record) => $record?->college_name ?? '—'),

                Placeholder::make('address')
                    ->label('Address')
                    ->content(fn (?InternshipApplication $record) => $record?->address ?? '—')
                    ->columnSpanFull(),

                Placeholder::make('skills')
                    ->label('Skills')
                    ->content(fn (?InternshipApplication $record) => $record?->skills ?? '—')
                    ->columnSpanFull(),

                Placeholder::make('submitted_at')
                    ->label('Submitted At')
                    ->content(fn (?InternshipApplication $record) => $record?->submitted_at?->format('d M Y, h:i A') ?? '—'),

                Select::make('status')
                    ->options(InternshipApplicationStatus::class)
                    ->required()
                    ->native(false),

                Textarea::make('notes')
                    ->label('Internal Notes')
                    ->rows(4)
                    ->columnSpanFull()
                    ->helperText('Visible to admins only -- never shown to the applicant.'),
            ]);
    }
}
