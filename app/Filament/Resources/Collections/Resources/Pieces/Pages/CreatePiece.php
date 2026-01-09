<?php

namespace App\Filament\Resources\Collections\Resources\Pieces\Pages;

use App\Filament\Resources\Collections\Resources\Pieces\PieceResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePiece extends CreateRecord
{
    protected static string $resource = PieceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getParentResource()::getUrl('edit', [
            'record' => $this->getParentRecord(),
        ]);
    }
}
