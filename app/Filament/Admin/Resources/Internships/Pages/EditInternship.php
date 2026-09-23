<?php

namespace App\Filament\Admin\Resources\Internships\Pages;

use App\Filament\Admin\Resources\Internships\InternshipResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInternship extends EditRecord
{
    protected static string $resource = InternshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
