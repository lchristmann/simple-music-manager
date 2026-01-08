<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Compilation;
use App\Models\Instrument;
use App\Models\Piece;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user with data
        $admin = User::factory()
            ->admin()
            ->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin'),
            ]);
        $this->seedUserMusicData($admin);

        // Normal user with data
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
        ]);
        $this->seedUserMusicData($user);

        // Empty user (no data)
        User::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@user.com',
        ]);
    }


    /**
     * Seed a full music data set for a given user.
     */
    private function seedUserMusicData(User $user): void
    {
        $instrumentNames = ['Guitar', 'Trumpet', 'Piano', 'Keyboard', 'Drum', 'Accordion', 'Bongo', 'Violin', 'Saxophone'];

        $instruments = collect($instrumentNames)
            ->shuffle()
            ->take(3)
            ->values()
            ->map(fn ($name, $index) =>
                Instrument::factory()->create([
                    'user_id' => $user->id,
                    'name' => $name,
                    'sort' => $index,
                ])
            );

        foreach ($instruments as $instrument) {
            $collections = Collection::factory()
                ->count(2)
                ->sequence(fn (Sequence $sequence) => [
                    'user_id' => $user->id,
                    'instrument_id' => $instrument->id,
                    'sort' => $sequence->index, // 0, 1, ...
                ])
                ->create();

            foreach ($collections as $collection) {
                Piece::factory()
                    ->count(5)
                    ->sequence(fn (Sequence $sequence) => [
                        'collection_id' => $collection->id,
                        'sort' => $sequence->index,
                    ])
                    ->create();
            }
        }

        $compilations = Compilation::factory(2)->create([
            'user_id' => $user->id,
        ]);

        $allPieces = Piece::whereHas('collection', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        foreach ($compilations as $compilation) {
            $compilation->pieces()->attach(
                $allPieces->random(5)->pluck('id')
            );
        }
    }
}
