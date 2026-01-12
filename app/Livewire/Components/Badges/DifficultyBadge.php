<?php

namespace App\Livewire\Components\Badges;

use App\Enums\DifficultyLevel;
use Livewire\Component;

class DifficultyBadge extends Component
{
    public DifficultyLevel $level;

    public function mount(DifficultyLevel $level)
    {
        $this->level = $level;
    }

    public function render()
    {
        return view('livewire.components.badges.difficulty-badge');
    }
}
