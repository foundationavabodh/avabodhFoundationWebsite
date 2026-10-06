<?php

namespace App\Filament\Admin\Resources\Partners\Schemas;

use App\Enums\PartnerApprovalStatus;
use App\Enums\PartnerCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

/**
 * Admin form for an NGO / partner. Mirrors the "NGO Information Collection Form"
 * (sections 1-5) plus the few fields the /ngo listing cards need. Only the listing
 * card fields are required; everything else is optional and simply not shown on the
 * public profile page (/ngo/{slug}) when left empty.
 */
class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Listing card (NGO network page)')
                    ->description('What appears on the card on the public NGO network page.')
                    ->columns(2)
                    ->schema([
                        Select::make('category')
                            ->label('Filter category')
                            ->options(PartnerCategory::class)
                            ->required()
                            ->native(false)
                            ->helperText('Which tab this partner appears under ("Educational Partners", "NGO Collaborators", or "CSR & Corporates").'),

                        TextInput::make('badge_label')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Short badge text on the card, e.g. "Educational Institution", "NGO Collaborator".'),

                        TextInput::make('name')
                            ->label('Display / operating name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, Set $set) {
                                // Only auto-fill the slug while creating -- never overwrite one
                                // an admin already set on an existing partner.
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->alphaDash()
                            ->helperText('Public page URL: /ngo/your-slug. Auto-filled from the name; leave empty to generate one.'),

                        TextInput::make('tag_line')
                            ->label('Tagline / catchphrase')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->helperText('Short colored subtitle, e.g. "Internship & Tech Sourcing".'),

                        Textarea::make('description')
                            ->label('Short summary (1-2 sentences for the listing card)')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('location')
                            ->required()
                            ->maxLength(255)
                            ->helperText('e.g. "Nagpur, Maharashtra".'),

                        TextInput::make('display_order')
                            ->required()
                            ->numeric()
                            ->integer()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Lower numbers are shown first.'),

                        Select::make('approval_status')
                            ->label('Review status')
                            ->options(PartnerApprovalStatus::class)
                            ->default(PartnerApprovalStatus::Approved)
                            ->required()
                            ->native(false)
                            ->helperText('NGOs that register on the website start as "Pending review" and appear on the public NGO network only once set to "Approved". Approving lists the NGO; pending or rejected NGOs are hidden.'),

                        Toggle::make('is_active_network')
                            ->label('Active network')
                            ->default(true)
                            ->helperText('Inactive partners are hidden from the public page and their profile returns a 404.'),
                    ]),

                Section::make('1. Basic & legal identity')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('legal_name')
                            ->label('NGO full legal name')
                            ->maxLength(255),

                        TextInput::make('established_year')
                            ->label('Year of establishment')
                            ->numeric()
                            ->integer()
                            ->minValue(1800)
                            ->maxValue((int) date('Y')),

                        TextInput::make('registration_details')
                            ->label('Registration number & type')
                            ->maxLength(255)
                            ->helperText('e.g. "Trust - E-1234 (Nagpur)", "Section 8 Company - U80900MH2021NPL352874".'),

                        TextInput::make('tax_certifications')
                            ->label('Tax exemption / certification status')
                            ->maxLength(255)
                            ->helperText('e.g. "80G, 12A, FCRA, CSR-1 registered".'),

                        TagsInput::make('focus_areas')
                            ->label('Primary focus sectors / domains')
                            ->placeholder('Type and press Enter')
                            ->columnSpanFull()
                            ->helperText('e.g. Education, Healthcare, Environment, Rural Development, Women Empowerment.'),
                    ]),

                Section::make('2. Contact & key personnel')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('founder_name')
                            ->label('Founder / President / Director (name & designation)')
                            ->maxLength(255),

                        TextInput::make('contact_person')
                            ->label('Primary contact person (name & title)')
                            ->maxLength(255),

                        TextInput::make('contact_phone')
                            ->label('Official contact number(s) / WhatsApp')
                            ->maxLength(50),

                        TextInput::make('contact_email')
                            ->label('Official email address')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('website_url')
                            ->label('Official website URL')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('social_links.facebook')->label('Facebook')->url()->maxLength(255),
                        TextInput::make('social_links.instagram')->label('Instagram')->url()->maxLength(255),
                        TextInput::make('social_links.linkedin')->label('LinkedIn')->url()->maxLength(255),
                        TextInput::make('social_links.youtube')->label('YouTube')->url()->maxLength(255),
                        TextInput::make('social_links.x')->label('X (Twitter)')->url()->maxLength(255),

                        Textarea::make('address')
                            ->label('Registered address')
                            ->rows(2),

                        Textarea::make('operating_address')
                            ->label('Operating / branch office address')
                            ->rows(2),
                    ]),

                Section::make('3. About the organisation')
                    ->collapsible()
                    ->schema([
                        Textarea::make('mission')
                            ->label('Mission statement')
                            ->rows(3),

                        Textarea::make('vision')
                            ->label('Vision statement')
                            ->rows(3),

                        RichEditor::make('details')
                            ->label('About us / detailed overview'),

                        RichEditor::make('ongoing_projects')
                            ->label('Key ongoing projects & initiatives'),

                        RichEditor::make('achievements')
                            ->label('Key achievements & impact metrics')
                            ->helperText('e.g. beneficiaries reached, projects completed.'),
                    ]),

                Section::make('4. Media & visual assets')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        FileUpload::make('logo')
                            ->label('NGO logo')
                            ->image()
                            ->disk('public')
                            ->directory('partners')
                            ->imageEditor()
                            ->helperText('Shown on the listing card and the profile page. Leave empty for a placeholder icon.'),

                        FileUpload::make('cover_image')
                            ->label('Header / cover banner image')
                            ->image()
                            ->disk('public')
                            ->directory('partners/covers')
                            ->imageEditor()
                            ->helperText('Wide image shown at the top of the profile page (recommended 1600 x 600 px).'),

                        Repeater::make('gallery')
                            ->label('Project / activity photos (3-5 with captions)')
                            ->columnSpanFull()
                            ->maxItems(8)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['caption'] ?? null)
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('partners/gallery')
                                    ->imageEditor()
                                    ->required(),
                                TextInput::make('caption')
                                    ->maxLength(255),
                            ]),

                        TextInput::make('video_url')
                            ->label('Documentary / promotional video URL')
                            ->url()
                            ->maxLength(255)
                            ->helperText('YouTube or Vimeo links play on the page; other links show as a "Watch video" button.'),

                        TextInput::make('brochure_url')
                            ->label('Brochure or annual report PDF link')
                            ->url()
                            ->maxLength(255),
                    ]),

                Section::make('5. Donation & bank details')
                    ->description('Everything filled in here is shown publicly on the NGO\'s profile page so visitors can donate. Leave the whole section empty to hide the donation box.')
                    ->columns(2)
                    ->collapsible()
                    ->schema([
                        TextInput::make('bank_account_holder')->label('Account holder name (legal registered name)')->maxLength(255),
                        TextInput::make('bank_name')->label('Bank name')->maxLength(255),
                        TextInput::make('bank_branch')->label('Branch name & address')->maxLength(255),
                        TextInput::make('bank_account_number')->label('Account number')->maxLength(50),
                        TextInput::make('bank_ifsc')->label('IFSC code / SWIFT code')->maxLength(50),
                        TextInput::make('upi_id')->label('UPI ID')->maxLength(255),

                        FileUpload::make('upi_qr_image')
                            ->label('UPI QR code image')
                            ->image()
                            ->disk('public')
                            ->directory('partners/qr'),

                        Textarea::make('donor_tax_benefit')
                            ->label('Tax exemption benefit details for donors')
                            ->rows(3)
                            ->helperText('e.g. "80G tax receipt available".'),
                    ]),
            ]);
    }
}
