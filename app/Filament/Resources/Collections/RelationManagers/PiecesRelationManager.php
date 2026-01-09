<?php

namespace App\Filament\Resources\Collections\RelationManagers;

use App\Filament\Resources\Collections\Resources\Pieces\PieceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PiecesRelationManager extends RelationManager
{
    protected static string $relationship = 'pieces';

    protected static ?string $relatedResource = PieceResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
