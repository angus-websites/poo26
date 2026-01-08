<?php

namespace App\Models;

use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property string $original_url
 * @property string $url_hash
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Collection<int, Slug> $slugs
 */
class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    protected $fillable = [
        'original_url',
        'url_hash'
    ];

    protected static function booted(): void
    {
        static::creating(function ($link) {

            // Generate URL hash if not provided
            if (!$link->url_hash) {
                $link->url_hash = hash('sha256', $link->original_url);
            }
        });
    }

    public function slugs(): HasMany
    {
        return $this->hasMany(Slug::class);
    }

}
