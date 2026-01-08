<?php

namespace App\Contracts;

use App\Models\Slug;
use Illuminate\Support\Collection;

/**
 * Slug Repository Interface
 *
 * Defines the contract for slug data operations.
 */
interface SlugRepositoryInterface
{
    /**
     * Create a new slug
     */
    public function create(array $data): Slug;

    /**
     * Find a slug by ID.
     */
    public function findById(int $id): ?Slug;

    /**
     * Find a slug by code
     */
    public function findByCode(string $code): ?Slug;

    /**
     * Get all slugs
     */
    public function all(): Collection;

    /**
     * Update a slug
     */
    public function update(Slug $link, array $data): Slug;

    /**
     * Delete a slug.
     */
    public function delete(Slug $link): bool;
}
