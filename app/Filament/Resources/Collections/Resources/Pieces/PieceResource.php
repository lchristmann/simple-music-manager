<?php

namespace App\Filament\Resources\Collections\Resources\Pieces;

use App\Filament\Resources\Collections\CollectionResource;
use App\Filament\Resources\Collections\Resources\Pieces\Pages\CreatePiece;
use App\Filament\Resources\Collections\Resources\Pieces\Pages\EditPiece;
use App\Filament\Resources\Collections\Resources\Pieces\Schemas\PieceForm;
use App\Filament\Resources\Collections\Resources\Pieces\Tables\PiecesTable;
use App\Models\Piece;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PieceResource extends Resource
{
    protected static ?string $model = Piece::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = CollectionResource::class;

    public static function getNavigationLabel(): string
    {
        return __('Pieces');
    }

    public static function getModelLabel(): string
    {
        return __('Piece');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Pieces');
    }

    public static function form(Schema $schema): Schema
    {
        return PieceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PiecesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreatePiece::route('/create'),
            'edit' => EditPiece::route('/{record}/edit'),
        ];
    }
}
