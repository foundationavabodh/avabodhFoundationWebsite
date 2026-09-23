<?php

namespace App\Filament\Admin\Resources\Internships\Pages;

use App\Filament\Admin\Resources\Internships\InternshipResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternships extends ListRecords
{
    protected static string $resource = InternshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
