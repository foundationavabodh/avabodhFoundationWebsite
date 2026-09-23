<?php

namespace App\Filament\Admin\Resources\InternshipDomains;

use App\Filament\Admin\Resources\InternshipDomains\Pages\CreateInternshipDomain;
use App\Filament\Admin\Resources\InternshipDomains\Pages\EditInternshipDomain;
use App\Filament\Admin\Resources\InternshipDomains\Pages\ListInternshipDomains;
use App\Filament\Admin\Resources\InternshipDomains\Schemas\InternshipDomainForm;
use App\Filament\Admin\Resources\InternshipDomains\Tables\InternshipDomainsTable;
use App\Models\InternshipDomain;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InternshipDomainResource extends Resource
{
    protected static ?string $model = InternshipDomain::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'Internship Domains';

    // Groups this alongside Internships/Applications in the panel's own nav
    // ordering (Filament sorts by navigationSort when set; left default/alpha
    // otherwise, matching every other resource in this codebase).
    protected static ?string $slug = 'internship-domains';

    public static function form(Schema $schema): Schema
    {
        return InternshipDomainForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternshipDomainsTable::configure($table);
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
            'index' => ListInternshipDomains::route('/'),
            'create' => CreateInternshipDomain::route('/create'),
            'edit' => EditInternshipDomain::route('/{record}/edit'),
        ];
    }
}
