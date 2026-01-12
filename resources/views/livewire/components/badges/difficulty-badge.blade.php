<flux:badge size="sm"
            color="{{ match($level) {
                    \App\Enums\DifficultyLevel::EASY => 'sky',
                    \App\Enums\DifficultyLevel::MEDIUM => 'yellow',
                    \App\Enums\DifficultyLevel::HARD => 'red',
                } }}"
>
    {{ $level->label() }}
</flux:badge>
