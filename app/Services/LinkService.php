<?php

namespace App\Services;

use App\Contracts\LinkRepositoryInterface;
use App\Exceptions\CodeGeneratorException;
use App\Exceptions\InvalidLinkException;
use App\Models\Link;
use App\Services\Util\CodeGeneratorService;
use Illuminate\Support\Carbon;

class LinkService
{
    protected CodeGeneratorService $codeGeneratorService;

    public function __construct(
        protected LinkRepositoryInterface $linkRepository,
        protected DestinationService $destinationService,
    ) {
        $this->codeGeneratorService = new CodeGeneratorService($linkRepository);
    }

    /**
     * Create a new shortened link.
     *
     * @param  string  $originalUrl  The original URL to shorten.
     * @return Link The created Link model.
     *
     * @throws CodeGeneratorException
     */
    public function create(string $originalUrl): Link
    {
        // Create the destination
        $destination = $this->destinationService->create($originalUrl);

        // Generate a unique code
        $code = $this->codeGeneratorService->generate();

        // Create the link
        return $this->linkRepository->create([
            'code' => $code,
            'destination_id' => $destination->id,
            'is_active' => true,
        ]);

    }

    /**
     * Resolve a link and track access.
     *
     * @throws InvalidLinkException
     */
    public function resolve(Link $link): string
    {

        if (! $link->isActiveAndNotExpired()) {
            throw new InvalidLinkException(
                'The link is either inactive or has expired.'
            );
        }

        // Track access analytics
        $this->trackAccess($link);

        // Return the original URL
        return $link->destination->url;
    }

    /**
     * Track access analytics for a link.
     *
     * @param  Link  $link  The link to track.
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
