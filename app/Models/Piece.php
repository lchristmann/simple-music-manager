<?php

namespace App\Models;

use App\Enums\DifficultyLevel;
use App\Enums\PlayableStatus;
use App\Models\Scopes\OwnedByUserViaCollectionScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

#[ScopedBy([OwnedByUserViaCollectionScope::class])]
class Piece extends Model
{
    /** @use HasFactory<\Database\Factories\PieceFactory> */
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'name',
        'artist',
        'lyrics_link',
        'tutorial_link',
        'notes',
        'status',
        'sort',
    ];

    protected $casts = [
        'status' => PlayableStatus::class,
        'difficulty' => DifficultyLevel::class,
    ];

    public function isPlayable(): bool
    {
        return $this->status === PlayableStatus::PLAYABLE;
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function compilations(): BelongsToMany
    {
        return $this->belongsToMany(Compilation::class)
            ->withPivot('sort')
            ->orderByPivot('sort');
    }

    protected static function booted(): void
    {
        static::creating(function (Piece $piece) {
            // auth check, because we don't want this to run during seeding
            if (Auth::check()) {
                // Assign sort per collection
                $piece->sort ??= (static::where('collection_id', $piece->collection_id)->max('sort') ?? -1) + 1;
            }
        });

        static::updating(function (Piece $piece) {
            // If the collection changed, move to the end of the new collection
            if ($piece->isDirty('collection_id')) {
                $piece->sort = static::where('collection_id', $piece->collection_id)
                        ->max('sort') + 1;
            }
        });
    }
}
