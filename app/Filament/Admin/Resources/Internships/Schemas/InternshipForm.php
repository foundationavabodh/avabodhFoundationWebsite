<?php

namespace App\Filament\Admin\Resources\Internships\Schemas;

use App\Enums\InternshipStatus;
use App\Models\InternshipDomain;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class InternshipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('domain_id')
                    ->label('Domain')
                    ->options(fn () => InternshipDomain::query()
                        ->orderBy('display_order')
                        ->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                        // Only auto-fill the slug while creating -- never overwrite a
                        // slug an admin has already set (or is editing) on an existing record.
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->alphaDash()
                    ->helperText('Used in the internship\'s public URL. Auto-filled from the title, but you can override it.'),

                Textarea::make('short_description')
                    ->maxLength(500)
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('A brief summary shown on internship listing cards (max 500 characters).'),

                RichEditor::make('description')
                    ->columnSpanFull(),

                TextInput::make('duration')
                    ->maxLength(100)
                    ->helperText('E.g. "3 months".'),

                TextInput::make('commitment')
                    ->maxLength(100)
                    ->helperText('E.g. "Full-time" or "10 hrs/week".'),

                TextInput::make('skills_required')
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->helperText('Comma-separated, e.g. "Communication, MS Excel, Canva".'),

                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('internships')
                    ->imageEditor(),

                Select::make('status')
                    ->options(InternshipStatus::class)
                    ->default(InternshipStatus::Draft)
                    ->required()
                    ->native(false),

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
