<?php

namespace App\Filament\Admin\Resources\Events\Schemas;

use App\Enums\EventStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->helperText('Used in the event\'s public URL. Auto-filled from the title, but you can override it.'),

                Textarea::make('short_description')
                    ->maxLength(500)
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('A brief summary shown on event listing cards (max 500 characters).'),

                RichEditor::make('description')
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('events')
                    ->imageEditor(),

                DatePicker::make('event_date')
                    ->required()
                    ->native(false),

                TimePicker::make('start_time')
                    ->native(false)
                    ->seconds(false),

                TimePicker::make('end_time')
                    ->native(false)
                    ->seconds(false)
                    ->after('start_time'),

                TextInput::make('location')
                    ->maxLength(255),

                Select::make('status')
                    ->options(EventStatus::class)
                    ->default(EventStatus::Draft)
                    ->required()
                    ->native(false),

                Toggle::make('is_featured')
                    ->label('Featured')
                    ->helperText('Featured events can be highlighted on the public site (e.g. the homepage).')
                    ->default(false),

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
