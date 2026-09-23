<?php

namespace App\Filament\Admin\Resources\InternshipDomains\Pages;

use App\Filament\Admin\Resources\InternshipDomains\InternshipDomainResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInternshipDomain extends EditRecord
{
    protected static string $resource = InternshipDomainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
