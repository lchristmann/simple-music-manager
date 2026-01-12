<?php

namespace App\Livewire\Pages;

use App\Enums\PlayableStatus;
use App\Models\Piece;
use Livewire\Component;

class PracticePage extends Component
{
    public $practicePieces = [];

    public function mount()
    {
        $this->practicePieces = Piece::with('collection.instrument')
            ->where('status', PlayableStatus::WORKING_ON_IT)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.practice-page');
    }
}
