<?php

namespace App\Filament\Resources\Collections\Resources\Pieces\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PieceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label(__('Name'))->required()->maxLength(255),
                TextInput::make('artist')->label(__('Artist'))->maxLength(255),
                TextInput::make('lyrics_link')->label(__('Lyrics Link')),
                TextInput::make('tutorial_link')->label(__('Tutorial Link')),
                Textarea::make('notes')->label(__('Notes'))->columnSpanFull(),
            ]);
    }
}
