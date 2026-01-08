<?php

namespace App\Contracts;

use App\Models\Link;
use Illuminate\Support\Collection;

interface LinkRepositoryInterface
{
    /**
     * Create a new short link.
     */
    public function create(array $data): Link;

    /**
     * Find a link by ID.
     */
    public function findById(int $id): ?Link;

    /**
     * Find a link by slug.
     */
    public function findBySlug(string $slug): ?Link;

    /**
     * Find a link by URL hash.
     */
    public function findPermanentByHash(string $hash): ?Link;

    /**
     * Get all links (optionally paginated later).
     */
    public function all(): Collection;

    /**
     * Update a link.
     */
    public function update(Link $link, array $data): Link;

    /**
     * Delete a link.
     */
    public function delete(Link $link): bool;
}
