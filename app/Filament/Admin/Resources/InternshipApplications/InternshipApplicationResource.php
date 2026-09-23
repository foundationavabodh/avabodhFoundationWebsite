<?php

namespace App\Filament\Admin\Resources\InternshipApplications;

use App\Filament\Admin\Resources\InternshipApplications\Pages\EditInternshipApplication;
use App\Filament\Admin\Resources\InternshipApplications\Pages\ListInternshipApplications;
use App\Filament\Admin\Resources\InternshipApplications\Schemas\InternshipApplicationForm;
use App\Filament\Admin\Resources\InternshipApplications\Tables\InternshipApplicationsTable;
use App\Models\InternshipApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InternshipApplicationResource extends Resource
{
    protected static ?string $model = InternshipApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $navigationLabel = 'Internship Applications';

    protected static ?string $slug = 'internship-applications';

    // Applications only ever originate from the public application form -- admins
    // review, filter, change status and add notes, but never create one by hand.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return InternshipApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternshipApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInternshipApplications::route('/'),
            'edit' => EditInternshipApplication::route('/{record}/edit'),
        ];
    }
}
