<?php

namespace App\Models;

use App\Services\SlugService;
use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property string $slug
 * @property string $original_url
 * @property string $url_hash
 * @property int $clicks
 * @property bool $is_active
 * @property Carbon|null $expires_at
 * @property Carbon|null $last_accessed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read bool $is_expired
 *
 * @method static Builder|Link active()
 * @method static Builder|Link permanent()
 */
class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'original_url',
        'clicks',
        'is_active',
        'expires_at',
        'last_accessed',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'last_accessed' => 'datetime',
    ];

    /**
     * Scope for active links that are not expired
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Scope for links that are permanent (active and no expiration)
     */
    public function scopePermanent($query)
    {
        return $query->where('is_active', true)
            ->whereNull('expires_at');
    }

    /**
     * Ensure a slug is generated when creating a new Link.
     */
    protected static function booted(): void
    {
        static::creating(function ($link) {

            // Auto generate slug if not provided
            if (! $link->slug) {
                $link->slug = app(SlugService::class)->generate();
            }

            // Generate URL hash if not provided
            if (! $link->url_hash) {
                $link->url_hash = hash('sha256', $link->original_url);
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
}
