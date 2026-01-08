<?php

namespace App\Models;

use App\Services\Util\SlugService;
use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * A Link model represents a shortened URL
 * that tracks clicks and expiration. It is linked
 * to an original destination model
 *
 * @property int $id
 * @property string $code
 * @property int $destination_id
 * @property bool $is_active
 * @property Carbon|null $expires_at
 * @property Carbon|null $last_accessed
 * @property int $clicks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read bool $is_expired
 * @property-read Destination $destination
 *
 */
class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'destination_id',
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


    protected static function booted(): void
    {
        static::creating(function ($link) {

            // Auto generate if no code provided
            if (!$link->code) {
                $link->code = app(SlugService::class)->generate();
            }
        });
    }

    /**
     * Determine if the link is expired.
     *
     * use $link->is_expired
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at?->isPast() ?? false;
    }

    /**
     * Determine if the link is active and not expired.
     */
    public function isActiveAndNotExpired(): bool
    {
        return $this->is_active && ! $this->is_expired;
    }

    /**
     * Get the link that owns the slug.
     * i.e. the original URL.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
