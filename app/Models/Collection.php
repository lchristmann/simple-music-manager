<?php

namespace App\Models;

use App\Models\Scopes\OwnedByUserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

#[ScopedBy([OwnedByUserScope::class])]
class Collection extends Model
{
    /** @use HasFactory<\Database\Factories\CollectionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'instrument_id',
        'name',
        'sort',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function pieces(): HasMany
    {
        return $this->hasMany(Piece::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Collection $collection) {
            // auth check, because we don't want this to run during seeding (where there's no logged-in user)
            if (Auth::check()) {
                $collection->user_id = auth()->id();

                // Set initial sort value per instrument (MAX + 1)
                $collection->sort = static::where('user_id', $collection->user_id)
                        ->where('instrument_id', $collection->instrument_id)
                        ->max('sort') + 1;
            }
        });

        static::updating(function (Collection $collection) {
            // If the instrument changed, reset sort to MAX+1 in the new instrument group
            if ($collection->isDirty('instrument_id')) {
                $collection->sort = static::where('user_id', $collection->user_id)
                    ->where('instrument_id', $collection->instrument_id)
                    ->max('sort') + 1;
            }
        });
    }
}
