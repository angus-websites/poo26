<?php

namespace App\Data;

use Illuminate\Support\Carbon;
use App\Models\Link;

/**
 * Data Transfer Object for Link entity.
 */
readonly class LinkData
{
    public function __construct(
        public string  $slug,
        public string  $originalUrl,
        public int     $clicks = 0,
        public bool    $isActive = true,
        public ?Carbon $expiresAt = null,
        public ?Carbon $lastAccessed = null,
    )
    {
    }

    /**
     * Convert DTO to array for persistence.
     */
    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'original_url' => $this->originalUrl,
            'clicks' => $this->clicks,
            'is_active' => $this->isActive,
            'expires_at' => $this->expiresAt,
            'last_accessed' => $this->lastAccessed,
        ];
    }

    /**
     * Create DTO from an existing model.
     */
    public static function fromModel(Link $link): self
    {
        return new self(
            slug: $link->slug,
            originalUrl: $link->original_url,
            clicks: $link->clicks,
            isActive: $link->is_active,
            expiresAt: $link->expires_at,
            lastAccessed: $link->last_accessed,
        );
    }
}
