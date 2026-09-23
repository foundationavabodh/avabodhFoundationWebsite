<?php

namespace App\Filament\Admin\Resources\Internships;

use App\Filament\Admin\Resources\Internships\Pages\CreateInternship;
use App\Filament\Admin\Resources\Internships\Pages\EditInternship;
use App\Filament\Admin\Resources\Internships\Pages\ListInternships;
use App\Filament\Admin\Resources\Internships\Schemas\InternshipForm;
use App\Filament\Admin\Resources\Internships\Tables\InternshipsTable;
use App\Models\Internship;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InternshipResource extends Resource
{
    protected static ?string $model = Internship::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $navigationLabel = 'Internships';

    protected static ?string $slug = 'internships';

    public static function form(Schema $schema): Schema
    {
        return InternshipForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternshipsTable::configure($table);
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
            'index' => ListInternships::route('/'),
            'create' => CreateInternship::route('/create'),
            'edit' => EditInternship::route('/{record}/edit'),
        ];
    }
}
