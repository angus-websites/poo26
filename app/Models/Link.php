<?php

namespace App\Models;

use App\Services\SlugService;
use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property string $slug
 * @property string $original_url
 * @property int $clicks
 * @property bool $is_active
 * @property Carbon|null $expires_at
 * @property Carbon|null $last_accessed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
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
     * Ensure a slug is generated when creating a new Link.
     */
    protected static function booted(): void
    {
        static::creating(function ($link) {
            if (!$link->slug) {
                $link->slug = app(SlugService::class)->generate();
            }
        });
    }
}
