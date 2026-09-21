<?php

namespace App\Filament\Admin\Resources\Sliders\Schemas;

use App\Enums\SliderTextAnimation;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('sliders')
                    ->imageEditor()
                    ->helperText('Recommended size: 1920 x 970px (same as the current hero background). Leave empty to use the default hero image.'),

                TextInput::make('subtitle')
                    ->maxLength(255)
                    ->helperText('Small text shown above the heading, e.g. "Non - Profit Charity".'),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->helperText('The large heading text for this slide.'),

                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('Optional paragraph shown under the heading.'),

                TextInput::make('button_text')
                    ->maxLength(255)
                    ->default('Join With Us'),

                TextInput::make('button_url')
                    ->maxLength(255)
                    ->default('#')
                    ->helperText('Where the button links to.'),

                Select::make('text_animation')
                    ->label('Text effect')
                    ->options(SliderTextAnimation::class)
                    ->default(SliderTextAnimation::FadeInUp)
                    ->required()
                    ->native(false)
                    ->helperText('The entrance animation played on this slide\'s text when it becomes active.'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Inactive slides are hidden from the homepage.'),

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
