<?php

namespace App\Models;

use Database\Factories\DestinationFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Destination
 *
 * @property int $id
 * @property string $url
 * @property string $url_hash
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Link> $links
 */
#[UseFactory(DestinationFactory::class)]
class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'url_hash',
    ];

    protected static function booted(): void
    {
        static::creating(function ($link) {

            // Generate URL hash if not provided
            if (! $link->url_hash) {
                $link->url_hash = hash('sha256', $link->url);
            }
        });
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }
}
