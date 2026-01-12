<?php

namespace Database\Factories;

use App\Enums\DifficultyLevel;
use App\Enums\PlayableStatus;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Piece>
 */
class PieceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'collection_id' => Collection::factory(),
            'name' => fake()->words(3, true),
            'artist' => fake()->optional(0.9)->name(),
            'arranged_by' => fake()->optional()->name(),
            'sheet_music_link' => fake()->optional(0.8)->url(),
            'lyrics_link' => fake()->optional(0.8)->url(),
            'tutorial_link' => fake()->optional()->url(),
            'notes' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement([
                PlayableStatus::PLAYABLE->value,
                PlayableStatus::PLAYABLE->value,
                PlayableStatus::PLAYABLE->value, // bias towards playable
                PlayableStatus::WORKING_ON_IT->value,
                PlayableStatus::NOT_PLAYABLE_YET->value,
            ]),
            'difficulty' => fake()->randomElement(DifficultyLevel::cases())->value,
            'sort' => fake()->numberBetween(0, 100),
        ];
    }
}
