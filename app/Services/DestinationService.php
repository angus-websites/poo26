<?php

namespace App\Services;

use App\Contracts\DestinationRepositoryInterface;
use App\Models\Destination;

class DestinationService
{
    public function __construct(
        protected DestinationRepositoryInterface $destinationRepository,
    ) {}

    public function create(string $originalUrl): Destination
    {
        // Compute URL hash
        $hash = hash('sha256', $originalUrl);

        // See if this URL has already been shortened
        $existing = $this->destinationRepository->findByHash($hash);

        // Return existing link if found
        if ($existing) {
            return $existing;
        }

        // Save to repository
        return $this->destinationRepository->create(
            [
                'url' => $originalUrl,
                'url_hash' => $hash,
            ]
        );
    }
}
