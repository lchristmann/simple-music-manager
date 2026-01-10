<?php

namespace App\Enums;

enum PlayableStatus: string
{
    case PLAYABLE = 'playable';
    case WORKING_ON_IT = 'workingOnIt';
    case NOT_PLAYABLE_YET = 'notPlayableYet';

    public function label(): string
    {
        return match ($this) {
            self::PLAYABLE => __('Playable'),
            self::WORKING_ON_IT => __('Working on it'),
            self::NOT_PLAYABLE_YET => __('Not playable yet'),
        };
    }

    // Use this in the status Select form component
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $case) => [
                $case->value => $case->label(),
            ])
            ->toArray();
    }
}
