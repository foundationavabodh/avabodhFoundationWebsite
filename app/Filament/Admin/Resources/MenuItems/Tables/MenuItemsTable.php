<?php

namespace App\Filament\Admin\Resources\MenuItems\Tables;

use App\Enums\MenuLinkType;
use App\Models\MenuItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MenuItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')
                    // A submenu item's label is indented under its parent's, so the
                    // hierarchy stays readable even on the "Submenu items" tab, which
                    // otherwise lists children from several different parents.
                    ->formatStateUsing(fn (string $state, MenuItem $record) => $record->parent_id
                        ? '— '.$state
                        : $state)
                    ->description(fn (MenuItem $record) => $record->parent?->label)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('link_type')
                    ->label('Link type')
                    ->badge(),

                TextColumn::make('destination')
                    ->label('Destination')
                    ->state(fn (MenuItem $record) => match ($record->link_type) {
                        MenuLinkType::Route => $record->route_name,
                        MenuLinkType::Path, MenuLinkType::External => $record->url,
                        default => null,
                    })
                    ->limit(40)
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('open_in_new_tab')
                    ->label('New tab')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            // Filament's native drag-and-drop reordering (writes to sort_order on drop).
            // Scoped correctly per tab because each tab's query modification (see
            // ListMenuItems::getTabs()) is applied before the table is reordered.
            ->reorderable('sort_order')
            ->filters([
                SelectFilter::make('link_type')
                    ->options(MenuLinkType::class),

                SelectFilter::make('parent_id')
                    ->label('Parent')
                    ->relationship('parent', 'label', fn ($query) => $query->whereNull('parent_id')),

                TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
