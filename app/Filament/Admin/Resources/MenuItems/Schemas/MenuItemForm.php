<?php

namespace App\Filament\Admin\Resources\MenuItems\Schemas;

use App\Enums\MenuLinkType;
use App\Models\MenuItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Route as RouteFacade;

class MenuItemForm
{
    /**
     * Normalizes the live 'link_type' form state to its plain string value.
     *
     * Get::get('link_type') returns a MenuLinkType enum *instance* once the form
     * has been hydrated by Livewire (confirmed by direct inspection -- a debug
     * probe placed in this schema printed `\App\Enums\MenuLinkType::Route`, not
     * the string "route"), even though the field is fed by MenuLinkType::class
     * options and the record's own attributesToArray() gives a plain string on
     * the very first server-side fill. The various ->visible()/->label()/etc.
     * closures below were comparing that against MenuLinkType::X->value (a
     * string), which is a type mismatch that always evaluates false -- so the
     * Route/Path/External "destination" field never appeared, on both the
     * create and edit forms. Routing every comparison through this helper
     * instead of a bare ->value comparison keeps it correct regardless of
     * which shape Get() hands back.
     */
    private static function linkTypeValue(mixed $value): ?string
    {
        return $value instanceof MenuLinkType ? $value->value : $value;
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->helperText('The text shown in the navigation menu, e.g. "About Us".'),

                Select::make('parent_id')
                    ->label('Parent menu item')
                    ->native(false)
                    ->searchable()
                    ->options(function (?MenuItem $record) {
                        return MenuItem::query()
                            ->whereNull('parent_id')
                            ->when($record, fn ($query) => $query->where('id', '!=', $record->id))
                            ->orderBy('sort_order')
                            ->pluck('label', 'id');
                    })
                    ->helperText('Leave empty for a top-level menu item. Only top-level items can be chosen as a parent -- one level of submenu is supported.'),

                Select::make('link_type')
                    ->label('Link type')
                    ->options(MenuLinkType::class)
                    ->required()
                    ->native(false)
                    ->live()
                    ->default(MenuLinkType::Path)
                    ->helperText('Where this menu item points to.'),

                Select::make('route_name')
                    ->label('Route')
                    ->native(false)
                    ->searchable()
                    ->options(function () {
                        // Illuminate\Routing\Route has no 'name' *property* (only a
                        // getName() *method*), so a plain ->pluck('name', 'name') on a
                        // collection of Route objects can't read it -- every route
                        // silently resolves to null, and the nulls collapse into a
                        // single blank option. Map to the actual route name first.
                        return collect(RouteFacade::getRoutes())
                            ->filter(fn ($route) => $route->getName()
                                && in_array('GET', $route->methods())
                                && ! str($route->getName())->startsWith(['filament.', 'filament-', 'livewire.', 'livewire-'])
                                && $route->parameterNames() === [])
                            ->map(fn ($route) => $route->getName())
                            ->unique()
                            ->sort()
                            ->values()
                            ->mapWithKeys(fn (string $name) => [$name => $name])
                            ->all();
                    })
                    ->required()
                    ->visible(fn (Get $get) => self::linkTypeValue($get('link_type')) === MenuLinkType::Route->value)
                    ->helperText('A named application route, e.g. "projects.index". The link automatically follows that route\'s URL.'),

                TextInput::make('url')
                    ->label(fn (Get $get) => self::linkTypeValue($get('link_type')) === MenuLinkType::External->value ? 'External URL' : 'Path')
                    ->required()
                    ->maxLength(255)
                    ->url(fn (Get $get) => self::linkTypeValue($get('link_type')) === MenuLinkType::External->value)
                    ->placeholder(fn (Get $get) => self::linkTypeValue($get('link_type')) === MenuLinkType::External->value ? 'https://example.com' : '/about')
                    ->visible(fn (Get $get) => in_array(self::linkTypeValue($get('link_type')), [MenuLinkType::Path->value, MenuLinkType::External->value]))
                    ->helperText(fn (Get $get) => self::linkTypeValue($get('link_type')) === MenuLinkType::External->value
                        ? 'The full external URL this item links to.'
                        : 'The internal path or page this item links to, e.g. "/about".'),

                Toggle::make('open_in_new_tab')
                    ->label('Open in new tab')
                    ->default(false),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Inactive items are hidden from the public navigation.'),

                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Lower numbers are shown first, within the same parent.'),
            ]);
    }
}
