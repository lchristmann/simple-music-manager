<?php

namespace App\Filament\Resources\Collections\Tables;

use App\Models\Collection;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CollectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('sort')
            ->defaultGroup('instrument.name')
            ->columns([
                TextColumn::make('name')->label(__('Name'))->searchable()->sortable(),
                TextColumn::make('instrument.name')->label(__('Instrument')),
                TextColumn::make('pieces_count')->label(__('Pieces'))->counts('pieces'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('moveUp')
                    ->icon('heroicon-o-chevron-up')
                    ->label(false)
                    ->action(fn (Collection $record) => self::moveUp($record))
                    ->tooltip(__('Move up'))
                    ->disabled(fn (Collection $record) =>
                        $record->sort === Collection::where('user_id', $record->user_id)
                            ->where('instrument_id', $record->instrument_id)
                            ->min('sort')
                    ),
                Action::make('moveDown')
                    ->icon('heroicon-o-chevron-down')
                    ->label(false)
                    ->action(fn (Collection $record) => self::moveDown($record))
                    ->tooltip(__('Move down'))
                    ->disabled(fn (Collection $record) =>
                        $record->sort === Collection::where('user_id', $record->user_id)
                            ->where('instrument_id', $record->instrument_id)
                            ->max('sort')
                    ),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function moveUp(Collection $collection): void
    {
        $previous = Collection::where('user_id', $collection->user_id)
            ->where('instrument_id', $collection->instrument_id)
            ->where('sort', '<', $collection->sort)
            ->orderByDesc('sort')
            ->first();

        if ($previous) {
            // Swap sort values
            [$collection->sort, $previous->sort] = [$previous->sort, $collection->sort];
            $collection->saveQuietly();
            $previous->saveQuietly();
        }
    }

    protected static function moveDown(Collection $collection): void
    {
        $next = Collection::where('user_id', $collection->user_id)
            ->where('instrument_id', $collection->instrument_id)
            ->where('sort', '>', $collection->sort)
            ->orderBy('sort')
            ->first();

        if ($next) {
            // Swap sort values
            [$collection->sort, $next->sort] = [$next->sort, $collection->sort];
            $collection->saveQuietly();
            $next->saveQuietly();
        }
    }
}
