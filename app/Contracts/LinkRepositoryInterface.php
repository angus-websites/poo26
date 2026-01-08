<?php

namespace App\Contracts;

use App\Models\Destination;
use Illuminate\Support\Collection;

interface LinkRepositoryInterface
{
    /**
     * Create a new short link.
     */
    public function create(array $data): Destination;

    /**
     * Find a link by ID.
     */
    public function findById(int $id): ?Destination;

    /**
     * Find a link by URL hash.
     */
    public function findByHash(string $hash): ?Destination;

    /**
     * Get all links (optionally paginated later).
     */
    public function all(): Collection;

    /**
     * Update a link.
     */
    public function update(Destination $link, array $data): Destination;

    /**
     * Delete a link.
     */
    public function delete(Destination $link): bool;
}
