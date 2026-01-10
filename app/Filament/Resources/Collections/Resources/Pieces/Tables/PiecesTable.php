<?php

namespace App\Filament\Resources\Collections\Resources\Pieces\Tables;

use App\Enums\PlayableStatus;
use App\Models\Collection;
use App\Models\Piece;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PiecesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('name')->label(__('Name'))->searchable(),
                TextColumn::make('artist')->label(__('Artist'))->searchable(),
                TextColumn::make('lyrics_link')->label(__('Lyrics'))
                    ->formatStateUsing(fn (string $state): string =>
                            preg_replace('#^https?://#', '', $state ?? ''),
                        )
                    ->limit(25)
                    ->searchable(),
                TextColumn::make('tutorial_link')->label(__('Tutorial'))
                    ->formatStateUsing(fn (string $state): string =>
                    preg_replace('#^https?://#', '', $state ?? ''),
                    )
                    ->limit(25)
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn (PlayableStatus $state) => $state->label())
                    ->color(fn (PlayableStatus $state) => match ($state) {
                        PlayableStatus::PLAYABLE => 'success',
                        PlayableStatus::WORKING_ON_IT => 'warning',
                        PlayableStatus::NOT_PLAYABLE_YET => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')->label(__('Created at'))->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label(__('Updated at'))->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('moveUp')
                    ->icon('heroicon-o-chevron-up')
                    ->label(false)
                    ->action(fn (Piece $record) => self::moveUp($record))
                    ->tooltip(__('Move up'))
                    ->disabled(fn (Piece $record) =>
                        $record->sort === Piece::where('collection_id', $record->collection_id)->min('sort')
                    ),
                Action::make('moveDown')
                    ->icon('heroicon-o-chevron-down')
                    ->label(false)
                    ->action(fn (Piece $record) => self::moveDown($record))
                    ->tooltip(__('Move down'))
                    ->disabled(fn (Piece $record) =>
                        $record->sort === Piece::where('collection_id', $record->collection_id)->max('sort')
                    ),
                Action::make('moveToCollection')
                    ->icon('heroicon-o-arrow-right')
                    ->label(false)
                    ->tooltip(__('Move to another collection'))
                    ->schema([
                        Select::make('collection_id')
                            ->label(__('Target collection'))
                            ->required()
                            ->options(fn (Piece $record) =>
                                Collection::where('user_id', auth()->id())
                                    ->where('id', '!=', $record->collection_id)
                                    ->orderBy('sort')
                                    ->pluck('name', 'id')
                                ),
                    ])
                    ->action(function (Piece $record, array $data) {
                        self::moveToCollection($record, (int) $data['collection_id']);
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function moveUp(Piece $piece): void
    {
        $previous = Piece::where('collection_id', $piece->collection_id)
            ->where('sort', '<', $piece->sort)
            ->orderByDesc('sort')
            ->first();

        if ($previous) {
            [$piece->sort, $previous->sort] = [$previous->sort, $piece->sort];
            $piece->saveQuietly();
            $previous->saveQuietly();
        }
    }

    protected static function moveDown(Piece $piece): void
    {
        $next = Piece::where('collection_id', $piece->collection_id)
            ->where('sort', '>', $piece->sort)
            ->orderBy('sort')
            ->first();

        if ($next) {
            [$piece->sort, $next->sort] = [$next->sort, $piece->sort];
            $piece->saveQuietly();
            $next->saveQuietly();
        }
    }

    protected static function moveToCollection(Piece $piece, int $newCollectionId): void
    {
        $newSort = Piece::where('collection_id', $newCollectionId)->max('sort') + 1;

        $piece->updateQuietly([
            'collection_id' => $newCollectionId,
            'sort' => $newSort,
        ]);
    }
}
