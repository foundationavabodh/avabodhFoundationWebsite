<?php

namespace App\Filament\Admin\Resources\Partners\Tables;

use App\Enums\PartnerApprovalStatus;
use App\Enums\PartnerCategory;
use App\Models\Partner;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Illuminate\Support\Collection;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label(''),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->tag_line)
                    ->wrap(),

                TextColumn::make('category')
                    ->badge()
                    ->sortable(),

                TextColumn::make('approval_status')
                    ->label('Review')
                    ->badge()
                    ->sortable(),

                TextColumn::make('badge_label')
                    ->label('Badge text')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('location')
                    ->searchable(),

                IconColumn::make('is_active_network')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('display_order')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('display_order')
            ->filters([
                SelectFilter::make('category')
                    ->options(PartnerCategory::class),

                SelectFilter::make('approval_status')
                    ->label('Review status')
                    ->options(PartnerApprovalStatus::class),

                TernaryFilter::make('is_active_network')
                    ->label('Active'),
            ])
            ->recordActions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve this NGO?')
                    ->modalDescription('It will be listed on the public NGO network page, with its own profile page.')
                    ->visible(fn (Partner $record): bool => $record->approval_status !== PartnerApprovalStatus::Approved)
                    ->action(function (Partner $record, Action $action): void {
                        $record->update(['approval_status' => PartnerApprovalStatus::Approved]);
                        $action->successNotificationTitle('NGO approved and now listed on the website');
                        $action->success();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject this NGO?')
                    ->modalDescription('It will not be listed on the website. You can still change your mind later by editing it.')
                    ->visible(fn (Partner $record): bool => $record->approval_status !== PartnerApprovalStatus::Rejected)
                    ->action(function (Partner $record, Action $action): void {
                        $record->update(['approval_status' => PartnerApprovalStatus::Rejected]);
                        $action->successNotificationTitle('NGO rejected');
                        $action->success();
                    }),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('approve')
                        ->label('Approve selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['approval_status' => PartnerApprovalStatus::Approved]))
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
