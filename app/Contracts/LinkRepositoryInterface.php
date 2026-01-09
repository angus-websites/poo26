<?php

namespace App\Contracts;

use App\Models\Link;
use Illuminate\Support\Collection;

interface LinkRepositoryInterface extends CodeRepositoryInterface
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
     * Find a link by the code
     */
    public function findByCode(string $code): ?Link;

    /**
     * Get all links
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
