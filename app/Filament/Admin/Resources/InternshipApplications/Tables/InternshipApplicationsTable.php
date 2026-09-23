<?php

namespace App\Filament\Admin\Resources\InternshipApplications\Tables;

use App\Enums\InternshipApplicationStatus;
use App\Models\Internship;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InternshipApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application_id')
                    ->label('Application ID')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('full_name')
                    ->label('Applicant')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->email),

                TextColumn::make('internship.title')
                    ->label('Applied For')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                SelectFilter::make('internship_id')
                    ->label('Internship')
                    ->options(fn () => Internship::query()->orderBy('title')->pluck('title', 'id')),

                SelectFilter::make('status')
                    ->options(InternshipApplicationStatus::class),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('View / Update'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
