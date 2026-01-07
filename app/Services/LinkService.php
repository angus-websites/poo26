<?php

namespace App\Services;

use App\Contracts\LinkRepositoryInterface;
use App\Data\LinkData;
use App\Exceptions\InvalidLinkException;
use App\Exceptions\SlugException;
use App\Models\Link;
use Illuminate\Support\Carbon;

class LinkService
{
    public function __construct(
        protected LinkRepositoryInterface $linkRepository,
        protected SlugService $slugService
    )
    {
    }

    /**
     * Create a new shortened link.
     * @param string $originalUrl The original URL to shorten.
     * @return Link The created Link model.
     * @throws SlugException
     */
    public function create(string $originalUrl): Link
    {
        // Save to repository
        return $this->linkRepository->create(
            [
                'original_url' => $originalUrl,
                'slug' => $this->slugService->generate(),
            ]
        );

    }

    /**
     * Resolve a link and track access.
     *
     * @throws InvalidLinkException
     */
    public function resolve(Link $link): string
    {

        // Check if link is not active or expired
        if (!$link->is_active || ($link->expires_at && $link->expires_at->isPast())) {
            throw new InvalidLinkException(
                'The link is either inactive or has expired.'
            );
        }

        // Track access analytics
        $this->trackAccess($link);

        // Return the original URL
        return $link->original_url;
    }

    /**
     * Track access analytics for a link.
     * @param Link $link The link to track.
     * @return void
     */
    protected function trackAccess(Link $link): void
    {
        // Increment clicks
        $clicks = $link->clicks + 1;

        // Update link with new clicks and last accessed timestamp
        $this->linkRepository->update($link, [
            'clicks' => $clicks,
            'last_accessed' => Carbon::now(),
        ]);
    }



}
