<?php

namespace App\Filament\Admin\Resources\MenuItems\Pages;

use App\Filament\Admin\Resources\MenuItems\MenuItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListMenuItems extends ListRecords
{
    protected static string $resource = MenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * Two independently reorderable views, as required: one for the main navigation's
     * top-level items, one for submenu items. Filament's native reorderable table
     * (see MenuItemsTable::configure()) is scoped to whichever tab's query is active,
     * so dragging within the "Submenu items" tab reorders sort_order among children
     * without disturbing top-level ordering, and vice versa.
     */
    public function getTabs(): array
    {
        return [
            'top-level' => Tab::make('Top-Level Items')
                ->modifyQueryUsing(fn ($query) => $query->whereNull('parent_id')),

            'submenu' => Tab::make('Submenu Items')
                ->modifyQueryUsing(fn ($query) => $query->whereNotNull('parent_id')),
        ];
    }
}
