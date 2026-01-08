<?php

namespace App\Services;

use App\Contracts\LinkRepositoryInterface;
use App\Exceptions\InvalidLinkException;
use App\Exceptions\CodeGeneratorException;
use App\Models\Destination;
use App\Services\Util\CodeGeneratorService;
use Illuminate\Support\Carbon;

class LinkService
{
    public function __construct(
        protected LinkRepositoryInterface $linkRepository,
        protected CodeGeneratorService $codeGeneratorService
    ) {}

    /**
     * Create a new shortened link.
     *
     * @param  string  $originalUrl  The original URL to shorten.
     * @return Destination The created Link model.
     *
     * @throws CodeGeneratorException
     */
    public function create(string $originalUrl): Destination
    {

        // Compute URL hash
        $hash = hash('sha256', $originalUrl);

        // See if this URL has already been shortened
        $existing = $this->linkRepository->findPermanentByHash($hash);

        // Return existing link if found
        if ($existing) {
            return $existing;
        }

        // Save to repository
        return $this->linkRepository->create(
            [
                'original_url' => $originalUrl,
                'slug' => $this->slugService->generate(),
                'url_hash' => $hash,
            ]
        );

    }

    /**
     * Resolve a link and track access.
     *
     * @throws InvalidLinkException
     */
    public function resolve(Destination $link): string
    {

        // Check if link is not active or expired
        if (! $link->is_active || ($link->expires_at && $link->is_expired)) {
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
     *
     * @param  Destination  $link  The link to track.
     */
    protected function trackAccess(Destination $link): void
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
