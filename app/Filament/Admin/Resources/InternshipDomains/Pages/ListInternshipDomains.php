<?php

namespace App\Filament\Admin\Resources\InternshipDomains\Pages;

use App\Filament\Admin\Resources\InternshipDomains\InternshipDomainResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternshipDomains extends ListRecords
{
    protected static string $resource = InternshipDomainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
