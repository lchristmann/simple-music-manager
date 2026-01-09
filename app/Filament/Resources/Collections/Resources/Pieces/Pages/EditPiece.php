<?php

namespace App\Filament\Resources\Collections\Resources\Pieces\Pages;

use App\Filament\Resources\Collections\Resources\Pieces\PieceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPiece extends EditRecord
{
    protected static string $resource = PieceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getParentResource()::getUrl('edit', [
            'record' => $this->getParentRecord(),
        ]);
    }
}
