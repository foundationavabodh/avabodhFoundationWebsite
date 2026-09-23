<?php

namespace App\Filament\Admin\Resources\InternshipApplications\Pages;

use App\Filament\Admin\Resources\InternshipApplications\InternshipApplicationResource;
use Filament\Resources\Pages\ListRecords;

class ListInternshipApplications extends ListRecords
{
    protected static string $resource = InternshipApplicationResource::class;

    // No header "Create" action -- applications only originate from the public
    // application form, never from the admin panel.
    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
