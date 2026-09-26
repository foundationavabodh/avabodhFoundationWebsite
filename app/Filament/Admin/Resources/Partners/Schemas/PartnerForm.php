<?php

namespace App\Filament\Admin\Resources\Partners\Schemas;

use App\Enums\PartnerCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->image()
                    ->disk('public')
                    ->directory('partners')
                    ->imageEditor()
                    ->columnSpanFull()
                    ->helperText('Optional. Shown as a small logo on the partner\'s card on the public NGO network page. Leave empty to show a placeholder icon instead.'),

                Select::make('category')
                    ->label('Filter category')
                    ->options(PartnerCategory::class)
                    ->required()
                    ->native(false)
                    ->helperText('Which tab this partner appears under on the public NGO network page ("Educational Partners", "NGO Collaborators", or "CSR & Corporates").'),

                TextInput::make('badge_label')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Short badge text shown on the card, e.g. "Educational Institution", "CSR & Medical Sponsor", "Corporate CSR Partner".'),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->helperText('The partner organization\'s name.'),

                TextInput::make('tag_line')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->helperText('Short colored subtitle describing the specific collaboration, e.g. "Internship & Tech Sourcing".'),

                Textarea::make('description')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('location')
                    ->required()
                    ->maxLength(255)
                    ->helperText('e.g. "Nagpur, Maharashtra".'),

                Toggle::make('is_active_network')
                    ->label('Active network')
                    ->default(true)
                    ->helperText('Inactive partners are hidden from the public page.'),

                TextInput::make('display_order')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Lower numbers are shown first.'),
            ]);
    }
}
