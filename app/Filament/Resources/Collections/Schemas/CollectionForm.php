<?php

namespace App\Filament\Resources\Collections\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CollectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label(__('Name'))->required()->maxLength(255),

                // Only allow choosing from the current user's instruments
                Select::make('instrument_id')
                    ->label(__('Instrument'))
                    ->required()
                    ->options(fn () => auth()->user()->instruments()->orderBy('sort')->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }
}
