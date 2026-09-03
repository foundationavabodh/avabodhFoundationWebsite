<?php

namespace App\Filament\Admin\Pages;

use App\Models\WebsiteSetting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class WebsiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $slug = 'website-settings';

    protected static ?string $title = 'Website Settings';

    protected static ?string $navigationLabel = 'Website Settings';

    protected string $view = 'filament.admin.pages.website-settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(WebsiteSetting::current()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Logo')
                    ->description('Replace the main website logo without editing any code.')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Website logo')
                            ->image()
                            ->disk('public')
                            ->directory('website/branding')
                            ->imageEditor()
                            ->helperText('If left empty, the site keeps using its current default logo.'),
                    ]),

                Section::make('Branding')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site name')
                            ->maxLength(255)
                            ->helperText('Used in the browser tab title. If left empty, the current default title is kept.'),
                    ]),

                Section::make('Header')
                    ->description('Contact details shown in the header top bar on the homepage.')
                    ->schema([
                        Toggle::make('show_header_top_bar')
                            ->label('Show header top bar')
                            ->helperText('Turn off to hide the address/phone/email bar above the main navigation.')
                            ->default(true),

                        TextInput::make('header_phone')
                            ->label('Phone number')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('header_email')
                            ->label('Email address')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('header_address')
                            ->label('Address')
                            ->maxLength(255),
                    ]),

                Section::make('Footer')
                    ->schema([
                        Textarea::make('footer_description')
                            ->label('Footer description')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->helperText('Shown in the footer\'s Newsletter widget. If left empty, the current default text is kept.'),

                        TextInput::make('copyright_text')
                            ->label('Copyright text')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Shown at the very bottom of every page. If left empty, the current default text is kept.'),

                        TextInput::make('social_twitter_url')
                            ->label('Twitter / X URL')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('social_whatsapp_url')
                            ->label('WhatsApp URL')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('social_instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('social_youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        WebsiteSetting::current()->update($data);

        Notification::make()
            ->title('Website settings saved')
            ->success()
            ->send();
    }
}
