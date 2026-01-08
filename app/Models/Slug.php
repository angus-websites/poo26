<?php

namespace App\Models;

use App\Services\SlugService;
use Database\Factories\SlugFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * A slug model represents a shortened URL slug.
 * i.e. the part after the domain in a shortened URL.
 *
 * @property int $id
 * @property string $code
 * @property int $link_id
 * @property bool $is_active
 * @property Carbon|null $expires_at
 * @property Carbon|null $last_accessed
 * @property int $clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read bool $is_expired
 * @property-read Link $link
 *
 */
class Slug extends Model
{
    /** @use HasFactory<SlugFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'link_id',
        'is_active',
        'expires_at',
        'clicks',
        'last_accessed',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'last_accessed' => 'datetime',
    ];


    /**
     * Ensure a slug is generated when creating a new Link.
     */
    protected static function booted(): void
    {
        static::creating(function ($link) {

            // Auto generate slug if not provided
            if (!$link->slug) {
                $link->slug = app(SlugService::class)->generate();
            }
        });
    }

    /**
     * Determine if the link is expired.
     *
     * use $slug->is_expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at?->isPast() ?? false;
    }

    /**
     * Get the link that owns the slug.
     * i.e. the original URL.
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
