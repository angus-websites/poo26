<?php

namespace App\Services;

use App\Contracts\LinkRepositoryInterface;
use App\Data\LinkData;
use App\Exceptions\SlugException;
use Illuminate\Support\Str;

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
     * @return LinkData The created LinkData object.
     * @throws SlugException
     */
    public function create(string $originalUrl): LinkData
    {
        // Create LinkData object
        $data = new LinkData(
            slug: $this->slugService->generate(),
            originalUrl: $originalUrl,
        );

        // Save to repository
        $link = $this->linkRepository->create($data);

        // Return LinkData from saved model
        return LinkData::fromModel($link);
    }



}
